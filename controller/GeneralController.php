<?php
namespace simpl\controller;

use simpl\includes\Db;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\includes\Response as ResponseData;

class GeneralController extends BaseController {

    public function dashboard( Request $request, Response $response, $args ): Response {
        $renderer = $this->container->get( 'admin-renderer' );

        return $renderer->render( $response, '../views/admin/dashboard.php', [ 'title' => 'Dashboard' ] );
    }

    public function quickFetch( Request $request, Response $response, $args ): Response {
        $get = $request->getQueryParams();

        if( !isset($get['table']) ) {
            $response_data = new ResponseData( 500, 'No Table selected', [] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' )->withStatus( 500 );
        }

        $table = $get['table'];
        $columns = $get['columns'];
        $columns[] = 'ID';

        $manager = Db::createInstance()->getDatabaseManager();
        $items = $manager->table( $table )->get( $columns );

        $data = [];

        // Format data
        foreach( $items as $item ) {
            $row = [];
            $row['key'] = $table . '|' . $item->ID;
            foreach( $columns as $column ) {
                $row[$column] = $item->$column;
            }
            $data[] = $row;
        }

        $response_data = new ResponseData( 200, 'Updated successfully', $data );
        $payload = json_encode( $response_data() );
        $response->getBody()->write( $payload );
        return $response->withHeader( 'Content-Type', 'application/json' );
    }

}