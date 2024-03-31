<?php

use simpl\Db;
use simpl\FlashSession;
use simpl\model\User;

defined( 'ABSPATH' ) || exit;

if( isset($ID) ) {
    Db::createInstance();
    try{ 
        $user = User::findOrFail( $ID );
        $fullname = '<span class="text-primary">' . $user->firstname.' '.$user->lastname . '</span>';
        $update_text = 'Update';
        $password_class = 'col-md-10 d-none border-start password-container';
        $new_password = 'New Password';
        $update_url = 'admin/users/edit/'.$ID;
    } catch( \Exception $e ) {
        
    }
}

?>

<form method="POST">
    <div class="d-flex flex-row align-items-center mb-3">
        <a href="<?= ROOT ?>admin/users" class="btn btn-outline-secondary btn-sm me-2" data-bs-toggle="tooltip" title="All users"><ion-icon name="chevron-back" size="small"></ion-icon></a>
        <h1 class="h5 m-0"><?= $title ?> <?= $fullname ?? '' ?></h1>
        <div class="flex-fill"></div>
        <button role="submit" class="btn btn-primary btn-sm" id="create" text="<?= $update_text ?? 'Create' ?>"><?= $update_text ?? 'Create' ?></button>
    </div>

    <div id="alert"></div>

    <div class="container-fluid border rounded bg-body">

        <div class="row">
            <div class="col-md-6 p-4">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control form-control-sm" autocomplete="off" required value="<?= $user->firstname ?? '' ?>">
            </div>
            <div class="col-md-6 p-4 border-start">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control form-control-sm" autocomplete="off" required value="<?= $user->lastname ?? '' ?>">
            </div>
        </div>

        <div class="row border-top">
            <div class="col-md-4 p-4">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control form-control-sm" autocomplete="off" value="<?= $user->email ?? '' ?>">
            </div>
            <div class="col-md-4 p-4 border-start">
                <label class="form-label">
                    Status 
                    <span class="" data-bs-toggle="tooltip" title="Determines the user's login access to the cms">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </span>
                </label><br>
                <div class="btn-group" role="group" aria-label="Status">
                    <input type="radio" class="btn-check" name="status" id="status0" value="0" autocomplete="off"  required <?= isset($user) ? ($user->status == 0 ? 'checked' : '') : 'checked' ?>>
                    <label class="btn btn-outline-primary btn-sm" for="status0">Inactive</label>

                    <input type="radio" class="btn-check" name="status" id="status1" value="1" autocomplete="off" required <?= isset($user) ? ($user->status == 1 ? 'checked' : '') : '' ?>>
                    <label class="btn btn-outline-primary btn-sm" for="status1">Active</label>
                </div>
            </div>
            <div class="col-md-4 p-4 border-start">
                <label class="form-label">
                    Administrator 
                    <span class="" data-bs-toggle="tooltip" title="Administrator have all privileges within the CMS, regardless of their role and capabilities">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </span>
                </label><br>
                <div class="btn-group" role="group" aria-label="Administrator">
                    <input type="radio" class="btn-check" name="administrator" id="administrator0" value="0" autocomplete="off" required <?= isset($user) ? ($user->administrator == 0 ? 'checked' : '') : 'checked' ?>>
                    <label class="btn btn-outline-primary btn-sm" for="administrator0">No</label>

                    <input type="radio" class="btn-check" name="administrator" id="administrator1" value="1" autocomplete="off" required <?= isset($user) ? ($user->administrator == 1 ? 'checked' : '') : '' ?>>
                    <label class="btn btn-outline-primary btn-sm" for="administrator1">Yes</label>
                </div>
            </div>
        </div>

        <div class="row border-top">
            <?php if( isset( $user ) ): ?>
                <div class="col-md-2 p-4">
                    <label class="form-label">
                        Change Password 
                    </label><br>
                    <div class="btn-group" role="group" aria-label="Change Password">
                        <input type="radio" class="btn-check" name="change" id="change0" value="0" autocomplete="off" required checked>
                        <label class="btn btn-outline-primary btn-sm" for="change0">No</label>

                        <input type="radio" class="btn-check" name="change" id="change1" value="1" autocomplete="off" required>
                        <label class="btn btn-outline-primary btn-sm" for="change1">Yes</label>
                    </div>
                </div>
                <script>
                    $( '[name="change"]' ).on( 'change', function(e) {
                        $( '.password-container' ).toggleClass( 'd-none' );
                        if( $( '#change0' ).is( ':checked' ) ) {
                            $( '#create' ).removeAttr( 'disabled' );
                        } else {
                            $( '#create' ).attr( 'disabled', true );
                        }
                    });
                </script>
            <?php endif; ?>
            <div class="<?= $password_class ?? 'col-md-12' ?> p-4">
                <label for="password" class="form-label"><?= $new_password ?? 'Password' ?> <span class="text-danger">*</span></label>
                <input type="password" name="password" id="password" class="form-control form-control-sm" autocomplete="new-password" validate-password="true">
                <div class="form-text text-danger"></div>
            </div>
        </div>

    </div>
</form>

<script>

    

    $( 'form' ).on( 'submit', e => {
        e.preventDefault();
        spin( '#create' );

        $.ajax({
            url: '<?= ROOT ?><?= $update_url ?? 'admin/users/create' ?>',
            type: 'POST',
            //dataType: 'json',
            data: $( 'form' ).serialize(),
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
        } );

        return false;
    } );
    <?php if( FlashSession::hasKey( 'message' ) ): ?>
        __alert( '#alert', '<?= FlashSession::get( 'message' ) ?>', 'info' );
    <?php endif; ?>
</script>