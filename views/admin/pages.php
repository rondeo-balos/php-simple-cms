<?php

use simpl\Db;
use simpl\model\Page;
use simpl\components\Table;

defined( 'ABSPATH' ) || exit;

?>

<h1 class="h5"><?= $title ?></h1>

<div class="d-flex flex-row justify-content-between align-items-center mb-4">

    <div style="width: 400px;">
        <div class="input-group">
            <input type="text" class="form-control form-control-sm" placeholder="Search pages" aria-label="Search pages" aria-describedby="search-button">
            <button class="btn btn-outline-primary btn-sm" aria-labelledby="Search button"><ion-icon name="search"></ion-icon></button>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center">
        <a href="#" class="me-3"><ion-icon name="funnel"></ion-icon></a>
        <a href="#" class="me-3"><ion-icon name="list"></ion-icon></a>
        <a href="<?= ROOT ?>admin/pages/create" class="btn btn-primary btn-sm">Add Page</a>
    </div>
</div>

<?php
    Db::createInstance();
    $pages = Page::paginate(
        $perPage = 8,
        $columns = ['*'],
        $pageName = 'page',
        $page = $get['page'] ?? 1
    );
    $pages->withPath( ROOT . 'admin/pages' );

    $cols = [
        'title' => 'Title',
        'slug' => 'Slug',
        'author' => 'Author',
        'status' => 'Status',
        'created_at' => 'Created At'
    ];
    Table::render( $pages, 'title', $cols );
?>