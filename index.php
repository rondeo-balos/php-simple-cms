<?php
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\actions\GeneralAction;
use simpl\actions\InstallAction;
use simpl\actions\LoginAction;
use simpl\actions\PageAction;
use simpl\actions\PublicAction;
use simpl\actions\UserAction;
use simpl\actions\MediaAction;
use simpl\includes\Auth;
use simpl\includes\Init;
use simpl\blocks\BlockManager;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\PhpRenderer;

session_start();

// Define path
if( !defined( 'ABSPATH' ) ) { define( 'ABSPATH', __DIR__ . '/' ); }
if( !defined( 'ROOT' ) ) { define( 'ROOT', (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' ); }

require __DIR__ . '/vendor/autoload.php';
if( file_exists( ABSPATH . 'config.php' ) ) {
    require __DIR__ . '/config.php';
}

date_default_timezone_set( 'Asia/Manila' );

// Create container
$container = ( new ContainerBuilder() )->build();

// Define a custom renderer using the custom view template
// Admin renderer
$admin_renderer = new PhpRenderer( 'layout', [] );
$admin_renderer->setLayout( 'admin.php' );
$container->set( 'admin-renderer', $admin_renderer );
// Admin full renderer
$admin_full = new PhpRenderer( 'layout', [] );
$admin_full->setLayout( 'admin-full.php' );
$container->set( 'admin-full', $admin_full );

// Public renderer
$default = new PhpRenderer( 'layout', [] );
$default->setLayout( 'default.php' );
$renderers = [
    'default' => $default
];
$container->set( 'renderers', $renderers );

// Block Manager
$blockManager = new BlockManager;
$container->set( 'blockManager', $blockManager );

// App factory
AppFactory::setContainer( $container );
$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware( true, true, true );

$init = new Init( $app );
$auth = new Auth( $app );

// Ajaxes
$app->get( '/install', InstallAction::class . ':get');
$app->post( '/install', InstallAction::class . ':install' );
$app->get( '/admin/login', LoginAction::class . ':get')->add($init);
$app->post( '/admin/login', LoginAction::class . ':login' )->add($init);

$app->group( '/admin', function( RouteCollectorProxy $group ) {

    $group->get( '', GeneralAction::class . ':dashboard');

    // Media actions
    $group->get( '/media', MediaAction::class . ':get'  );
    $group->post( '/media/create', MediaAction::class . ':upload' );
    $group->post( '/media/edit/{ID}', MediaAction::class . ':edit' );
    $group->get( '/media/delete/{ID}', MediaAction::class . ':delete' );

    // Page actions
    $group->get( '/pages', PageAction::class . ':get' );
    $group->get( '/pages/create', PageAction::class . ':create' );
    $group->post( '/pages/preview', PageAction::class . ':preview' );

    // User actions
    $group->get( '/users', UserAction::class . ':get');
    $group->get( '/users/create', UserAction::class . ':getCreate');
    $group->post( '/users/create', UserAction::class . ':create' );
    $group->get( '/users/edit/{ID}', UserAction::class . ':getEdit' );
    $group->post( '/users/edit/{ID}', UserAction::class . ':edit' );
    $group->get( '/users/delete/{ID}', UserAction::class . ':delete' );

})->add($auth);

$app->group( '/', function( RouteCollectorProxy $group ) {

    $group->get( '', PublicAction::class . ':home');
    PublicAction::fetchPages( $group, $this );

})->add( $init );

$app->run();