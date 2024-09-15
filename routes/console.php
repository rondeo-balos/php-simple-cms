<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

// php artisan storage:link

Artisan::command( 'register:admin {name} {email} {password}', function( string $name, string $email, string $password ) {
    $this->info( 'Creating admin: ' . $name . '(' . $email . ')' );
    User::factory()->create([
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]);
    $this->info( 'Admin successfully created! You can now login on the frontend.' );
})->purpose( 'Create an administrator account' );