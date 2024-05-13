<?php defined( 'ABSPATH' ) || exit; ?>

<div class="row">
    <div class="col-md-5">
        <h1 class="mb-3">Hey There!</h1>
        <p>Welcome to your CMS' personal dashboard</p>

        <div class="d-flex flex-wrap">
            <div class="col-md-4 text-center py-5">
                <a href="<?= ROOT ?>admin/pages">
                    <ion-icon name="document-outline" size="large" class="mb-2"></ion-icon>
                    <p>Pages</p>
                </a>
            </div>
            <div class="col-md-4 text-center py-5">
                <a href="<?= ROOT ?>admin/media">
                    <ion-icon name="image-outline" size="large" class="mb-2"></ion-icon>
                    <p>Media</p>
                </a>
            </div>
            <div class="col-md-4 text-center py-5">
                <a href="<?= ROOT ?>admin/users">
                    <ion-icon name="people-outline" size="large" class="mb-2"></ion-icon>
                    <p>Users</p>
                </a>
            </div>
            <div class="col-md-4 text-center py-5">
                <a href="<?= ROOT ?>admin/seo">
                    <ion-icon name="search-outline" size="large" class="mb-2"></ion-icon>
                    <p>SEO</p>
                </a>
            </div>
            <div class="col-md-4 text-center py-5">
                <a href="<?= ROOT ?>admin/settings">
                    <ion-icon name="cog-outline" size="large" class="mb-2"></ion-icon>
                    <p>Settings</p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-5">
        <div class="border rounded shadow p-4 m-3">
            <h2 class="h5">Need some help?</h2>
            <img src="<?= ROOT ?>src/images/collaboration.png" class="img-fluid d-block ms-auto me-auto my-4">
            <p class="text-center">From DIY to full-service help.</p>
            <p class="text-center">Call or chat 24/7 for support or let our experts build your site for you.</p>
            <center><a href="#" class="btn btn-outline-primary">Get Help</a></center>
        </div>
    </div>
</div>