<?php
namespace simpl\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\includes\Response as ResponseData;
use simpl\includes\Db;
use simpl\model\Preview;

class PageAction {

    public static function preview( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();

        $token = $post['token'] ?? false;
        if( !$token ) {
            $token = bin2hex( random_bytes(32) );
        }

        $blocks = $post['blocks'];
        $status = $post['status'];
        $path = $post['path'];
        $title = $post['title'];
        $description = $post['description'];
        $visibility = $post['visibility'];

        $data = [
            'blocks' => $blocks,
            'status' => $status,
            'path' => $path,
            'title' => $title,
            'description' => $description,
            'visibility' => $visibility
        ];
        $data = json_encode( $data );

        try {
            Db::createInstance();
            Preview::updateOrInsert( ['token' => $token], [ 'data'=> $data ] );
            
            $response_data = new ResponseData( 200, 'Created / Updated preview successfully', [ 'token' => $token ] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' );

        } catch( \Exception $e ) {
            $response_data = new ResponseData( 500, $e->getMessage(), [] );
            $payload = json_encode( $response_data() );
            $response->getBody()->write( $payload );
            return $response->withHeader( 'Content-Type', 'application/json' )->withStatus( 500 );
        }

    }
}