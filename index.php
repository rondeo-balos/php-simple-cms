<?php
use DI\ContainerBuilder;
use simpl\controller\GeneralController;
use simpl\controller\InstallController;
use simpl\controller\LoginController;
use simpl\controller\PageController;
use simpl\controller\PublicController;
use simpl\controller\SeoController;
use simpl\controller\SettingsController;
use simpl\controller\UserController;
use simpl\controller\MediaController;
use simpl\includes\Auth;
use simpl\includes\Init;
use simpl\public\blocks\BlockManager;
use simpl\public\LayoutManager;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\PhpRenderer;

session_start();

// Define path
if( !defined( 'ABSPATH' ) ) { define( 'ABSPATH', __DIR__ . '/' ); }
if( !defined( 'ROOT' ) ) { define( 'ROOT', /*(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://'*/ '//' . $_SERVER['HTTP_HOST'] . '/' ); }
if( !defined( '__ROOT__' ) ) { define( '__ROOT__', /*(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://'*/ '//' . $_SERVER['HTTP_HOST'] ); }
if( !defined( '__VIEWS__' ) ) { define( '__VIEWS__', '../layout/views/' ); }

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

// App factory
AppFactory::setContainer( $container );
$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware( true, true, true );

$init = new Init( $app );
$auth = new Auth( $app );

// Ajaxes
$app->get( '/install', InstallController::class . ':get');
$app->post( '/install', InstallController::class . ':install' );
$app->get( '/admin/login', LoginController::class . ':get')->add( $init );
$app->post( '/admin/login', LoginController::class . ':login' )->add( $init );

$app->group( '/admin', function( RouteCollectorProxy $group ) {

    $group->get( '', GeneralController::class . ':dashboard');

    // Media actions
    $group->get( '/media/selectable', MediaController::class . ':selectable' );
    $group->get( '/media', MediaController::class . ':get'  );
    $group->post( '/media/create', MediaController::class . ':upload' );
    $group->post( '/media/edit/{ID}', MediaController::class . ':edit' );
    $group->get( '/media/delete/{ID}', MediaController::class . ':delete' );
    $group->map( ['POST','GET','PATCH'], '/media/regenerate', MediaController::class . ':regenerateThumbnails' );

    // Page actions
    $group->get( '/pages', PageController::class . ':get' );
    $group->get( '/pages/create', PageController::class . ':create' );
    $group->post( '/pages/create', PageController::class . ':post' );
    $group->get( '/pages/edit/{ID}', PageController::class . ':getEdit' );
    $group->post( '/pages/edit/{ID}', PageController::class . ':post' );
    $group->get( '/pages/delete/{ID}', PageController::class . ':delete' );
    $group->post( '/pages/preview', PageController::class . ':preview' );

    // User actions
    $group->get( '/users', UserController::class . ':get');
    $group->get( '/users/create', UserController::class . ':getCreate');
    $group->post( '/users/create', UserController::class . ':create' );
    $group->get( '/users/edit/{ID}', UserController::class . ':getEdit' );
    $group->post( '/users/edit/{ID}', UserController::class . ':edit' );
    $group->get( '/users/delete/{ID}', UserController::class . ':delete' );

    // Quick fetch
    $group->map(['POST','GET'], '/quick', GeneralController::class . ':quickFetch' );

    // Settings
    $group->get( '/settings', SettingsController::class . ':get' );
    $group->post( '/settings', SettingsController::class . ':post' );

    // SEO
    $group->get( '/seo', SeoController::class . ':get' );
    $group->post( '/seo', SeoController::class . ':post' );

})->add($auth);

$app->group( '/', function( RouteCollectorProxy $group ) {

    $group->get( '', PublicController::class . ':home');
    if( file_exists( ABSPATH . 'config.php' ) ) {
        PublicController::fetchPages( $group, $this );
    }

})->add( $init );

// Block Manager
$blockManager = new BlockManager;
$container->set( 'blockManager', $blockManager );

// Public renderer
$layoutManager = LayoutManager::autoload();
$renderers = $layoutManager->generateRenderers();
$container->set( 'renderers', $renderers );

$app->run();