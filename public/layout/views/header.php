<?php
defined('ABSPATH') || exit;
use simpl\includes\Db;
?>

<?php $current_path = $_SERVER['REQUEST_URI']; ?>

<nav class="navbar navbar-expand-lg py-4">
    <div class="container">
        <a class="navbar-brand" href="<?= __ROOT__ ?>">
            <img src="<?= $logo ?>" height="30px">
        </a>
        
        <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvas" aria-controls="offCanvas" aria-expanded="false" aria-label="Toggle navigation">
            <ion-icon name="menu-outline" size="large"></ion-icon>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php foreach ($settings->link as $key => $link): ?>
                    <?php
                        $path = Db::formatter($link, 'path' );
                        $active_class = $path === $current_path ? 'active': '';
                    ?>
                    <li class="nav-item px-3 <?= $active_class ?>">
                        <a class="nav-link text-uppercase p-0 py-2" aria-current="page" href="<?= __ROOT__ . $path ?>"><?= $settings->label[$key] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>


<div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvas" aria-labelledby="offCanvas">
    <div class="offcanvas-header">
        <span class="offcanvas-title" id="offCanvasLabel"></span>
        <button class="btn" type="button" data-bs-dismiss="offcanvas" aria-label="Close">
            <ion-icon name="close-outline" size="large"></ion-icon>
        </button>
    </div>
    <div class="offcanvas-body p-4">
        
        <?php foreach ($settings->link as $key => $link): ?>
            <?php
                $path = Db::formatter($link, 'path' );
                $active_class = $path === $current_path ? 'active': '';
            ?>
            <a class="nav-link text-uppercase py-2 mb-4 <?= $active_class ?>" aria-current="page" href="<?= __ROOT__ . $path ?>"><?= $settings->label[$key] ?></a>
        <?php endforeach; ?>
    </div>
</div>

<script>
    const menu = $( '.navbar-nav' );
    const menuLinks = menu.find( 'li' );
    const activeLink = menu.find( 'li.active' );

    menuLinks.each( function() {
        $(this).on( 'mouseenter', () => {
            doCalculations( $(this) );
        });
        $(this).on( 'mouseleave', () => {
            doCalculations( activeLink );
        });
    });

    const doCalculations = link => {
        console.log( $( link ).offset() );
        menu.css( '--transform-nav', `${link.find( 'a' ).position().left}px` );
        menu.css( '--transform-width', `${link.find( 'a' ).offset().width}px` );
    }

    $( window ).on( 'resize', () => {
        doCalculations( activeLink );
    });

    $( document ).ready( () => {
        doCalculations( activeLink );
    });
</script>

<style>
    ul.navbar-nav {
        position: relative;
    }
    ul.navbar-nav::before {
        content: "";
        position: absolute;
        bottom: 0px;
        left: 0px;
        transform: translateX( var(--transform-nav) );
        width: var(--transform-width);
        height: 10px;
        transition: all 0.2s ease;
        border-bottom: solid 2px #fff;
        z-index: -1;
    }
    @keyframes menuShow {
        from {
            margin-left: 100px;
            opacity: 0;
        }
        to {
            margin-left: 0px;
            opacity: 1;
        }
    }
    .offcanvas a {
        opacity: 0;
        position: relative;
    }
    .offcanvas a.active:before {
        content: "";
        left: 0px;
        bottom: 0px;
        width: 30px;
        border-bottom: solid 2px #fff;
        position:absolute;
    }
    .offcanvas.show a {
        animation-name: menuShow;
        animation-duration: 0.3s;
        animation-fill-mode: forwards;
    }

    /* Define different animation delays for each anchor element */
    .offcanvas.show a:nth-child(1) {
        animation-delay: 0.1s; /* Delay for the first anchor */
    }

    .offcanvas.show a:nth-child(2) {
        animation-delay: 0.2s; /* Delay for the second anchor */
    }

    .offcanvas.show a:nth-child(3) {
        animation-delay: 0.3s; /* Delay for the third anchor */
    }

</style>