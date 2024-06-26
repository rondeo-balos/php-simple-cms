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
    </head>
    <body style="background: #070e27;">
        <div class="container">
            <?php
                $settings = Collections::where( 'name', 'settings' )->first();
                $settings = json_decode( $settings->data );
            ?>
            <div class="container"><?= $content ?></div>
        </div>
    </body>
</html>