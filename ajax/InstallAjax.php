<?php
namespace simpl\ajax;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\model\User;
use simpl\Response as ResponseData;
use simpl\Database;
use \Exception as Exception;

class InstallAjax {
    
    public static function install( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();
        
        $email = $post['email'];
        $password = $post['password'];
        $db_host = $post['db_host'];
        $db_name = $post['db_name'];
        $db_username = $post['db_username'];
        $db_password = $post['db_password'];
    
        $database = new Database;
        $database->test_connection( $db_host, $db_username, $db_password );
    
        try {
            $connection = $database->capsule->getConnection();
            $connection->getPdo();
    
            // Create database
            $capsule = $database->capsule;
            $manager = $capsule->getDatabaseManager();
            $manager->statement( 'CREATE DATABASE IF NOT EXISTS ' . $db_name );
    
            // Re-test the connection
            $database->test_connection( $db_host, $db_username, $db_password, $db_name );
            $capsule = $database->capsule;
            $manager = $capsule->getDatabaseManager();
    
            // Add tables to the database
            $create_user_table = 'CREATE TABLE IF NOT EXISTS users (
                ID int AUTO_INCREMENT PRIMARY KEY,
                email varchar(255),
                password text,
                firstname varchar(255),
                lastname varchar(255),
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
    
            // Create Config
            file_put_contents( 'config.php',
                "<?php\n\n" .
                "define( 'DB_NAME', 'database' );\n" .
                "define( 'DB_USERNAME', 'username' );\n" .
                "define( 'DB_PASSWORD', 'password' );\n" .
                "define( 'DB_HOST', 'localhost' );\n"
            );
    
        } catch( Exception $e ) {
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