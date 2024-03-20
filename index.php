<?php
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\ajax\InstallAjax;
use simpl\ajax\LoginAjax;
use simpl\Auth;
use simpl\Init;
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
require __DIR__ . '/includes/Init.php';
require __DIR__ . '/includes/Auth.php';
require __DIR__ . '/includes/Db.php';
require __DIR__ . '/includes/Response.php';
require __DIR__ . '/model/User.php';
require __DIR__ . '/ajax/InstallAjax.php';
require __DIR__ . '/ajax/LoginAjax.php';
require __DIR__ . '/layout/components/Pagination.php';

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
$auth = new Auth();

// Ajaxes
$app->post( '/install', InstallAjax::class . ':install' );
$app->post( '/admin/login', LoginAjax::class . ':login' )->add($init);

$app->get( '/install', function( Request $request, Response $response, $args ) {
    if( file_exists( ABSPATH . 'config.php' ) ) {
        return $response = $response
            ->withHeader( 'Location', ROOT . 'admin' )
            ->withStatus( 302 );
    }

    Auth::logout();

    $renderer = $this->get( 'public_renderer' );
    $root = $this->get( 'root' );
    return $renderer->render( $response, '../views/install.php', [ 'root' => $root, 'title' => 'Simpl.Installation' ] );
});

$app->get( '/admin/login', function( Request $request, Response $response, $args ) {
    $renderer = $this->get( 'public_renderer' );
    $root = $this->get( 'root' );

    Auth::logout();

    return $renderer->render( $response, '../views/login.php', [ 'root' => $root, 'title' => 'Simpl.Login' ] );
})->add($init);

$app->group( '/admin', function( RouteCollectorProxy $group ) {

    $group->get( '', function( Request $request, Response $response, $args ) {
        $renderer = $this->get( 'renderer' );
        $root = $this->get( 'root' );

        return $renderer->render( $response, '../views/admin/dashboard.php', [ 'root' => $root, 'title' => 'Dashboard' ] );
    });

    $group->get( '/users', function( Request $request, Response $response, $args ) {
        $renderer = $this->get( 'renderer' );
        $root = $this->get( 'root' );

        $get = $request->getQueryParams();
        $data = [
            'root' => $root,
            'title' => 'Users', 
            'get' => $get
        ];
        return $renderer->render( $response, '../views/admin/users.php', $data );
    });

})->add($init)->add($auth);

$app->get( '/', function( Request $request, Response $response, $args ) {
    $renderer = $this->get( 'public_renderer' );
    return $renderer->render( $response, '../views/index.php', [ 'title' => '' ] );
})->add($init);

$app->run();