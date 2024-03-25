<?php
namespace simpl\ajax;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\Response as ResponseData;
use simpl\Db;
use simpl\model\User;

class UserAjax {
    
    public static function create( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();

        $firstname = $post['firstname'];
        $lastname = $post['lastname'];
        $email = $post['email'];
        $status = $post['status'];
        $administrator = $post['administrator'];
        $password = $post['password'];

        Db::createInstance();

        $user_data = [
            'email' => $email,
            'password' => password_hash( $password, PASSWORD_DEFAULT ),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'administrator' => $administrator,
            'status' => $status
        ];
        $user = new User( $user_data );
        $user->save();

        $response_data = new ResponseData( 200, 'OK', [ $user ] );
        $payload = json_encode( $response_data() );
        $response->getBody()->write( $payload );
        return $response->withHeader( 'Content-Type', 'application/json' );
    }

    public static function edit( Request $request, Response $response, $args ): Response {
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
            $user = User::findOrFail( $ID );
            $user->update($user_data);

            $response_data = new ResponseData( 200, 'OK', [ $user ] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' );
        } catch( \Exception $e ) {
            throw $e;
        }
    }

}