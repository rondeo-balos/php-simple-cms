<?php

use simpl\Db;
use simpl\model\User;
use simpl\components\Table;

defined( 'ABSPATH' ) || exit;

?>

<form method="POST">
    <div class="d-flex flex-row align-items-center mb-3">
        <a href="<?= ROOT ?>admin/users" class="btn btn-outline-secondary btn-sm me-2" data-bs-toggle="tooltip" title="All users"><ion-icon name="chevron-back" size="small"></ion-icon></a>
        <h1 class="h5 m-0"><?= $title ?></h1>
        <div class="flex-fill"></div>
        <button role="submit" class="btn btn-primary btn-sm" id="create" text="Create">Create</button>
    </div>

    <div id="alert"></div>

    <div class="container-fluid border rounded bg-body">

        <div class="row">
            <div class="col-md-6 p-4">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control form-control-sm" autocomplete="off">
            </div>
            <div class="col-md-6 p-4 border-start">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control form-control-sm" autocomplete="off">
            </div>
        </div>

        <div class="row border-top">
            <div class="col-md-4 p-4">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control form-control-sm" autocomplete="off">
            </div>
            <div class="col-md-4 p-4 border-start">
                <label class="form-label">
                    Status 
                    <span class="" data-bs-toggle="tooltip" title="Determines the user's login access to the cms">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </span>
                </label><br>
                <div class="btn-group" role="group" aria-label="Status">
                    <input type="radio" class="btn-check" name="status" id="status0" value="0" autocomplete="off" checked>
                    <label class="btn btn-outline-primary btn-sm" for="status0">Inactive</label>

                    <input type="radio" class="btn-check" name="status" id="status1" value="1" autocomplete="off">
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
                    <input type="radio" class="btn-check" name="administrator" id="administrator0" value="0" autocomplete="off" checked>
                    <label class="btn btn-outline-primary btn-sm" for="administrator0">No</label>

                    <input type="radio" class="btn-check" name="administrator" id="administrator1" value="1" autocomplete="off">
                    <label class="btn btn-outline-primary btn-sm" for="administrator1">Yes</label>
                </div>
            </div>
        </div>

        <div class="row border-top">
            <div class="col-md-12 p-4">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" id="password" class="form-control form-control-sm" autocomplete="off">
            </div>
        </div>

    </div>
</form>

<script>
    $( 'form' ).on( 'submit', e => {
        e.preventDefault();
        spin( '#create' );

        $.ajax({
            url: '<?= ROOT ?>admin/users/create',
            type: 'POST',
            dataType: 'json',
            data: $( 'form' ).serialize(),
            success: res => {
                console.log( res );
                if( res.code === 200 ) {
                    document.location = '<?= ROOT ?>admin/users';
                } else {
                    __alert( '#alert', res.message );
                }

                unspin( '#create' );
            },
            error: (xhr, status, error) => {
                console.error(error); // Check for any AJAX errors
                __alert( '#alert', 'An error occurred. Please try again.' );
                unspin( '#create' );
            }
        } );

        return false;
    } );
</script>