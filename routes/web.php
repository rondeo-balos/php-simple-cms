<?php

use App\Http\Controllers\CollectionsController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get( '/admin', function() {
    return Redirect::route( 'dashboard' );
});

Route::get('/admin/dashboard', function() {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group( function() {
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware( 'auth' )->group( function() {
    // Media
    Route::get( '/admin/media', [MediaController::class, 'index'])->name( 'media' );
    Route::get( '/admin/media/add', [MediaController::class, 'add'])->name( 'media.add' );
    Route::post( '/admin/media', [MediaController::class, 'create'])->name( 'media.create' );
    Route::patch( '/admin/media/{ID}', [MediaController::class, 'update'])->name( 'media.update' );
    Route::delete( '/admin/media/{ID}', [MediaController::class, 'delete'])->name( 'media.delete' );
    Route::get( '/api/media', [MediaController::class, 'api'])->name( 'api.media' );

    // Users
    Route::get( '/admin/users', [UserController::class, 'index'])->name( 'user' );
    Route::get( '/admin/users/add', [UserController::class, 'add'])->name( 'user.add' );
    Route::get( '/admin/users/{ID}', [UserController::class, 'edit'])->name( 'user.edit' );

    Route::delete( '/admin/users/{ID}', [UserController::class, 'delete'])->name( 'user.delete' );

    // Page
    Route::get( '/admin/pages', [PageController::class, 'index'])->name( 'page' );
    Route::get( '/admin/pages/add', [PageController::class, 'add'])->name( 'page.add' );
    Route::get( '/admin/pages/{ID}', [PageController::class, 'edit'])->name( 'page.edit' );

    // Collections
    Route::get( '/admin/collections/', [CollectionsController::class, 'parent'] )->name( 'collections' );
    Route::get( '/admin/collections/{collection}', [CollectionsController::class, 'index'])->name( 'collection' );
    Route::get( '/admin/collections/{collection}/add', [CollectionsController::class, 'add'])->name( 'collection.add' );
    Route::get( '/admin/collections/{collection}/{ID}', [CollectionsController::class, 'edit'])->name( 'collection.edit' );
    Route::post( '/admin/collections/{collection}', [CollectionsController::class, 'create'])->name( 'collection.create' );
    Route::patch( '/admin/collections/{collection}/{ID}', [CollectionsController::class, 'update'])->name( 'collection.update' );
    Route::delete( '/admin/collections/{collection}/{ID}', [CollectionsController::class, 'delete'])->name( 'collection.delete' );

    // Test
    Route::get( '/preview', function() {
        return Inertia::render( 'Preview', [
            'title' => 'Preview'
        ]);
    });
    Route::get( '/test', function() {
        return Inertia::render('Test', ['title' => 'Home']);
    } );
});

require __DIR__.'/auth.php';

// Link storage for production
Route::get( '/linkstorage', function() {
    Artisan::call( 'storage:link' );
});

/**
 * Temporary routes
 */
Route::get('/', function() {
    return Inertia::render('Welcome', [
        'active' => 'home',
        'cdn' => 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/'
    ]);
})->name( 'home' );

Route::get( '/projects', function() {
    return Inertia::render( 'Soon', [
        'active' => 'projects',
        'cdn' => 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/'
    ]);
})->name( 'projects' );

Route::get( '/blog', function() {
    return Inertia::render( 'Soon', [
        'active' => 'blog',
        'cdn' => 'https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/'
    ]);
})->name( 'blog' );