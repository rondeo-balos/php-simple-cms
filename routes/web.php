<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        //'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
    ]);
});

Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group( function () {
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware( 'auth' )->group( function() {
    Route::get( '/admin/media', [MediaController::class, 'index'] )->name( 'media' );
    Route::get( '/admin/media/add', [MediaController::class, 'add'] )->name( 'media.add' );
    Route::post( '/admin/media', [MediaController::class, 'create'] )->name( 'media.create' );
    Route::patch( '/admin/media/{ID}', [MediaController::class, 'update'] )->name( 'media.update' );
    Route::delete( '/admin/media/{ID}', [MediaController::class, 'delete'] )->name( 'media.delete' );
});

require __DIR__.'/auth.php';
