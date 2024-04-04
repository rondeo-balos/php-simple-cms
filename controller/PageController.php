<?php
namespace simpl\controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\includes\FlashSession;
use simpl\includes\Response as ResponseData;
use simpl\includes\Db;
use simpl\model\Preview;
use simpl\model\Page;
use simpl\public\blocks\BlockManager;

class PageController extends BaseController {

    public function get( Request $request, Response $response, $args ): Response {
        $renderer = $this->container->get( 'admin-renderer' );

        $get = $request->getQueryParams();
        $data = [
            'title' => 'Pages', 
            'get' => $get
        ];
        return $renderer->render( $response, __VIEWS__ . '/pages.php', $data );
    }

    public function create( Request $request, Response $response, $args ): Response {
        $renderer = $this->container->get( 'admin-renderer' );
        $get = $request->getQueryParams();

        $blockManager = $this->container->get( 'blockManager' );
        BlockManager::autoloadBlocks( $blockManager );

        $data = [
            'title' => 'Create new page', 
            'get' => $get,
            'blockManager' => $blockManager
        ];
        return $renderer->render( $response, __VIEWS__ . '/pages-create.php', $data );
    }

    public function getEdit( Request $request, Response $response, $args ): Response {
        $ID = $args['ID'];

        $renderer = $this->container->get( 'admin-renderer' );
        $get = $request->getQueryParams();

        $blockManager = $this->container->get( 'blockManager' );
        BlockManager::autoloadBlocks( $blockManager );

        $data = [
            'title' => 'Edit page', 
            'get' => $get,
            'ID' => $ID,
            'blockManager' => $blockManager
        ];
        return $renderer->render( $response, __VIEWS__ . '/pages-create.php', $data );
    }

    public function post( Request $request, Response $response, $args ): Response {
        $ID = $args['ID'] ?? null;
        $post = $request->getParsedBody();

        $title = $post['title'];
        $description = $post['description'];
        $visibility = $post['visibility'];
        $path = $post['path'];
        $blocks = $post['blocks'];
        $layout = $post['layout'];
        $status = $post['status'];
        $token = $post['token'];

        $page_data = [
            'title' => $title,
            'description' => $description,
            'path' => $path,
            'visibility' => $visibility,
            'blocks' => $blocks,
            'layout' => $layout,
            'status' => $status,
            'token' => $token
        ];

        try {
            Db::createInstance();
            Page::updateOrInsert( ['ID' => $ID, 'token' => $token], $page_data );
            
            $data = [];
            if( is_null( $ID ) ) {
                FlashSession::set( 'message', 'Page created successfully' );
                $ID = Page::where( 'token', '=', $token )->first( ['ID'] )->ID;
                $data = [ 'redirect' => ROOT . 'admin/pages/edit/' . $ID ];
            }

            $response_data = new ResponseData( 200, 'Updated successfully', $data );
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

    public function preview( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();

        $token = $post['token'] ?? false;
        if( !$token ) {
            $token = bin2hex( random_bytes(32) );
        }

        $title = $post['title'];
        $description = $post['description'];
        $visibility = $post['visibility'];
        $path = $post['path'];
        $blocks = $post['blocks'];
        $layout = $post['layout'];
        $status = $post['status'];

        $data = [
            'title' => $title,
            'description' => $description,
            'visibility' => $visibility,
            'path' => $path,
            'blocks' => $blocks,
            'layout' => $layout,
            'status' => $status
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