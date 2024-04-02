<?php
namespace simpl\actions;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;
use simpl\includes\FlashSession;
use simpl\includes\Response as ResponseData;
use simpl\includes\Db;
use simpl\model\Media;

class MediaAction extends BaseAction {

    public function get( Request $request, Response $response, $args ): Response {
        global $app;
        $renderer = $this->container->get( 'admin-renderer' );

        $get = $request->getQueryParams();
        $data = [
            'title' => 'Media', 
            'get' => $get
        ];
        return $renderer->render( $response, '../views/admin/media.php', $data );
    }

    public function edit( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();

        $ID = $args['ID'] ?? -1;
        $title = $post['title'];
        $alt = $post['alt'];

        $media_data = [
            'title' => $title,
            'alt' => $alt
        ];

        try {
            Db::createInstance();
            Media::where( 'ID', $ID )->update( $media_data );
            
            FlashSession::set( 'message', 'Media updated successfully' );
            $response_data = new ResponseData( 200, 'Media updated successfully', [ 'redirect' => ROOT . 'admin/media' ] );
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

    public function delete( Request $request, Response $response, $args ): Response {
        $ID = $args['ID'] ?? -1;

        try{
            Db::createInstance();
            $media = Media::where( 'ID', $ID )->first();
            $filepath = $media->filepath;
            
            Media::where( 'ID', $ID )->delete();
            unlink( ABSPATH . $filepath );

            FlashSession::set( 'message', 'Media deleted succcessfully' );

        } catch( \Exception $e ) {
            FlashSession::set( 'message', 'Error: ' . $e->getMessage() );
        }

        return $response = $response
                ->withHeader( 'Location', ROOT . 'admin/media' )
                ->withStatus( 302 );
    }

    public function upload( Request $request, Response $response, $args ): Response {
        $post = $request->getParsedBody();
        $files = $request->getUploadedFiles();

        Db::createInstance();

        // Process files
        foreach( $files['file'] as $file ) {
            if( $file->getError() === UPLOAD_ERR_OK ) {
                
                $base = 'src/media/';
                $filename = self::moveUploadedFile( 'src/media', $file );
                $thumb = 'src/thumbs/' . $filename;
                self::make_thumb( file_get_contents( ABSPATH . $base . $filename ), ABSPATH . $thumb, 200 );

                $media_data = [
                    'title' => $file->getClientFilename(),
                    'alt' => '',
                    'type' => 0,
                    'filepath' => $base . $filename,
                    'thumb' => $thumb
                ];

                // Add to database
                $ID = Media::insertGetId( $media_data );

            } else {
                $response_data = new ResponseData( 500, $file->getError(), [] );
                $payload = json_encode( $response_data() );
                $response->getBody()->write( $payload );
                return $response->withHeader( 'Content-Type', 'application/json' )->withStatus( 500 );
            }
        }

        
        FlashSession::set( 'message', 'File(s) uploaded successfully' );

        $response_data = new ResponseData( 200, 'File(s) uploaded successfully', [ 'redirect' => ROOT . 'admin/media' ] );
        $payload = json_encode( $response_data() );
        $response->getBody()->write( $payload );
        return $response->withHeader( 'Content-Type', 'application/json' );
    }

    public function moveUploadedFile( string $directory, UploadedFileInterface $uploadedFile ): string {
        $extension = pathinfo( $uploadedFile->getClientFilename(), PATHINFO_EXTENSION );

        $basename = bin2hex( random_bytes(8) );
        $filename = sprintf( '%s.%0.8s', $basename, $extension );

        $uploadedFile->moveTo( ABSPATH . $directory . DIRECTORY_SEPARATOR . $filename );

        return $filename;
    }

    /**
     * Dirty
     */
    public static function make_thumb( $data, $dst, $w ) {
        $source = imagecreatefromstring( $data );
        $width = imagesx( $source );
        $height = imagesy( $source );

        $h = floor( $height * ( $w / $width ) );

        $virtual_img = imagecreatetruecolor( $w, $h );
        imagecopyresampled( $virtual_img, $source, 0, 0, 0, 0, $w, $h, $width, $height );

        imagejpeg( $virtual_img, $dst );
    }

}