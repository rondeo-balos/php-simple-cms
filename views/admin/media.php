<?php

use simpl\includes\Db;
use simpl\model\Media;
use simpl\components\Grid;
use simpl\includes\FlashSession;

defined( 'ABSPATH' ) || exit;

?>

<h1 class="h5"><?= $title ?></h1>

<div id="alert"></div>

<form method="POST" id="upload">
    <input type="file" id="file" name="file[]" class="d-none" accept="image/png, image/jpeg, image/webp" multiple="multiple">
    <script>
        function _upload() {
            $( '#file' ).trigger( 'click' );
        }

        $( '#file' ).on( 'change', function(e) {
            $( '#upload' ).submit();
        });

        $( '#upload' ).on( 'submit', e => {
            e.preventDefault();
            spin( '#create' );

            $.ajax({
                url: '<?= ROOT ?>admin/media/create',
                type: 'POST',
                data: new FormData( document.getElementById("upload") ),
                processData: false,  // Prevent zepto from processing the data
                contentType: false,  // Prevent zepto from setting contentType
                success: res => {
                    console.log( res );
                    if( res.code === 200 ) {
                        //document.location = '<?= ROOT ?>admin/users';
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
                    console.error(error); // Check for any AJAX errors
                    __alert( '#alert', error );
                    unspin( '#create' );
                }
            });

            return false;
        });
    </script>
</form>

<form method="POST" id="edit">
    <div class="modal fade modal-sm" id="editModal" tabindex="-1" aria-labelledby="Edit Media" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h2 class="h6 mb-0 p-2 ps-3">Edit file</h2>
                    <div class="p-2 border-start rounded-0 ms-auto">
                        <button type="button" class="btn-close btn-sm m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body p-2">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Title <ion-icon name="help-circle-outline" data-bs-toggle="tooltip" data-bs-title="For accessibility purposes"></ion-icon></label>
                        <input type="text" name="title" id="title" class="form-control form-control-sm" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label for="alt" class="form-label">Alt Text <ion-icon name="help-circle-outline" data-bs-toggle="tooltip" data-bs-title="For SEO purposes"></ion-icon></label>
                        <input type="text" name="alt" id="alt" class="form-control form-control-sm" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button role="submit" class="btn btn-primary btn-sm">Save</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( document ).ready( () => {
            $( '[href*="edit"]' ).click( function(e) {
                e.preventDefault();
                
                let link = $(this).attr( 'href' );
                let alertModal = $( '#editModal' );
                let targetID = $( this ).attr( 'target' );

                alertModal.find( '#title' ).val( $( targetID ).attr( 'title' ) );
                alertModal.find( '#alt' ).val( $( targetID ).attr( 'alt' ) );

                let modal = new bootstrap.Modal( document.getElementById( 'editModal' ) );
                modal.show();
                
                $( '#edit' ).attr( 'action', link );
            });
        });

        $( '#edit' ).on( 'submit', e => {
            e.preventDefault();
            spin( '#create' );

            $.ajax({
                url: $( '#edit' ).attr( 'action' ),
                type: 'POST',
                data: $( '#edit' ).serialize(),
                success: res => {
                    console.log( res );
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
                    console.error(error); // Check for any AJAX errors
                    __alert( '#alert', error );
                    unspin( '#create' );
                }
            });

            return false;
        });
    </script>
</form>

<?php
    Db::createInstance();
    $builder = Media::query();
    if( isset( $get['s'] ) ) {
        $searchTerm = '%' . ($get['s'] ?? '') . '%';
        $builder = $builder->where( 'filepath', 'like', $searchTerm )
            ->orWhere( 'title', 'like', $searchTerm )
            ->orWhere( 'alt', 'like', $searchTerm );
    }
    $builder = $builder->orderByDesc( 'created_at' );
    if( isset( $get['column'] ) && isset( $get['operator'] ) && isset( $get['value'] ) ) {
        foreach( $get['column'] as $key => $column ) {
            $builder = $builder->where( $column, $get['operator'][$key], $get['value'][$key] );
        }
    }
    $media = $builder->paginate(
        $perPage = 12,
        $columns = ['*'],
        $pageName = 'page',
        $page = $get['page'] ?? 1
    );
    $base = ROOT . 'admin/media';
    $media->withPath( $base );
    $cols = [
        'ID' => ['ID', ''], // this is normal
        'title' => ['Title', ''], // normal
        'alt' => ['Alt Text', ''], // normal
        'type' => [ 'Type', ['File', 'Folder']], // File or Folder
        'filepath' => ['Filepath', ''], // normal
        'created_at' => ['Created At', 'date'], // formatted
        'updated_at' => ['Updated At', 'date'], // formatted
    ];
    $table = new Grid( 'Media', $media, $cols );
    $table->filter( 'media', 'javascript:_upload();' );
    $table->render( 'title', 'javascript:_upload();', [
        'edit' => [
            'url' => $base . '/edit/{{ID}}',
            'class' => 'btn-outline-primary',
            'label' => '<ion-icon name="pencil-outline"></ion-icon>'
        ],
        'delete' => [
            'url' => $base . '/delete/{{ID}}',
            'class' => 'btn-outline-danger',
            'label' => '<ion-icon name="trash-outline"></ion-icon>'
        ]
    ]);
    $table->paginate();
?>
<script>
    <?php if( FlashSession::hasKey( 'message' ) ): ?>
        __alert( '#alert', '<?= FlashSession::get( 'message' ) ?>', 'info' );
    <?php endif; ?>
</script>