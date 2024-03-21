<?php

use simpl\Db;
use simpl\model\User;
use simpl\components\Table;

defined( 'ABSPATH' ) || exit;

?>

<h1 class="h5"><?= $title ?></h1>

<?php
    Db::createInstance();
    $users = User::where( 'email', 'like', '%' . ($get['s'] ?? '') . '%' )
        ->orWhere( 'firstname', 'like', '%' . ($get['s'] ?? '') . '%' )
        ->orWhere( 'lastname', 'like', '%' . ($get['s'] ?? '') . '%' )
        ->paginate(
            $perPage = 8,
            $columns = ['*'],
            $pageName = 'page',
            $page = $get['page'] ?? 1
        );
    $base = ROOT . 'admin/users';
    $users->withPath( $base );
    $cols = [
        'ID' => 'ID',
        'email' => 'Email Address',
        'firstname' => 'First Name',
        'lastname' => 'Last Name',
        'administrator' => 'Administrator',
        'status' => 'Status',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At'
    ];
    $table = new Table( 'User', $users, $cols );
    $table->filter( 'users', $base . '/create' );
    $table->render( 'email', $base . '/create', $base . '/edit', $base . '/delete' );
    $table->paginate();