<?php
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\Init;
use simpl\ajax\InstallAjax;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

// Define path
if( !defined( 'ABSPATH' ) ) { define( 'ABSPATH', __DIR__ . '/' ); }
if( !defined( 'ROOT' ) ) { define( 'ROOT', (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' ); }

require __DIR__ . '/vendor/autoload.php';
if( file_exists( ABSPATH . 'config.php' ) ) {
    require __DIR__ . '/config.php';
}
require __DIR__ . '/includes/Init.php';
require __DIR__ . '/includes/Database.php';
require __DIR__ . '/includes/Response.php';
require __DIR__ . '/model/User.php';
require __DIR__ . '/ajax/InstallAjax.php';

date_default_timezone_set( 'Asia/Manila' );

// Create container
$container = ( new ContainerBuilder() )->build();

// Define a custom renderer using the custom view template
// Admin renderer
$renderer = new PhpRenderer( 'layout', [] );
$renderer->setLayout( 'admin.php' );
$container->set( 'renderer', $renderer );
// Public renderer
$public_renderer = new PhpRenderer( 'layout', [] );
$public_renderer->setLayout( 'default.php' );
$container->set( 'public_renderer', $public_renderer );

// ROOT
$container->set( 'root', ROOT );

// App factory
AppFactory::setContainer( $container );
$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware( true, true, true );
$init = new Init();

$app->get( '/install', function( Request $request, Response $response, $args ) {
    /*if( file_exists( ABSPATH . 'config.php' ) ) {
        return $response = $response
            ->withHeader( 'Location', ROOT . 'admin' )
            ->withStatus( 302 );
    }*/

    $renderer = $this->get( 'renderer' );
    $root = $this->get( 'root' );
    return $renderer->render( $response, '../public/install.php', [ 'root' => $root ] );
});

$app->post( '/install', function( Request $request, Response $response, $args ) {
    return InstallAjax::install( $request, $response, $args );
});

$app->get( '/admin', function( Request $request, Response $response, $args ) {
    $renderer = $this->get( 'renderer' );
    return $renderer->render( $response, '../public/login.php', [] );
})->add($init);

$app->get( '/', function( Request $request, Response $response, $args ) {
    $renderer = $this->get( 'renderer' );
    return $renderer->render( $response, '../public/index.php', [] );
})->add($init);

$app->run();