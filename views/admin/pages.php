<?php

use simpl\Db;
use simpl\model\Page;
use simpl\components\Table;

defined( 'ABSPATH' ) || exit;

?>

<h1 class="h5"><?= $title ?></h1>

<?php
    Db::createInstance();
    $builder = Page::query();
    if( isset( $get['s'] ) ) {
        $searchTerm = '%' . ($get['s'] ?? '') . '%';
        $builder = $builder->where( 'title', 'like', $searchTerm )
            ->orWhere( 'slug', 'like', $searchTerm );
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
        'slug' => ['Slug', ''],
        'author' => ['Author', ''],
        'status' => ['Status', ['Draft', 'Published']],
        'created_at' => ['Created At', 'date'],
        'updated_at' => ['Updated At', 'date']
    ];
    $table = new Table( 'Page', $pages, $cols );
    $table->filter( 'pages', $base . '/create' );
    $table->render( 'title', $base . '/create', [
        'edit' => [
            'url' => $base . '/edit',
            'class' => 'hover-blue',
            'label' => 'Edit'
        ],
        'delete' => [
            'url' => $base . '/delete',
            'class' => 'hover-red',
            'label' => 'Delete'
        ],
        'view' => [
            'url' => $base . '/preview',
            'label' => 'View'
        ]
    ]);
    $table->paginate();