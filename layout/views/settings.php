<?php
use simpl\includes\Db;
use simpl\model\Collections;
use simpl\includes\FlashSession;

defined( 'ABSPATH' ) || exit;

Db::createInstance();
$settings = Collections::where( 'name', 'settings' )->first();
$data = json_decode( $settings->data );
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
        <ul class="nav nav-tabs mt-2 px-2" id="settings" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="header" data-bs-toggle="tab" data-bs-target="#header-tab" type="button" role="tab" aria-controls="header-tab" aria-selected="true">Header</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="footer" data-bs-toggle="tab" data-bs-target="#footer-tab" type="button" role="tab" aria-controls="footer-tab" aria-selected="true">Footer</button>
            </li>
        </ul>
        <div class="tab-content px-3 py-4" id="tabContent">
            <div class="tab-pane fade show active" id="header-tab" role="tabpanel" aria-labelledby="header" tabindex="0">
                <h2 class="h6 mb-3">Menu</h2>
                <div id="menu-item" class="rounded-start-end"></div>
                <button class="btn btn-outline-primary btn-sm mt-3" id="add-menu-item">Add menu item</button>
            </div>
            <div class="tab-pane fade" id="footer-tab" role="tabpanel" aria-labelledby="footer" tabindex="0">
                <label class="form-label">Copyright text <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" name="copyright" value="<?= $data->copyright ?? '' ?>">
            </div>
        </div>
    </div>
</form>

<script>
    $( '#add-menu-item' ).click( (e) => {
        e.preventDefault();
        _addfields();
    });

    _addfields = ( link = '', label = '' ) => {
        var group = $( '<div class="border d-flex align-items-end">' );
        
        var linkLabel = $( '<label class="form-label">' );
        linkLabel.text( 'Link' );
        linkLabel.append( '<span class="text-danger">*</span>' );
        var linkInput = $( '<input type="text" list="pages" display="title" name="link[]" class="form-control form-control-sm" auto-complete="false" required>' );
        linkInput.val( link );
        group.append( $( '<div class="form-group flex-fill p-3">' ).append(linkLabel).append( linkInput ) );
        
        var labelLabel = $( '<label class="form-label">' );
        labelLabel.text( 'Label' );
        labelLabel.append( '<span class="text-danger">*</span>' );
        var labelInput = $( '<input type="text" name="label[]" class="form-control form-control-sm" auto-complete="false" required>' );
        labelInput.val( label );
        group.append( $( '<div class="form-group flex-fill p-3 border-start border-end">' ).append(labelLabel).append( labelInput ) );

        var removeBtn = $( '<button role="button" class="btn btn-outline-danger btn-sm">' );
        removeBtn.append( '<ion-icon name="trash-outline"></ion-icon>' );
        removeBtn.on( 'click', e => {
            e.preventDefault();
            var remove = confirm( 'Are you sure you want to delete?' );
            if( remove ) {
                group.remove();
            }
        });
        group.append( $( '<div class="form-group p-3">' ).append(removeBtn) );

        $( '#menu-item' ).append( group );
    }

    <?php
        foreach( $data->link as $key => $link ) {
            $label = $data->label[$key];
            echo '_addfields("' . $link . '","' . $label . '");';
        }
    ?>

    $( 'form' ).on( 'submit', e => {
        e.preventDefault();
        spin( '#save' );

        $.ajax({
            url: '<?= ROOT ?>admin/settings',
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