<?php
namespace simpl;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class Auth {

    public function __construct() {}

    public function __invoke( Request $request, RequestHandler $handler ): Response {

        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();
    
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write( $existingContent );

        $authenticated = $this->authenticate($request);

        if( !$authenticated ) {
            return $response = $response
                ->withHeader( 'Location', ROOT . 'admin/login' )
                ->withStatus( 302 );
        }
    
        return $response;
    }

    public function authenticate( Request $request ) {
        $header = $request->getHeaderLine( 'Authorization' );
        $matches = [];
        preg_match( '/Bearer\s+(.*)$/i', $header, $matches );
        $token = isset($matches[1]) ? $matches[1] : null;

        if( !$token ) {
            $token = self::getSession();
            if( !$token)
                return false;
        }

        try {

            $decoded = JWT::decode( $token, new Key( SECRET, 'HS256' ) );

            $expiration = $decoded->expiration;
            if( time() > $expiration ) {
                self::logout();
                return false;
            }
            // verify

            return true;
        } catch ( \Exception $e ) {
            return false;
        }
    }

    public static function setSession( $token ) {
        $_SESSION[ 'token' ] = $token;
    }

    public static function getSession() {
        return $_SESSION[ 'token' ] ?? null;
    }

    public static function logout() {
        session_unset();
    }

}