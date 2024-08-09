<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function() {
    return Inertia::render('Welcome', [
        //'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
    ]);
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
    Route::get( '/admin/media', [MediaController::class, 'index'] )->name( 'media' );
    Route::get( '/admin/media/add', [MediaController::class, 'add'] )->name( 'media.add' );
    Route::post( '/admin/media', [MediaController::class, 'create'] )->name( 'media.create' );
    Route::patch( '/admin/media/{ID}', [MediaController::class, 'update'] )->name( 'media.update' );
    Route::delete( '/admin/media/{ID}', [MediaController::class, 'delete'] )->name( 'media.delete' );

    // Users
    Route::get( '/admin/users', [UserController::class, 'index'] )->name( 'user' );
    Route::get( '/admin/users/add', [UserController::class, 'add'] )->name( 'user.add' );
    Route::get( '/admin/users/{ID}', [UserController::class, 'edit'] )->name( 'user.edit' );

    Route::delete( '/admin/users/{ID}', [UserController::class, 'delete'] )->name( 'user.delete' );

    // Test
    Route::get( '/test', function() {
        return Inertia::render('Test', ['title' => 'Home']);
    } );
});

require __DIR__.'/auth.php';
