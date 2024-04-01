<?php
defined( 'ABSPATH' ) || exit;
?>

<script>
    const _definitions = <?= json_encode( $blockManager->definitions ) ?>;
    let _props = [];

    var index = -1;
    const _addBlock = ( name ) => {
        if( index < 0 ) {
            _props.push( _definitions[name] );
        } else {
            _props.splice( index, 0, _definitions[name] );
        }
        index = -1;
        _renderBlocks();
    }

    const _configureBlock = ( name ) => {

    }

    const _renderBlocks = () => {
        var blocks = $( '#blocks' );
        blocks.empty();
        _props.forEach( function( prop, i ) {
            
            var button = $( '<button class="btn btn-sm btn-outline-secondary border-left-0 w-100 rounded-0 mb-1 d-flex flex-row">' );
            button.text( prop.name );
            button.on( 'click', function(e) {
                e.preventDefault();
                _configureBlock( prop.name );
            });

            var icon = $( '<ion-icon size="small" class="me-2">' );
            icon.attr( 'name', prop.icon );
            button.prepend( icon );

            button.append( '<span class="flex-fill">' )

            var addBefore = $( '<ion-icon size="small" class="hover-blue" name="add-outline" data-bs-toggle="tooltip" title="Add block before">' );
            addBefore.on( 'click', function(e) {
                e.preventDefault();
                index = i;
                let myModal = new bootstrap.Modal(document.getElementById('addBlock'), {});
                myModal.show();
            });
            var deleteBlock = $( '<ion-icon size="small" class="hover-red" name="trash-outline" data-bs-toggle="tooltip" title="Delete block">' );
            deleteBlock.on( 'click', function(e) {
                e.preventDefault();
                _props.splice( i, 1 );
                _renderBlocks();
            });

            button.append( addBefore );
            button.append( deleteBlock );

            blocks.append( button );
        });
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
                    <?php foreach( $blockManager->definitions as $name => $definition ): ?>
                        <div class="col-md-2 p-2">
                            <div class="w-100 ratio ratio-1x1">
                                <button data-bs-dismiss="modal" class="border-rounded btn btn-outline-secondary d-flex justify-content-center align-items-center w-100 flex-column" onclick="javascript:_addBlock( '<?= $definition['name'] ?>' )">
                                    <div>
                                        <ion-icon name="<?= $definition['icon'] ?>" size="small"></ion-icon>
                                        <p><?= $definition['name'] ?></p>
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
            <div id="blocks" class="py-2"></div>
            <a href="#" data-bs-toggle="modal" data-bs-target="#addBlock" class="text-decoration-none"><ion-icon name="add-outline"></ion-icon> Add block </a>
        </div>
        
        <div class="col-md-8">
            <div class="d-flex flex-row align-items-center justify-content-center mb-3">
                <a href="<?= ROOT ?>admin/pages" class="btn btn-outline-secondary btn-sm me-2" data-bs-toggle="tooltip" title="All users"><ion-icon name="chevron-back" size="small"></ion-icon></a>

                <input type="text" name="title" id="title" class="h5 border-0 p-2 m-0 focus-ring flex-fill" value="" placeholder="Page Title" style="background: none; --bs-focus-ring-color: rgba(0, 0, 0, 0)">

                <h1 class="h5 m-0"></h1>
                <div class="flex-fill"></div>
                <a href="#" class="me-3 btn btn-outline-secondary btn-sm" target="_blank">
                    <ion-icon name="open-outline" data-bs-toggle="tooltip" title="Open preview in new tab"></ion-icon>
                </a>
                <button type="button" class="me-3 btn btn-outline-secondary btn-sm">
                    <ion-icon name="refresh-outline" data-bs-toggle="tooltip" title="Reload preview"></ion-icon>
                </button>
                <button role="submit" class="btn btn-primary btn-sm" id="create" text="<?= $update_text ?? 'Publish' ?>"><?= $update_text ?? 'Publish' ?></button>
            </div>

            <div id="preview" class="border" style="min-height: 80vh"></div>
        </div>
        
        <div class="col-md-2">
            <div class="h-100 border bg-body">
                <ul class="nav nav-tabs justify-content-end mt-2 px-2" id="settings" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="page" data-bs-toggle="tab" data-bs-target="#page-tab" type="button" role="tab" aria-controls="page-tab" aria-selected="true">Page</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seo" data-bs-toggle="tab" data-bs-target="#seo-tab" type="button" role="tab" aria-controls="seo-tab" aria-selected="true">SEO</button>
                    </li>
                    <li class="nav-item d-none" role="presentation">
                        <button class="nav-link" id="block" data-bs-toggle="tab" data-bs-target="#block-tab" type="button" role="tab" aria-controls="block-tab" aria-selected="true">Block</button>
                    </li>
                </ul>
                <div class="tab-content px-3 py-4" id="tabContent">
                    <div class="tab-pane fade show active" id="page-tab" role="tabpanel" aria-labelledby="page" tabindex="0">

                        <div class="form-group mb-2">
                            <label class="form-label">
                                Status 
                                <span class="" data-bs-toggle="tooltip" title="Whether the page is publicly accessible">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label><br>
                            <div class="btn-group" role="group" aria-label="Status">
                                <input type="radio" class="btn-check" name="status" id="draft" value="0" autocomplete="off"  required>
                                <label class="btn btn-outline-primary btn-sm" for="draft">Draft</label>

                                <input type="radio" class="btn-check" name="status" id="public" value="1" autocomplete="off" required checked>
                                <label class="btn btn-outline-primary btn-sm" for="public">Public</label>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="slug" class="form-label">
                                URL Path <span class="text-danger">*</span>
                                <span class="" data-bs-toggle="tooltip" title="Unique URL path of the page. The path always begins with a slash ('/') and never ends with one (e.g., '/about')">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label>
                            <input type="text" name="slug" id="slug" class="form-control form-control-sm" autocomplete="off" required value="/">
                        </div>

                    </div>
                    <div class="tab-pane fade" id="seo-tab" role="tabpanel" aria-labelledby="seo" tabindex="0">
                        <div class="form-group mb-2">
                            <label for="title" class="form-label">
                                Page title 
                                <span class="" data-bs-toggle="tooltip" title="Defines the document's title that is shown in a browser's title bar or a page's tab. Search engines typically display about the first 55-60 characters of a page title. Text beyond that may be lost, so try not to have titles longer than that. If you must use a longer title, make sure the important parts come earlier and that nothing critical is in the part of the title that is likely to be dropped.">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label>
                            <input type="text" name="title" id="title" class="form-control form-control-sm" autocomplete="off" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="form-label">
                                Page description 
                                <span class="" data-bs-toggle="tooltip" title="Document description">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label>
                            <textarea name="description" id="description" class="form-control form-control-sm" autocomplete="off" required></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">
                                Search engine visibility 
                                <span class="" data-bs-toggle="tooltip" title="test">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label><br>
                            <div class="btn-group" role="group" aria-label="Visibility">
                                <input type="radio" class="btn-check" name="visibility" id="hidden" value="noindex" autocomplete="off"  required>
                                <label class="btn btn-outline-primary btn-sm" for="hidden">Hidden</label>

                                <input type="radio" class="btn-check" name="visibility" id="visible" value="index" autocomplete="off" required checked>
                                <label class="btn btn-outline-primary btn-sm" for="visible">Visible</label>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="block-tab" role="tabpanel" aria-labelledby="block" tabindex="0">
                        ...
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<style>
.admin-sidebar {
    display: none;
}
</style>