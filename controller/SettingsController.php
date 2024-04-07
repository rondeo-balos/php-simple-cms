<?php
namespace simpl\controller;

use simpl\includes\Db;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\includes\Response as ResponseData;
use simpl\model\Collections;

class SettingsController extends BaseController {

    public function get( Request $request, Response $response, $args ): Response {
        $renderer = $this->container->get( 'admin-renderer' );

        return $renderer->render( $response, __VIEWS__ . '/settings.php', [ 'title' => 'Settings' ] );
    }

    public function post( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();

        $encoded = json_encode( $post );

        Collections::updateOrInsert( ['name' => 'settings'], ['data' => $encoded] );

        $response_data = new ResponseData( 200, 'Updated successfully', [] );
        $payload = json_encode( $response_data() );
        $response->getBody()->write( $payload );
        return $response->withHeader( 'Content-Type', 'application/json' );
    }

}