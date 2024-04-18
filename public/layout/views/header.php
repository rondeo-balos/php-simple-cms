<?php
defined('ABSPATH') || exit;
use simpl\includes\Db;
?>

<nav class="navbar navbar-expand-lg py-4">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="<?= $logo ?>" height="30px">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php foreach ($settings->link as $key => $link): ?>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase ms-4" aria-current="page" href="<?= Db::formatter($link, 'path', __ROOT__) ?>"><?= $settings->label[$key] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>