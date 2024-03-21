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

        Db::createInstance();
        $user = User::where( 'email', $email )->first();

        if( $user) {
            if( password_verify( $password, $user->password ) && $user->administrator == 1 && $user->status == 1 ) {

                $user = [
                    'email' => $user->email,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname
                ];
                $issued = time();
                $expiration = $issued + 3600; // 1 hour expiration
                if( $remember )
                    $expiration += 604800000; //(3600 * 24 * 7); // 1 Week expiration 604800000
                
                $payload = [
                    'user' => $user,
                    'issued' => $issued,
                    'expiration' => $expiration
                ];

                $token = JWT::encode( $payload, SECRET, 'HS256' );
                Auth::setSession( $token );
                User::where( 'email', $email )->update( ['token' => $token] );

                $response_data = new ResponseData( 200, 'Authenticated', [ 'token' => $token ] );
                $payload = json_encode( $response_data() );
                $response->getBody()->write( $payload );
                return $response->withHeader( 'Content-Type', 'application/json' );
            } elseif ( $user->administrator == 0 ) { // No access
                $_SESSION[ 'token' ] = '';
                $response_data = new ResponseData( 401, 'You don\'t have access. Please contact administrator' );
                $payload = json_encode( $response_data() );
                $response->getBody()->write( $payload );
                return $response->withHeader( 'Content-Type', 'application/json' );

            } elseif( $user->status == 0 ) { // User not verified
                $_SESSION[ 'token' ] = '';
                $response_data = new ResponseData( 401, 'User not verified. Please contact administrator.' );
                $payload = json_encode( $response_data() );
                $response->getBody()->write( $payload );
                return $response->withHeader( 'Content-Type', 'application/json' );

            } else { // Invalid credentials
                $_SESSION[ 'token' ] = '';
                $response_data = new ResponseData( 401, 'Invalid password' );
                $payload = json_encode( $response_data() );
                $response->getBody()->write( $payload );
                return $response->withHeader( 'Content-Type', 'application/json' );

            }
        } else { // No user
            $_SESSION[ 'token' ] = '';
            $response_data = new ResponseData( 404, 'Email not found' );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' );

        }
    }

}