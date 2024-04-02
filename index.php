<?php
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use simpl\actions\InstallAction;
use simpl\actions\LoginAction;
use simpl\actions\PageAction;
use simpl\actions\UserAction;
use simpl\actions\MediaAction;
use simpl\includes\Auth;
use simpl\includes\Db;
use simpl\includes\Init;
use simpl\model\Page;
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
$app->post( '/install', InstallAction::class . ':install' );
$app->post( '/admin/login', LoginAction::class . ':login' )->add($init);

$app->get( '/install', function( Request $request, Response $response, $args ) {
    if( file_exists( ABSPATH . 'config.php' ) ) {
        return $response = $response
            ->withHeader( 'Location', ROOT . 'admin' )
            ->withStatus( 302 );
    }

    Auth::logout();

    $renderer = $this->get( 'admin-full' );
    return $renderer->render( $response, '../views/install.php', [ 'title' => 'Simpl.Installation' ] );
});

$app->get( '/admin/login', function( Request $request, Response $response, $args ) {
    $renderer = $this->get( 'admin-full' );

    Auth::logout();

    return $renderer->render( $response, '../views/login.php', [ 'title' => 'Simpl.Login' ] );
})->add($init);

$app->group( '/admin', function( RouteCollectorProxy $group ) {

    $group->get( '', function( Request $request, Response $response, $args ) {
        $renderer = $this->get( 'admin-renderer' );

        return $renderer->render( $response, '../views/admin/dashboard.php', [ 'title' => 'Dashboard' ] );
    });

    $group->get( '/media', function( Request $request, Response $response, $args ) {
        $renderer = $this->get( 'admin-renderer' );

        $get = $request->getQueryParams();
        $data = [
            'title' => 'Media', 
            'get' => $get
        ];
        return $renderer->render( $response, '../views/admin/media.php', $data );
    });

    $group->post( '/media/create', MediaAction::class . ':upload' );
    $group->post( '/media/edit/{ID}', MediaAction::class . ':edit' );
    $group->get( '/media/delete/{ID}', MediaAction::class . ':delete' );

    $group->get( '/pages', function( Request $request, Response $response, $args ) {
        $renderer = $this->get( 'admin-renderer' );

        $get = $request->getQueryParams();
        $data = [
            'title' => 'Pages', 
            'get' => $get
        ];
        return $renderer->render( $response, '../views/admin/pages.php', $data );
    });

    $group->get( '/pages/create', function( Request $request, Response $response, $args ) {
        $renderer = $this->get( 'admin-renderer' );

        $get = $request->getQueryParams();

        $blockManager = $this->get( 'blockManager' );
        BlockManager::autoloadBlocks( $blockManager );

        $data = [
            'title' => 'Create new page', 
            'get' => $get,
            'blockManager' => $blockManager
        ];
        return $renderer->render( $response, '../views/admin/pages-create.php', $data );
    });

    $group->post( '/pages/preview', PageAction::class . ':preview' );

    $group->get( '/users', function( Request $request, Response $response, $args ) {
        $renderer = $this->get( 'admin-renderer' );

        $get = $request->getQueryParams();
        $data = [
            'title' => 'Users', 
            'get' => $get
        ];
        return $renderer->render( $response, '../views/admin/users.php', $data );
    });

    $group->get( '/users/create', function( Request $request, Response $response, $args ) {
        $renderer = $this->get( 'admin-renderer' );

        $get = $request->getQueryParams();
        $data = [
            'title' => 'Create new user', 
            'get' => $get
        ];
        return $renderer->render( $response, '../views/admin/users-create.php', $data );
    });

    $group->post( '/users/create', UserAction::class . ':create' );

    $group->get( '/users/edit/{ID}', function( Request $request, Response $response, $args ) {
        $ID = $args['ID'];

        $renderer = $this->get( 'admin-renderer' );
        $get = $request->getQueryParams();
        $data = [
            'title' => 'Edit user',
            'get' => $get,
            'ID' => $ID
        ];
        return $renderer->render( $response, '../views/admin/users-create.php', $data );
    });

    $group->post( '/users/edit/{ID}', UserAction::class . ':edit' );
    $group->get( '/users/delete/{ID}', UserAction::class . ':delete' );

})->add($auth);

$app->group( '/', function( RouteCollectorProxy $group ) {

    $group->get( '', function( Request $request, Response $response, $args ) {
        $renderer = $this->get( 'renderers' )['default'];
        $get = $request->getQueryParams();
    
        /**
         * For preview
         */
        if( isset( $get['__p'] ) ) {
            return $renderer->render( $response, '../views/preview.php', [ 'get' => $get ] );
        }
    
        try {
            Db::createInstance();
            $data = Page::where( 'path', '=', '/' )->firstOrFail();
            return $renderer->render( $response, '../views/index.php', [ 'get' => $get, 'data' => $data ] );
        } catch( \Exception $e ) {}
    
        // for actual document
        return $renderer->render( $response, '../views/404.php', [] );
    });

    // Query all pages
    Db::createInstance();
    $pages = Page::where( 'path', '<>', '/' )
        ->where( 'status', '=', 1 )
        ->get( ['*'] );
    foreach( $pages as $page ) {
        $group->map( ['GET', 'POST'], ltrim( $page->path, '/' ), function( Request $request, Response $response, array $args) use ($page) {
            $renderer = $this->get( 'renderers' )['default'];
            $get = $request->getQueryParams();

            return $renderer->render( $response, '../views/index.php', [ 'get' => $get, 'data' => $page ] );
        });
    }

})->add( $init );

$app->run();