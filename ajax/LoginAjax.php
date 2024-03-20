<?php
namespace simpl\ajax;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\Response as ResponseData;
use simpl\Auth;
use simpl\Db;
use simpl\model\User;

class LoginAjax {

    public static function login( Request $request, Response $response, $args ): Response {

        $post = $request->getParsedBody();
        
        $email = $post['email'];
        $password = $post['password'];
        $remember = $post['remember'] ?? false;

        $capsule = Db::createInstance();

        $results = $capsule->table('users')->where( 'email', $email )->get();

        if( sizeof($results) > 0 ) {
            $user = $results[0];
            if( password_verify( $password, $user->password )) {

                $user = [
                    'email' => $user->email,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname
                ];
                $issued = time();
                $expiration = $issued + 3600; // 1 hour expiration
                if( $remember )
                    $expiration += (3600 * 24 * 7); // 1 Week expiration 604800000
                
                $payload = [
                    'user' => $user,
                    'issued' => $issued,
                    'expiration' => $expiration
                ];

                $token = JWT::encode( $payload, SECRET, 'HS256' );
                Auth::setSession( $token );

                $response_data = new ResponseData( 200, 'Authenticated', [ 'token' => $token ] );
                $payload = json_encode( $response_data() );
                $response->getBody()->write( $payload );
                return $response->withHeader( 'Content-Type', 'application/json' );

            } else {
                $_SESSION[ 'token' ] = '';

                $response_data = new ResponseData( 401, 'Invalid password' );
                $payload = json_encode( $response_data() );
                $response->getBody()->write( $payload );
                return $response->withHeader( 'Content-Type', 'application/json' );
            }
        } else {
            $_SESSION[ 'token' ] = '';
            
            $response_data = new ResponseData( 404, 'Email not found' );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' );
        }
    }

}