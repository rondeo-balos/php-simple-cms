<?php
use simpl\includes\Db;
use simpl\includes\FlashSession;
use simpl\model\Page;
use simpl\model\Preview;
use simpl\public\LayoutManager;

defined( 'ABSPATH' ) || exit;

if( isset($ID) ) {
    Db::createInstance();
    try {
        $page = Page::findOrFail( $ID );
        $blocks = $page->blocks;

        $preview = Preview::where( 'token', '=', $page->token )->first();
        if( $preview ) {
            $data = json_decode( $preview->data );
            $blocks = $data->blocks;
        }

        $update_text = 'Update Page';
        $update_url = 'admin/pages/edit/'.$ID;
        $url = __ROOT__ . $page->path;
        $public_url = '<label>Public URL</label><br><a target="_blank" title="Opens in new tab" href="'. $url . '">' . $url . '</a>';
    } catch( \Exception $e ) {
        ?>
            <script>
                $( document ).ready( function(){
                    __message( 'Page Not Found', 'Are you sure this is the right one? It seems that we were unable to locate the page you were looking for. ', '<?= ROOT ?>admin/pages', 'Go back' );
                });
            </script>
        <?php
    }
}

$layoutManager = LayoutManager::autoload();
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/he/1.2.0/he.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.5/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.5/dist/quill.js"></script>
<link href="<?= ROOT ?>src/css/builder.css" rel="stylesheet">
<script src="<?= ROOT ?>src/js/builder.js"></script>
<script>
    const _definitions = <?= json_encode( $blockManager->definitions ) ?>;
    let _props = <?= $blocks ?? '[]' ?>;
    const builder = _initBuilder( '<?= ROOT ?>', _definitions, _props );
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
                                <button data-bs-dismiss="modal" class="border-rounded btn btn-outline-secondary d-flex justify-content-center align-items-center w-100 flex-column" onclick="javascript:builder.addBlock( '<?= $definition['name'] ?>' )">
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

<div class="modal fade modal-xl" id="getMedia" tabindex="-1" aria-labelledby="Get Media" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header p-0">
                <h2 class="h6 mb-0 p-2 ps-3">Media</h2>
                <div class="p-2 border-start rounded-0 ms-auto">
                    <button type="button" class="btn-close btn-sm m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-5">
                <iframe src="<?= ROOT ?>admin/media/selectable" style="width: 100%; height: 100%"></iframe>
            </div>
            
            <div class="modal-footer p-2">
                <button class="btn btn-primary btn-sm" data-bs-dismiss="modal" id="selectMedia">Select Media</a>
            </div>
        </div>
    </div>
</div>

<div id="alert"></div>

