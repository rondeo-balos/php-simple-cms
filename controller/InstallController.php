<?php
namespace simpl\controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\model\Collections;
use simpl\model\User;
use simpl\includes\Auth;
use simpl\includes\Response as ResponseData;
use Illuminate\Database\Capsule\Manager as Manager;

class InstallController extends BaseController {

    public function get( Request $request, Response $response, $args ): Response {
        if( file_exists( ABSPATH . 'config.php' ) ) {
            return $response = $response
                ->withHeader( 'Location', ROOT . 'admin' )
                ->withStatus( 302 );
        }
    
        Auth::logout();
    
        $renderer = $this->container->get( 'admin-full' );
        return $renderer->render( $response, __VIEWS__ . '/install.php', [ 'title' => 'Simpl.Installation' ] );
    }
    
    public function install( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();
        
        try {
            $email = $post['email'];
            $password = $post['password'];
            $db_driver = $post['db_driver'];
            $db_host = $post['db_host'];
            $db_name = $post['db_name'];
            $db_username = $post['db_username'];
            $db_password = $post['db_password'];
        
            $settings = [
                'driver' => $db_driver,
                'host' => $db_host,
                'database' => '',
                'username' => $db_username,
                'password' => $db_password,
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ];
        
            // Create file if sqlite
            if( $db_driver === 'sqlite' ) {
                $db_name = ltrim($db_name, '/' );
                file_put_contents( $db_name, '' );
                $settings['database'] = $db_name;
            } else {
                $capsule = new Manager();
                $capsule->addConnection($settings);
                $capsule->setAsGlobal();
                $capsule->bootEloquent();
    
                $connection = $capsule->getConnection();
                $connection->getPdo();
                
                // Create database
                $manager = $capsule->getDatabaseManager();
                $manager->statement( 'CREATE DATABASE IF NOT EXISTS ' . $db_name );
            }


            // Re-test the connection
            $settings = [
                'driver' => $db_driver,
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
            self::createUsersTable( $manager, $db_driver );
            // Insert User
            $user_data = [
                'email' => $email,
                'password' => password_hash( $password, PASSWORD_DEFAULT ),
                'firstname' => 'Admin',
                'lastname' => '',
                'administrator' => 1,
                'status' => 1
            ];
            $user = new User( $user_data );
            $user->save();

            self::createPageTable( $manager, $db_driver );
            self::createPreviewTable( $manager, $db_driver );
            self::createMediaTable( $manager, $db_driver );
            self::createCollectionsTable( $manager, $db_driver );

            $settings = new Collections( [ 'name' => 'settings', 'data' => '{"link":[],"label":[], "copyright":""}' ] );
            $settings->save();

            $seo = new Collections( [ 'name' => 'seo', 'data' => '{"position": "before", "basetitle": "Site Title", "separator": "|", "sharingimage": "media|1", "icon": "media|1", "orgimage": "media|1"}' ] );
            $seo->save();

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $secret = '';
            for ($i = 0; $i < 32; $i++) {
                $secret .= $characters[random_int(0, $charactersLength - 1)];
            }
    
            // Create Config
            file_put_contents( 'config.php',
                "<?php\n\n" .
                "ini_set('post_max_size', '16M');\n" .
                "ini_set('upload_max_filesize', '16M');\n" .
                "\n\n" .
                "define( 'DB_DRIVER', '" . $db_driver . "' );\n" .
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
            return $response->withHeader( 'Content-Type', 'application/json' )->withStatus( 500 );
        }
    
        $payload = json_encode( (new ResponseData())() );
        $response->getBody()->write( $payload );
        return $response->withHeader( 'Content-Type', 'application/json' );
    }

    private static function createUsersTable( $manager, $driver ) {
        Manager::schema()->create( 'users', function( $table ) {
            $table->increments( 'ID' );
            $table->string( 'email' )->unique();
            $table->text( 'password' );
            $table->string( 'firstname' );
            $table->string( 'lastname' );
            $table->integer( 'administrator' )->default( 0 );
            $table->integer( 'status' )->default( 0 );
            $table->text( 'token' )->default( null );
            $table->timestamps()->default( 'CURRENT_TIMESTAMP' );
        });
        /*$create_user_table = "CREATE TABLE IF NOT EXISTS users (
            ID INTEGER PRIMARY KEY " . ($driver === 'mysql' ? 'AUTO_INCREMENT' : 'AUTOINCREMENT')  . ",
            email VARCHAR(255),
            password TEXT,
            firstname VARCHAR(255),
            lastname VARCHAR(255),
            administrator INTEGER DEFAULT 0,
            status INTEGER DEFAULT 0,
            token TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(email)
        )"; // ON UPDATE CURRENT_TIMESTAMP
        $manager->statement( $create_user_table );*/
    }

    private static function createPageTable( $manager, $driver ) {
        Manager::schema()->create( 'pages', function( $table ) {
            $table->increments( 'ID' );
            $table->string( 'title' );
            $table->string( 'description' );
            $table->string( 'visibility' );
            $table->string( 'path' )->unique();
            $table->json( 'blocks' );
            $table->json( 'fields' );
            $table->string( 'layout' )->default( 'default' );
            $table->integer( 'status' )->default( 0 );
            $table->integer( 'author' );
            $table->string( 'token' );
            $table->timestamps()->default( 'CURRENT_TIMESTAMP' );
        });
        /*$create_page_table = "CREATE TABLE IF NOT EXISTS pages (
            ID INTEGER PRIMARY KEY " . ($driver === 'mysql' ? 'AUTO_INCREMENT' : 'AUTOINCREMENT')  . ",
            title VARCHAR(255),
            description VARCHAR(255),
            visibility VARCHAR(255),
            path VARCHAR(255),
            blocks JSON,
            fields JSON,
            layout VARCHAR(255) DEFAULT 'default',
            status INTEGER DEFAULT 0,
            author INTEGER,
            token VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(path)
        )";
        $manager->statement( $create_page_table );*/
    }

    private static function createPreviewTable( $manager, $driver ) {
        Manager::schema()->create( 'previews', function( $table ) {
            $table->increments( 'ID' );
            $table->string( 'token' );
            $table->json( 'data' );
            $table->timestamps()->default( 'CURRENT_TIMESTAMP' );
        });
        /*$create_preview_table = "CREATE TABLE IF NOT EXISTS previews (
            ID INTEGER PRIMARY KEY " . ($driver === 'mysql' ? 'AUTO_INCREMENT' : 'AUTOINCREMENT')  . ",
            token VARCHAR(255),
            data JSON,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $manager->statement( $create_preview_table );*/
    }

    private static function createMediaTable( $manager, $driver ) {
        Manager::schema()->create( 'media', function( $table ) {
            $table->increments( 'ID' );
            $table->string( 'title' );
            $table->text( 'alt' );
            $table->integer( 'type' );
            $table->text( 'filepath' );
            $table->text( 'thumb' );
            $table->timestamps()->default( 'CURRENT_TIMESTAMP' );
        });
        /*$create_media_table = "CREATE TABLE IF NOT EXISTS media (
            ID INTEGER PRIMARY KEY " . ($driver === 'mysql' ? 'AUTO_INCREMENT' : 'AUTOINCREMENT')  . ",
            title VARCHAR(255),
            alt TEXT,
            type INTEGER,
            filepath TEXT,
            thumb TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $manager->statement( $create_media_table );*/
    }

    private static function createCollectionsTable( $manager, $driver ) {
        Manager::schema()->create( 'collections', function( $table ) {
            $table->increments( 'ID' );
            $table->string( 'name' );
            $table->json( 'data' );
            $table->timestamps()->default( 'CURRENT_TIMESTAMP' );
        });
        /*$create_collections_table = "CREATE TABLE IF NOT EXISTS collections(
            ID INTEGER PRIMARY KEY " . ($driver === 'mysql' ? 'AUTO_INCREMENT' : 'AUTOINCREMENT')  . ",
            name VARCHAR(255),
            data JSON,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $manager->statement( $create_collections_table );*/
    }

}