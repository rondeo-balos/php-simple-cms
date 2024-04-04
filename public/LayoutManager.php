<?php
namespace simpl\public;
use Slim\Views\PhpRenderer;

class LayoutManager {

    public $layout = [];

    public static function autoload(): LayoutManager {
        $layoutManager = new LayoutManager;

        $directory = __DIR__ . '/layout';

        $files = scandir( $directory );
        $phpFiles = array_filter( $files, function($file) {
            return pathinfo( $file, PATHINFO_EXTENSION) === 'php';
        });

        foreach( $phpFiles as $file ) {
            $layoutManager->layout[] = [
                'name' => pathinfo( $file, PATHINFO_FILENAME ),
                'file' => $file
            ];
        }

        return $layoutManager;
    }

    public function generateRenderers(): array {
        $renderers = [];
        foreach( $this->layout as $layout ) {
            $renderer = new PhpRenderer( 'public/layout', [] );
            $renderer->setLayout( $layout['file'] );
            $renderers[$layout['name']] = $renderer;
        }

        return $renderers;
    }
}