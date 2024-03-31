<?php
defined( 'ABSPATH' ) || exit;
?>

<script>
    const definitions = <?= json_encode( $blockManager ) ?>
    let props = [];
    const _addBlock = ( props ) => {
        props.push( props );
    }

    const _renderBlocks() {
        
    }
</script>

<div class="modal fade modal-lg" id="addBlock" tabindex="-1" aria-labelledby="Add Block" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0">
                <h2 class="h6 mb-0 p-2 ps-3">Add block</h2>
                <div class="p-2 border-start rounded-0 ms-auto">
                    <button type="button" class="btn-close btn-sm m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-2 px-3">
                <div class="row">
                    <?php foreach( $blockManager->blocks as $block ): ?>
                        <div class="col-md-2 p-2">
                            <div class="w-100 ratio ratio-1x1">
                                <button class="border-rounded btn btn-outline-secondary d-flex justify-content-center align-items-center w-100 flex-column" onclick="javascript:_addBlock( <?= json_encode( $block['props'] ) ?> )">
                                    <div>
                                        <ion-icon name="<?= $block['icon'] ?>" size="small"></ion-icon>
                                        <p><?= $block['name'] ?></p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<form method="POST">
    <div class="row">

        <div class="col-md-2">
            <strong>Blocks</strong>
            <div id="blocks"></div>
            <a href="#" data-bs-toggle="modal" data-bs-target="#addBlock"><ion-icon name="add-outline"></ion-icon> Add block </a>
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