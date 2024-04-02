<?php
namespace simpl\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GeneralAction extends BaseAction {

    public function dashboard( Request $request, Response $response, $args ): Response {
        $renderer = $this->container->get( 'admin-renderer' );

        return $renderer->render( $response, '../views/admin/dashboard.php', [ 'title' => 'Dashboard' ] );
    }

}