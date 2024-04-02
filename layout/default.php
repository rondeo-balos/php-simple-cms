<?php defined( 'ABSPATH' ) || exit; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $data->title ?? '' ?></title>
        <script src="https://zeptojs.com/zepto.min.js" crossorigin="anonymous"></script>
        <script src="<?= ROOT ?>src/js/main.js"></script>
    </head>
    <body>
        <?= $content ?>
    </body>
</html>