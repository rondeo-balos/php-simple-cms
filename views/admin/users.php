<?php

use simpl\Db;
use simpl\model\User;
use simpl\Pagination;

defined( 'ABSPATH' ) || exit;

?>

<h1 class="h5"><?= $title ?></h1>

<div class="d-flex flex-row justify-content-between align-items-center mb-4">

    <div style="width: 400px;">
        <div class="input-group">
            <input type="text" class="form-control form-control-sm" placeholder="Search users" aria-label="Search users" aria-describedby="search-button">
            <button class="btn btn-outline-primary btn-sm" aria-labelledby="Search button"><ion-icon name="search"></ion-icon></button>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center">
        <a href="#" class="me-3"><ion-icon name="funnel"></ion-icon></a>
        <a href="#" class="me-3"><ion-icon name="list"></ion-icon></a>
        <a href="<?= ROOT ?>admin/users/create" class="btn btn-primary btn-sm">Add User</a>
    </div>
</div>

<div class="rounded border overflow-hidden bg-white mb-3">
    <table class="table table-hover" style="margin-bottom: -1px;">
        <tr>
            <th class="p-3">Email Address</th>
            <th class="p-3">First Name</th>
            <th class="p-3">Last Name</th>
            <th class="p-3">Administrator</th>
            <th class="p-3">Created at</th>
        </tr>
        <?php
            Db::createInstance();
            $users = User::paginate(
                $perPage = 8,
                $columns = ['*'],
                $pageName = 'page',
                $page = $get['page'] ?? 1
            );
            $users->withPath( ROOT . 'admin/users' );
            
            foreach( $users as $user ):
            ?>
                <tr>
                    <td class="p-3 align-middle">
                        <b><?= $user->email ?></b>
                        <div class="d-block text-sm">
                            <a href="" class="pe-2 hover-blue"><small>Edit</small></a>
                            <a href="" class="hover-red"><small>Delete</small></a>
                        </div>
                    </td>
                    <td class="p-3 align-middle"><?= $user->firstname ?></td>
                    <td class="p-3 align-middle"><?= $user->lastname ?></td>
                    <td class="p-3 align-middle"></td>
                    <td class="p-3 align-middle"><?= $user->created_at ?></td>
                </tr>
            <?php
            endforeach;
        ?>
    </table>
</div>

<?php Pagination::render( $users );