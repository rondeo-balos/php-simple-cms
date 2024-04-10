<?php
use simpl\includes\Db;
defined( 'ABSPATH' ) || exit;
use simpl\model\Collections;

$seo = Collections::where( 'name', 'seo' )->first();
$seo = json_decode( $seo->data );

$basetitle = $seo->basetitle ?? '';
$separator = $seo->separator ?? '|';
$title = $seo->position === 'before' ? ($basetitle . ' ' . $separator . ' ' .$data->title) : ( $data->title . ' ' . $separator . ' ' . $basetitle );
$sharingimage = Db::formatter( $seo->sharingimage ?? '', 'filepath', ROOT );
$icon = Db::formatter( $seo->icon ?? '', 'filepath', ROOT );
$orgimage = Db::formatter( $seo->orgimage ?? '', 'filepath', ROOT );
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        <meta name="description" content="<?= $data->description ?? '' ?>">

        <meta name="robots" content="<?= $data->visibility ?>">
        <meta property="og:image" content="<?= $sharingimage ?>">
        <meta property="twitter:image" content="<?= $sharingimage ?>">
        <meta property="og:site_name" content="<?= $seo->basetitle ?? '' ?>">
        <meta property="og:locale" content="en">
        <meta property="og:title" content="<?= $title ?>">
        <meta property="og:description" content="<?= $data->description ?? '' ?>">
        <meta property="og:url" content="<?= $data->path ?? '' ?>">
        <meta property="twitter:title" content="<?= $title ?>">
        <meta property="twitter:description" content="<?= $data->description ?? '' ?>">
        <meta property="og:type" content="website">
        <meta property="twitter:card" content="summary_large_image">
        <link rel="icon" href="<?= $icon ?? '' ?>">

        <link rel="canonical" href="<?= __ROOT__ . $data->path ?>">
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <style>
            * {
                font-family: 'Poppins';
            }
        </style>
    </head>
    <body style="background: #070e27;">
        <div class="container">
            <?php
                $settings = Collections::where( 'name', 'settings' )->first();
                $settings = json_decode( $settings->data );
            ?>
            <?= $this->fetch( __VIEWS__ . 'header.php', ['settings' => $settings, 'logo' => $orgimage] ) ?>
            <div class="container"><?= $content ?></div>
            <?= $this->fetch( __VIEWS__ . 'footer.php', ['settings' => $settings] ) ?>
        </div>
    </body>
</html>