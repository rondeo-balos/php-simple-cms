<?php

use simpl\Db;
use simpl\FlashSession;
use simpl\model\User;
use simpl\components\Table;

defined( 'ABSPATH' ) || exit;

?>

<h1 class="h5"><?= $title ?></h1>

<div id="alert"></div>

<?php
    Db::createInstance();
    $builder = User::query();
    if( isset( $get['s'] ) ) {
        $searchTerm = '%' . ($get['s'] ?? '') . '%';
        $builder = $builder->where( 'email', 'like', $searchTerm )
            ->orWhere( 'firstname', 'like', $searchTerm )
            ->orWhere( 'lastname', 'like', $searchTerm );
    }
    if( isset( $get['column'] ) && isset( $get['operator'] ) && isset( $get['value'] ) ) {
        foreach( $get['column'] as $key => $column ) {
            $builder = $builder->where( $column, $get['operator'][$key], $get['value'][$key] );
        }
    }
    $users = $builder->paginate(
        $perPage = 8,
        $columns = ['*'],
        $pageName = 'page',
        $page = $get['page'] ?? 1
    );
    $base = ROOT . 'admin/users';
    $users->withPath( $base );
    $cols = [
        'ID' => ['ID', ''], // this is normal
        'email' => ['Email Address', ''], // normal
        'firstname' => ['First Name', ''], // normal
        'lastname' => ['Last Name', ''], // normal
        'administrator' => ['Administrator', 'bool'], // no = 0, yes = 1
        'status' => ['Status', ['Inactive', 'Active']], // no = 0, yes = 1
        'created_at' => ['Created At', 'date'], // formatted
        'updated_at' => ['Updated At', 'date'], // formatted
    ];
    $table = new Table( 'User', $users, $cols );
    $table->filter( 'users', $base . '/create' );
    $table->render( 'email', $base . '/create', [
        'edit' => [
            'url' => $base . '/edit/{{ID}}',
            'class' => 'hover-blue',
            'label' => 'Edit'
        ],
        'delete' => [
            'url' => $base . '/delete/{{ID}}',
            'class' => 'hover-red',
            'label' => 'Delete'
        ]
    ]);
    $table->paginate();
?>
<script>
    <?php if( FlashSession::hasKey( 'message' ) ): ?>
        __alert( '#alert', '<?= FlashSession::get( 'message' ) ?>', 'info' );
    <?php endif; ?>
</script>