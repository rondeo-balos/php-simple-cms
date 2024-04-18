<?php defined( 'ABSPATH' ) || exit; ?>

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
                        <a href="" class="btn btn-sm btn-primary next-step">Start the installation &rarr;</a>
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
                        
                        <a href="" class="btn btn-sm btn-secondary prev-step">&larr; Back</a> 
                        <a href="" class="btn btn-sm btn-primary next-step">Next &rarr;</a>
                    </div>

                    <div class="col p-4 step overflow-hidden d-none">
                        <h2 class="h4">Database Setup</h2>
                        <p>Configure your database connection for Simpl.CMS.</p>

                        <div class="form-group mb-3">
                            <label for="db_driver" class="mb-1">Database Driver</label>
                            <select id="db_driver" class="form-select" name="db_driver">
                                <option value="mysql">MySQL</option>
                                <option value="sqlite">SQLite</option>
                            </select>
                        </div>

                        <div class="form-group mb-3 _db_host" >
                            <label for="db_host" class="mb-1">Database Host </label>
                            <input type="text" class="form-control" id="db_host" name="db_host" placeholder="Host" value="localhost" required>
                        </div>

                        <div class="form-group mb-3 _db_name" >
                            <label for="db_name" class="mb-1">Database Name  / Path</label>
                            <input type="text" class="form-control" id="db_name" name="db_name" placeholder="Database" required>
                        </div>

                        <div class="form-group mb-3 _db_username" >
                            <label for="db_username" class="mb-1">Database Username </label>
                            <input type="text" class="form-control" id="db_username" name="db_username" placeholder="Username" required>
                        </div>

                        <div class="form-group mb-3 _db_password" >
                            <label for="db_password" class="mb-1">Database Password </label>
                            <input type="text" class="form-control" id="db_password" name="db_password" placeholder="Password" required>
                        </div>

                        <a href="" class="btn btn-sm btn-secondary prev-step">&larr; Back</a> 
                        <a href="" class="btn btn-sm btn-primary next-step">Next &rarr;</a>
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
                                <th>Database Driver</th><td class="db_driver"></td>
                            </tr>
                            <tr>
                                <th>Database Host</th><td class="db_host"></td>
                            </tr>
                            <tr>
                                <th>Database Name / Path</th><td class="db_name"></td>
                            </tr>
                            <tr>
                                <th>Database Username</th><td class="db_username"></td>
                            </tr>
                            <tr>
                                <th>Database Password</th><td class="db_password"></td>
                            </tr>
                        </table>
                        
                        <a href="" class="btn btn-sm btn-secondary prev-step">&larr; Back</a> 
                        <button type="submit" role="submit" class="btn btn-sm btn-primary">Let's go</a>
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

    
    $( '#db_driver' ).on( 'change', e => {
        var value = $( '#db_driver' ).val();
        switch ( value ) {
            case 'sqlite':
                $( '._db_host' ).hide();
                $( '#db_host' ).val( 'null' );
                $( '._db_username' ).hide();
                $( '#db_username' ).val( 'null' );
                $( '._db_password' ).hide();
                $( '#db_password' ).val( 'null' );
                break;
            default:
                $( '._db_host' ).show();
                $( '#db_host' ).val( '' );
                $( '._db_username' ).show();
                $( '#db_username' ).val( '' );
                $( '._db_password' ).show();
                $( '#db_password' ).val( '' );
                break;
        }
    });

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
                try{ __alert( '#alert', JSON.parse(xhr.responseText).message ); } catch(e) {}
            }
        } );

        return false;
    } );
</script>