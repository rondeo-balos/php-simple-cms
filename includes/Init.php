<?php
namespace simpl;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Pagination\Paginator;

class Init {
    private $app;

    public function __construct( $app ) {
        $this->app = $app;
    }

    public function __invoke( Request $request, RequestHandler $handler ): Response {
        $response = $this->app->getResponseFactory()->createResponse();
        $response->getBody()->write( '' );

        if( !file_exists( ABSPATH . 'config.php' ) ) {
            return $response = $response
                ->withHeader( 'Location', ROOT . 'install' )
                ->withStatus( 302 );
        }

        $response = $handler->handle($request);

        return $response;
    }
}