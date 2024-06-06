<?php
use simpl\includes\Db;
use simpl\model\Collections;
use simpl\includes\FlashSession;

defined( 'ABSPATH' ) || exit;

Db::createInstance();
$seo = Collections::where( 'name', 'seo' )->first();
$data = json_decode( $seo->data );
?>

<div id="alert"></div>

<form>
    <div class="d-flex flex-row justify-content-between align-items-center mb-4">

        <h1 class="h5"><?= $title ?></h1>

        <div class="d-flex flex-row align-items-center">
            <button role="submit" id="save" class="btn btn-primary btn-sm" text="Save">Save</button>
        </div>
    </div>

    <div class="border bg-body">
        <ul class="nav nav-tabs mt-2 px-2" id="seo" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general" data-bs-toggle="tab" data-bs-target="#general-tab" type="button" role="tab" aria-controls="general-tab" aria-selected="true">General</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="images" data-bs-toggle="tab" data-bs-target="#images-tab" type="button" role="tab" aria-controls="images-tab" aria-selected="true">Images</button>
            </li>
        </ul>
        <div class="tab-content" id="tabContent">
            <div class="tab-pane fade show active" id="general-tab" role="tabpanel" aria-labelledby="general" tabindex="0">

                <div class="row">
                    <div class="col-md-8 p-4">
                        <label for="basetitle" class="form-label">Base Title</label>
                        <input type="text" name="basetitle" id="basetitle" class="form-control form-control-sm" autocomplete="off" required value="<?= $data->basetitle ?? '' ?>">
                    </div>
                    <div class="col-md-2 p-4 border-start border-end">
                        <label for="separator" class="form-label">Title Separator</label>
                        <input type="text" name="separator" id="separator" class="form-control form-control-sm" autocomplete="off" required value="<?= $data->separator ?? '|' ?>">
                    </div>
                    <div class="col-md-2 p-4">
                        <label class="form-label">
                            Base Title Position
                        </label><br>
                        <div class="btn-group" role="group" aria-label="Base Title Position">
                            <input type="radio" class="btn-check" name="position" id="before" value="before" autocomplete="off" required <?= isset($data->position) ? ($data->position == 'before' ? 'checked' : '') : 'checked' ?>>
                            <label class="btn btn-outline-primary btn-sm" for="before">Before</label>

                            <input type="radio" class="btn-check" name="position" id="after" value="after" autocomplete="off" required <?= isset($data->position) ? ($data->position == 'after' ? 'checked' : '') : '' ?>>
                            <label class="btn btn-outline-primary btn-sm" for="after">After</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="images-tab" role="tabpanel" aria-labelledby="images" tabindex="0">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group p-4">
                            <label class="form-label">Default Sharing Image</label>
                            <input type="text" class="form-control form-control-sm mb-2" name="sharingimage" value="<?= $data->sharingimage ?? '' ?>" show="media" readonly>
                            <img class="media-preview img-thumbnail" src="<?= Db::formatter( $data->sharingimage ?? '', 'filepath', ROOT ) ?>">
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <div class="form-group p-4 border-start">
                            <label class="form-label">Logo</label>
                            <input type="text" class="form-control form-control-sm mb-2" name="orgimage" value="<?= $data->orgimage ?? '' ?>" show="media" readonly>
                            <img class="media-preview img-thumbnail" src="<?= Db::formatter( $data->orgimage ?? '', 'filepath', ROOT ) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group p-4 border-start">
                            <label class="form-label">Favicon</label>
                            <input type="text" class="form-control form-control-sm mb-2" name="icon" value="<?= $data->icon ?? '' ?>" show="media" readonly>
                            <img class="media-preview img-thumbnail" src="<?= Db::formatter( $data->icon ?? '', 'filepath', ROOT ) ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

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

<script>
    $( 'form' ).on( 'submit', e => {
        e.preventDefault();
        spin( '#save' );

        $.ajax({
            url: '<?= ROOT ?>admin/seo',
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

                unspin( '#save' );
            },
            error: (xhr, status, error) => {
                try{ __alert( '#alert', JSON.parse(xhr.responseText).message ); } catch(e) {}
                unspin( '#save' );
            }
        } );

        return false;
    } );
    <?php if( FlashSession::hasKey( 'message' ) ): ?>
        __alert( '#alert', '<?= FlashSession::get( 'message' ) ?>', 'info' );
    <?php endif; ?>
</script>