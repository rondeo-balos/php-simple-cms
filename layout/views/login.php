<?php defined( 'ABSPATH' ) || exit; ?>

<div class="container-fluid">
    <div class="row justify-content-center min-vh-100">
        <div class="col-md-3 align-self-center">
            
            <form method="POST">
                <div class="d-flex flex-column-reverse flex-md-row bg-gray border rounded overflow-hidden justify-content-between">
                    <div class="col px-3 py-4">

                        <div id="alert"></div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control " id="email" name="email" placeholder="Email">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control " id="password" name="password" placeholder="password">
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="signin" text="Sign in">Sign in</button>
                        </div>

                    </div>
                </div>
            </form>
        
        </div>
    </div>
</div>

<script>
    $( 'form' ).on( 'submit', e => {
        e.preventDefault();
        spin( '#signin' );

        $.ajax({
            url: '<?= ROOT ?>admin/login',
            type: 'POST',
            dataType: 'json',
            data: $( 'form' ).serialize(),
            success: res => {
                if( res.code === 200 ) {
                    document.location = '<?= ROOT ?>admin';
                } else {
                    __alert( '#alert', res.message );
                }

                unspin( '#signin' );
            },
            error: (xhr, status, error) => {
                //console.error(error); // Check for any AJAX errors
                try{ __alert( '#alert', JSON.parse(xhr.responseText).message ); } catch(e) {}
                unspin( '#signin' );
            }
        } );

        return false;
    } );
</script>