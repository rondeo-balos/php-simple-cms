<?php
namespace simpl\controller;

use simpl\includes\Db;
use simpl\model\Page;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\model\Preview;
use Slim\Routing\RouteCollectorProxy;
use Psr\Container\ContainerInterface;

class PublicController extends BaseController{

    public function home( Request $request, Response $response, $args ): Response {
        $get = $request->getQueryParams();
    
        try {
            Db::createInstance();
            if( isset( $get['__p'] ) ) {
                $preview = Preview::where( 'token', '=', $get['__p'] )->firstOrFail();
                $data = json_decode( $preview->data );
            } else {
                $data = Page::where( 'path', '=', '/' )->firstOrFail();
            }
            $renderer = $this->container->get( 'renderers' )[$data->layout];
            return $renderer->render( $response, 'views/index.php', [ 'get' => $get, 'data' => $data ] );
        } catch( \Exception $e ) {}
    
        // for actual document
        $renderer = $this->container->get( 'renderers' )['default'];
        return $renderer->render( $response, 'views/404.php', [] );
    }

    public static function fetchPages( RouteCollectorProxy $group, ContainerInterface $container ) {
        // Query all pages
        Db::createInstance();
        $pages = Page::where( 'path', '<>', '/' )
            ->where( 'status', '=', 1 )
            ->get( ['*'] );
        foreach( $pages as $page ) {
            $group->map( ['GET', 'POST'], ltrim( $page->path, '/' ), function( Request $request, Response $response, array $args) use ($page, $container) {
                $get = $request->getQueryParams();
                $renderer = $container->get( 'renderers' )[$page->layout];
                return $renderer->render( $response, 'views/index.php', [ 'get' => $get, 'data' => $page ] );
            });
        }
    }
}