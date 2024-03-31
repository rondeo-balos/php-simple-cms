<?php defined( 'ABSPATH' ) || exit; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<div class="container-fluid">
    <div class="row justify-content-center min-vh-100">
        <div class="col-md-5 align-self-center">

            <img src="<?= ROOT ?>src/images/Simpl.CMS_Logo.png" width="300px">

            <div id="alert"></div>
            
            <form method="POST">
                <div class="d-flex flex-column-reverse flex-md-row bg-gray border rounded overflow-hidden justify-content-between">

                    <div class="col p-4 step overflow-hidden d-block">
                        <h1 class="h4">Installation</h1>
                        <p>Welcome to the Simpl.CMS installation process. Just fill in the information provided on the next page and you'll be on your way to using the most Simple CMS in the world.</p>
                        <div class="h6">Steps</div>
                        <ul>
                            <li>Admin account creation</li>
                            <li>Database Setup</li>
                            <li>Review</li>
                        </ul>
                        <p>Are you ready?</p>
                        <a href="" class="btn btn-sm btn-outline-secondary next-step">Start the installation &rarr;</a>
                    </div>
                    
                    <div class="col p-4 step overflow-hidden d-none">
                        <h2 class="h4">Admin Account</h2>
                        <p>Create your administrator account for Simpl.CMS</p>
                        
                        <div class="form-group mb-3">
                            <label for="email" class="mb-1">Email </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email@domain.ltd" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="mb-1">New Password </label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Password" validate-password="true" required>
                        </div>
                        
                        <a href="" class="btn btn-sm btn-outline-secondary prev-step">&larr; Back</a> 
                        <a href="" class="btn btn-sm btn-outline-secondary next-step">Next &rarr;</a>
                    </div>

                    <div class="col p-4 step overflow-hidden d-none">
                        <h2 class="h4">Database Setup</h2>
                        <p>Configure your database connection for Simpl.CMS.</p>

                        <div class="form-group mb-3">
                            <label for="db_host" class="mb-1">Database Host </label>
                            <input type="text" class="form-control" id="db_host" name="db_host" placeholder="Host" value="localhost" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="db_name" class="mb-1">Database Name </label>
                            <input type="text" class="form-control" id="db_name" name="db_name" placeholder="Database" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="db_username" class="mb-1">Database Username </label>
                            <input type="text" class="form-control" id="db_username" name="db_username" placeholder="Username" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="db_password" class="mb-1">Database Password </label>
                            <input type="text" class="form-control" id="db_password" name="db_password" placeholder="Password" required>
                        </div>

                        <a href="" class="btn btn-sm btn-outline-secondary prev-step">&larr; Back</a> 
                        <a href="" class="btn btn-sm btn-outline-secondary next-step">Next &rarr;</a>
                    </div>
                    
                    <div class="col p-4 step overflow-hidden d-none">
                        <h2 class="h4">Almost There</h2>
                        <p>Please review the important details</p>
                        
                        <table class="table mb-3">
                            <tr>
                                <th>Email</th><td class="email"></td>
                            </tr>
                            <tr>
                                <th>Password</th><td><span class="password d-none"></span> <i>Your chosen password</i></td>
                            </tr>
                            <tr>
                                <th>Database Host</th><td class="db_host"></td>
                            </tr>
                            <tr>
                                <th>Database Name</th><td class="db_name"></td>
                            </tr>
                            <tr>
                                <th>Database Username</th><td class="db_username"></td>
                            </tr>
                            <tr>
                                <th>Database Password</th><td class="db_password"></td>
                            </tr>
                        </table>
                        
                        <a href="" class="btn btn-sm btn-outline-secondary prev-step">&larr; Back</a> 
                        <button role="submit" class="btn btn-sm btn-outline-primary">Let's go</a>
                    </div>

                    <div class="col-4" style="background-image: url(<?= ROOT ?>src/images/pattern.png); background-repeat: no-repeat; background-size: cover; background-position: center;">
                        <div style="height: 50px"></div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    var index = 0;

    const step = (increment) => {
        $($( '.step' )[index]).toggleClass( 'd-block' );
        $($( '.step' )[index]).toggleClass( 'd-none' );
        index += increment;
        $($( '.step' )[index]).toggleClass( 'd-block' );
        $($( '.step' )[index]).toggleClass( 'd-none' );
    };

    $( '.next-step' ).forEach(element => {
        element.onclick = (e) => {
            e.preventDefault();
            fillReview();
            var readyToNext = true;
            $( '.step:nth-of-type(' + (index + 1) + ') .form-control' ).forEach( element => {
                if( element.value.length <= 0 )
                    readyToNext = false;
            } );
            if( readyToNext ) {
                step(1);
            } else {
                __alert( '#alert', 'Please fill the blank fields' );
            }
        }
    });

    $( '.prev-step' ).forEach(element => {
        element.onclick = (e) => {
            e.preventDefault();
            step(-1);
        }
    });

    const fillReview = () => {
        $( '.form-control' ).forEach( element => {
            var name = element.getAttribute( 'name' );
            document.querySelector( '.' + name ).innerHTML = element.value;
        } );
    };

    $( 'form' ).on( 'submit', e => {
        e.preventDefault();

        $.ajax({
            url: '<?= ROOT ?>install',
            type: 'POST',
            dataType: 'json',
            data: $( 'form' ).serialize(),
            success: res => {
                console.log( res );
                if( res.code === 200 ) {
                    document.location = '<?= ROOT ?>admin';
                } else {
                    __alert( '#alert', res.message );
                }
            },
            error: (xhr, status, error) => {
                console.error(error); // Check for any AJAX errors
                __alert( '#alert', 'An error occurred. Please try again.' );
            }
        } );

        return false;
    } );
</script>