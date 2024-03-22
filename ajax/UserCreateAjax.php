<?php
namespace simpl\ajax;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\Response as ResponseData;
use simpl\Db;
use simpl\model\User;

class UserCreateAjax {
    
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

        $response_data = new ResponseData( 200, 'Authenticated', [ $user ] );
        $payload = json_encode( $response_data() );
        $response->getBody()->write( $payload );
        return $response->withHeader( 'Content-Type', 'application/json' );
    }

}