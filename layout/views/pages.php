<?php

use simpl\includes\Db;
use simpl\model\Page;
use simpl\includes\FlashSession;
use simpl\components\Table;

defined( 'ABSPATH' ) || exit;

?>

<h1 class="h5"><?= $title ?></h1>

<div id="alert"></div>

<?php
    Db::createInstance();
    $builder = Page::query();
    if( isset( $get['s'] ) ) {
        $searchTerm = '%' . ($get['s'] ?? '') . '%';
        $builder = $builder->where( 'title', 'like', $searchTerm )
            ->orWhere( 'path', 'like', $searchTerm );
    }
    if( isset( $get['column'] ) && isset( $get['operator'] ) && isset( $get['value'] ) ) {
        foreach( $get['column'] as $key => $column ) {
            $builder = $builder->where( $column, $get['operator'][$key], $get['value'][$key] );
        }
    }
    $pages = $builder->paginate(
        $perPage = 8,
        $columns = ['*'],
        $pageName = 'page',
        $page = $get['page'] ?? 1
    );
    $base = ROOT . 'admin/pages';
    $pages->withPath( $base );
    $cols = [
        'ID' => ['ID', ''],
        'title' => ['Title', ''],
        'description' => ['Description', ''],
        'visibility' => ['Visibility', ''],
        'path' => ['Path', ''],
        'status' => ['Status', ['Draft', 'Published']],
        'author' => ['Author', ''],
        'created_at' => ['Created At', 'date'],
        'updated_at' => ['Updated At', 'date']
    ];
    $table = new Table( 'Page', $pages, $cols );
    $table->filter( 'pages', $base . '/create' );
    $table->render( 'title', $base . '/create', [
        'edit' => [
            'url' => $base . '/edit/{{ID}}',
            'class' => 'hover-blue',
            'label' => 'Edit'
        ],
        'delete' => [
            'url' => $base . '/delete/{{ID}}',
            'class' => 'hover-red',
            'label' => 'Delete'
        ],
        'view' => [
            'url' => ROOT . '?__p={{token}}',
            'label' => 'View'
        ]
    ]);
    $table->paginate();
?>

<script>
    <?php if( FlashSession::hasKey( 'message' ) ): ?>
        __alert( '#alert', '<?= FlashSession::get( 'message' ) ?>', 'info' );
    <?php endif; ?>
</script>