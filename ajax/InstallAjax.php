<?php
namespace simpl\ajax;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\model\User;
use simpl\Response as ResponseData;
use Illuminate\Database\Capsule\Manager as Manager;

class InstallAjax {
    
    public static function install( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();
        
        $email = $post['email'];
        $password = $post['password'];
        $db_host = $post['db_host'];
        $db_name = $post['db_name'];
        $db_username = $post['db_username'];
        $db_password = $post['db_password'];
    
        $settings = [
            'driver' => 'mysql',
            'host' => $db_host,
            'database' => '',
            'username' => $db_username,
            'password' => $db_password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ];

        $capsule = new Manager();
        $capsule->addConnection($settings);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    
        try {
            $connection = $capsule->getConnection();
            $connection->getPdo();
    
            // Create database
            $manager = $capsule->getDatabaseManager();
            $manager->statement( 'CREATE DATABASE IF NOT EXISTS ' . $db_name );
    
            // Re-test the connection
            $settings = [
                'driver' => 'mysql',
                'host' => $db_host,
                'database' => $db_name,
                'username' => $db_username,
                'password' => $db_password,
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ];
    
            $capsule = new Manager();
            $capsule->addConnection($settings);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
            $manager = $capsule->getDatabaseManager();
    
            // Add tables to the database
            $create_user_table = 'CREATE TABLE IF NOT EXISTS users (
                ID int AUTO_INCREMENT PRIMARY KEY,
                email varchar(255),
                password text,
                firstname varchar(255),
                lastname varchar(255),
                token text DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE(email)
            )';
            $manager->statement( $create_user_table );
    
            // Insert User
            $user_data = [
                'email' => $email,
                'password' => password_hash( $password, PASSWORD_DEFAULT ),
                'firstname' => 'Admin',
                'lastname' => ''
            ];
            $user = new User( $user_data );
            $user->save();

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $secret = '';
            for ($i = 0; $i < 32; $i++) {
                $secret .= $characters[random_int(0, $charactersLength - 1)];
            }
    
            // Create Config
            file_put_contents( 'config.php',
                "<?php\n\n" .
                "define( 'DB_NAME', '" . $db_name . "' );\n" .
                "define( 'DB_USERNAME', '" . $db_username . "' );\n" .
                "define( 'DB_PASSWORD', '" . $db_password . "' );\n" .
                "define( 'DB_HOST', '" . $db_host . "' );\n" .
                "\n" .
                "define( 'SECRET', '" . $secret . "' );\n"
            );
    
        } catch( \Exception $e ) {
            $response_data = new ResponseData( 500, $e->getMessage() );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' );
        }
    
        $payload = json_encode( (new ResponseData())() );
        $response->getBody()->write( $payload );
        return $response->withHeader( 'Content-Type', 'application/json' );
    }

}