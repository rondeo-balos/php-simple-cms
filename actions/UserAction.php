<?php
namespace simpl\actions;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\includes\FlashSession;
use simpl\includes\Response as ResponseData;
use simpl\includes\Db;
use simpl\model\User;

class UserAction {

    private $container;

    // constructor receives container instance
    public function __construct( ContainerInterface $container ) {
        $this->container = $container;
    }

    public function get( Request $request, Response $response, $args ): Response {
        $renderer = $this->container->get( 'admin-renderer' );

        $get = $request->getQueryParams();
        $data = [
            'title' => 'Users', 
            'get' => $get
        ];
        return $renderer->render( $response, '../views/admin/users.php', $data );
    }

    public function getCreate( Request $request, Response $response, $args ) {
        $renderer = $this->container->get( 'admin-renderer' );

        $get = $request->getQueryParams();
        $data = [
            'title' => 'Create new user', 
            'get' => $get
        ];
        return $renderer->render( $response, '../views/admin/users-create.php', $data );
    }
    
    public function create( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();

        $firstname = $post['firstname'];
        $lastname = $post['lastname'];
        $email = $post['email'];
        $status = $post['status'];
        $administrator = $post['administrator'];
        $password = $post['password'];
        
        $user_data = [
            'email' => $email,
            'password' => password_hash( $password, PASSWORD_DEFAULT ),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'administrator' => $administrator,
            'status' => $status
        ];
        
        try {
            Db::createInstance();
            $ID = User::insertGetId( $user_data );
            FlashSession::set( 'message', 'User created successfully' );

            $response_data = new ResponseData( 200, 'User created successfully', [ 'redirect' => ROOT . 'admin/users/edit/' . $ID ] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' );
        }catch( \Exception $e ) {
            $response_data = new ResponseData( 500, $e->getMessage(), [] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' )->withStatus( 500 );
        }
        
    }

    public function getEdit( Request $request, Response $response, $args ): Response {
        $ID = $args['ID'];

        $renderer = $this->container->get( 'admin-renderer' );
        $get = $request->getQueryParams();
        $data = [
            'title' => 'Edit user',
            'get' => $get,
            'ID' => $ID
        ];
        return $renderer->render( $response, '../views/admin/users-create.php', $data );
    }

    public function edit( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();

        $ID = $args['ID'] ?? -1;
        $firstname = $post['firstname'];
        $lastname = $post['lastname'];
        $email = $post['email'];
        $status = $post['status'];
        $administrator = $post['administrator'];
        $change = $post['change'];
        $password = $post['password'];

        $user_data = [
            'email' => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'administrator' => $administrator,
            'status' => $status
        ];

        if( $change == 1 ) {
            $user_data['password'] = password_hash( $password, PASSWORD_DEFAULT );
        }

        try{
            Db::createInstance();
            User::where( 'ID', $ID )->update( $user_data );

            $response_data = new ResponseData( 200, 'User updated sucessfully', [] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' );
        } catch( \Exception $e ) {
            $response_data = new ResponseData( 500, $e->getMessage(), [] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' )->withStatus( 500 );
        }
    }

    public function delete( Request $request, Response $response, $args ): Response {
        $ID = $args['ID'] ?? -1;

        try{
            Db::createInstance();
            User::where( 'ID', $ID )->delete();

            FlashSession::set( 'message', 'User deleted succcessfully' );
            /*$response_data = new ResponseData( 200, 'User deleted sucessfully', [ 'redirect' => ROOT . 'admin/users' ] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' );*/
        } catch( \Exception $e ) {
            FlashSession::set( 'message', 'Error: ' . $e->getMessage() );
            /*$response_data = new ResponseData( 500, $e->getMessage(), [] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' )->withStatus( 500 );*/
        }

        return $response = $response
                ->withHeader( 'Location', ROOT . 'admin/users' )
                ->withStatus( 302 );
    }

}