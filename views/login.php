<?php defined( 'ABSPATH' ) || exit; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

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
            url: '<?= $root ?>admin/login',
            type: 'POST',
            dataType: 'json',
            data: $( 'form' ).serialize(),
            success: res => {
                console.log( res );
                if( res.code === 200 ) {
                    document.location = '<?= $root ?>admin';
                } else {
                    __alert( '#alert', res.message );
                }

                unspin( '#signin' );
            },
            error: (xhr, status, error) => {
                console.error(error); // Check for any AJAX errors
                __alert( '#alert', 'An error occurred. Please try again.' );
            }
        } );

        return false;
    } );
</script>