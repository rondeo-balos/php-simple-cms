<?php
defined( 'ABSPATH' ) || exit;
?>

<form method="POST">
    <div class="row">

        <div class="col-md-2">
            <strong>Blocks</strong>
        </div>
        
        <div class="col-md-8">
            <div class="d-flex flex-row align-items-center mb-3">
                <a href="<?= ROOT ?>admin/pages" class="btn btn-outline-secondary btn-sm me-2" data-bs-toggle="tooltip" title="All users"><ion-icon name="chevron-back" size="small"></ion-icon></a>
                <h1 class="h5 m-0"><?= $title ?> <?= $page_title ?? '' ?></h1>
                <div class="flex-fill"></div>
                <a href="#" class="me-3 btn btn-outline-secondary btn-sm" target="_blank">
                    <ion-icon name="open-outline" data-bs-toggle="tooltip" title="Open preview in new tab"></ion-icon>
                </a>
                <button type="button" class="me-3 btn btn-outline-secondary btn-sm">
                    <ion-icon name="refresh-outline" data-bs-toggle="tooltip" title="Reload preview"></ion-icon>
                </button>
                <button role="submit" class="btn btn-primary btn-sm" id="create" text="<?= $update_text ?? 'Publish' ?>"><?= $update_text ?? 'Publish' ?></button>
            </div>
        </div>
        
        <div class="col-md-2"></div>

    </div>
</form>

<style>
.admin-sidebar {
    display: none;
}
</style>