<form method="POST">
    <input type="hidden" name="token" value="<?= $page->token ?? '' ?>">
    <input type="hidden" name="blocks" value="<?= htmlentities($blocks) ?? '' ?>">
    <div class="row">

        <div class="col-md-2">
            <strong>Blocks</strong>
            <div class="nav flex-column nav-pills me-3 py-2" id="blocks" role="tablist" aria-orientation="vertical"> </div>
            <a href="#" data-bs-toggle="modal" data-bs-target="#addBlock" class="text-decoration-none"><ion-icon name="add-outline"></ion-icon> Add block </a>
        </div>
        
        <div class="col-md-8">
            <div class="d-flex flex-row align-items-center justify-content-center mb-3">
                <a href="<?= ROOT ?>admin/pages" class="btn btn-outline-secondary btn-sm me-2" data-bs-toggle="tooltip" title="All pages"><ion-icon name="chevron-back" size="small"></ion-icon></a>

                <input type="text" name="_title" id="_title" class="h5 border-0 p-2 m-0 focus-ring flex-fill" value="<?= $page->title ?? '' ?>" placeholder="Page Title" style="background: none; --bs-focus-ring-color: rgba(0, 0, 0, 0)" required>

                <h1 class="h5 m-0"></h1>
                <div class="flex-fill"></div>
                <a href="#" id="preview_blank" class="me-3 btn btn-outline-secondary btn-sm" target="_blank">
                    <ion-icon name="open-outline" data-bs-toggle="tooltip" title="Open preview in new tab"></ion-icon>
                </a>
                <button type="button" class="me-3 btn btn-outline-secondary btn-sm" onclick="javascript:builder.preview();">
                    <ion-icon name="refresh-outline" data-bs-toggle="tooltip" title="Reload preview"></ion-icon>
                </button>
                <button type="submit" role="submit" class="btn btn-primary btn-sm" id="create" text="<?= $update_text ?? 'Publish' ?>"><?= $update_text ?? 'Publish' ?></button>
            </div>

            <div id="preview" class="border" style="height: 80vh">
                <iframe id="preview_iframe" src="<?= ROOT ?>" style="width: 100%; height: 100%"></iframe>
            </div>
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
                                <input type="radio" class="btn-check" name="status" id="draft" value="0" autocomplete="off" <?= isset($page) ? ($page->status == 0 ? 'checked' : '') : '' ?> required>
                                <label class="btn btn-outline-primary btn-sm" for="draft">Draft</label>

                                <input type="radio" class="btn-check" name="status" id="public" value="1" autocomplete="off" <?= isset($page) ? ($page->status == 1 ? 'checked' : '') : 'checked' ?> required>
                                <label class="btn btn-outline-primary btn-sm" for="public">Public</label>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="path" class="form-label">
                                URL Path <span class="text-danger">*</span>
                                <span class="" data-bs-toggle="tooltip" title="Unique URL path of the page. The path always begins with a slash ('/') and never ends with one (e.g., '/about')">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label>
                            <input type="text" name="path" id="path" class="form-control form-control-sm" autocomplete="off" value="<?= $page->path ?? '/' ?>" required>
                        </div>
                        <div class="mb-2"><?= $public_url ?? '' ?></div>

                        <div class="form-group mb-2">
                            <label for="layout" class="form-label">Layout</label>
                            <select class="form-select form-select-sm" name="layout" id="layout">
                                <?php foreach( $layoutManager->layout as $layout ): ?>
                                    <option <?= isset($page) ? ($page->layout == $layout['name'] ? 'selected' : '') : '' ?>><?= $layout['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
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
                            <input type="text" name="title" id="title" class="form-control form-control-sm" autocomplete="off" value="<?= $page->title ?? '' ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="form-label">
                                Page description 
                                <span class="" data-bs-toggle="tooltip" title="Document description">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label>
                            <textarea name="description" id="description" class="form-control form-control-sm" autocomplete="off"><?= $page->description ?? '' ?></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">
                                Search engine visibility 
                                <span class="" data-bs-toggle="tooltip" title="test">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label><br>
                            <div class="btn-group" role="group" aria-label="Visibility">
                                <input type="radio" class="btn-check" name="visibility" id="hidden" value="noindex" autocomplete="off" <?= isset($page) ? ($page->visibility == 'noindex' ? 'checked' : '') : 'checked' ?>>
                                <label class="btn btn-outline-primary btn-sm" for="hidden">Hidden</label>

                                <input type="radio" class="btn-check" name="visibility" id="visible" value="index" autocomplete="off" <?= isset($page) ? ($page->visibility == 'index' ? 'checked' : '') : '' ?>>
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

#blocks button .block-actions {
    opacity: 0;
}
#blocks button:hover .block-actions {
    opacity: 1;
}
</style>

<script>
    $( 'form' ).on( 'submit', e => {
        e.preventDefault();
        spin( '#create' );

        $.ajax({
            url: '<?= ROOT ?><?= $update_url ?? 'admin/pages/create' ?>',
            type: 'POST',
            dataType: 'json',
            data: $( 'form' ).serialize(),
            success: res => {
                if( res.code === 200 ) {
                    __alert( '#alert', res.message, 'success' );
                    if( typeof res.data.redirect !== 'undefined' ) {
                        document.location = res.data.redirect;
                    }
                } else {
                    __alert( '#alert', res.message );
                }

                unspin( '#create' );
            },
            error: (xhr, status, error) => {
                try{ __alert( '#alert', JSON.parse(xhr.responseText).message ); } catch(e) {}
                unspin( '#create' );
            }
        } );

        return false;
    } );
    <?php if( FlashSession::hasKey( 'message' ) ): ?>
        __alert( '#alert', '<?= FlashSession::get( 'message' ) ?>', 'info' );
    <?php endif; ?>
</script>