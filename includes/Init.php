<?php
namespace simpl;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Pagination\Paginator;

class Init {

    public function __invoke( Request $request, RequestHandler $handler ): Response {
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();
    
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write( $existingContent );

        if( !file_exists( ABSPATH . 'config.php' ) ) {
            return $response = $response
                ->withHeader( 'Location', ROOT . 'install' )
                ->withStatus( 302 );
        }

        return $response;
    }
}