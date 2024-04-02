<?php
namespace simpl\actions;

use simpl\includes\Db;
use simpl\model\Page;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Psr\Container\ContainerInterface;

class PublicAction extends BaseAction{

    public function home( Request $request, Response $response, $args ): Response {
        $renderer = $this->container->get( 'renderers' )['default'];
        $get = $request->getQueryParams();
    
        /**
         * For preview
         */
        if( isset( $get['__p'] ) ) {
            return $renderer->render( $response, '../views/preview.php', [ 'get' => $get ] );
        }
    
        try {
            Db::createInstance();
            $data = Page::where( 'path', '=', '/' )->firstOrFail();
            return $renderer->render( $response, '../views/index.php', [ 'get' => $get, 'data' => $data ] );
        } catch( \Exception $e ) {}
    
        // for actual document
        return $renderer->render( $response, '../views/404.php', [] );
    }

    public static function fetchPages( RouteCollectorProxy $group, ContainerInterface $container ) {
        // Query all pages
        Db::createInstance();
        $pages = Page::where( 'path', '<>', '/' )
            ->where( 'status', '=', 1 )
            ->get( ['*'] );
        foreach( $pages as $page ) {
            $group->map( ['GET', 'POST'], ltrim( $page->path, '/' ), function( Request $request, Response $response, array $args) use ($page, $container) {
                $renderer = $container->get( 'renderers' )['default'];
                $get = $request->getQueryParams();

                return $renderer->render( $response, '../views/index.php', [ 'get' => $get, 'data' => $page ] );
            });
        }
    }
}