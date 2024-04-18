<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;
use simpl\includes\Db;

class CardItems extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'CardItems',
            'icon' => 'list-outline',
            'type' => 'repeater',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'CardItems',
                'content' => [[
                    'icon' => 'checkmark-circle-outline',
                    'title' => 'Title',
                    'content' => 'Description',
                    'link' => ''
                ]],
                'columns' => '3'
            ]
        ];
        $blockManager->add( $this->definition );
    }

    /**
     * Generate field settings for the page builder
     */
    public function settings() {
        ?>
            <div class="rounded-start-end repeater" name="content">
                <div class="form-group p-3 repeater-container border">
                    <label class="form-label">Icon</label>
                    <input type="text" class="form-control form-control-sm mb-2" id="icon">

                    <label class="form-label">Title</label>
                    <input type="text" class="form-control form-control-sm mb-2" id="title">
                    
                    <label class="form-label">Description</label>
                    <textarea class="form-control form-control-sm mb-2" id="description"></textarea>
                    
                    <label class="form-label">Link/Page</label>
                    <input type="text" class="form-control form-control-sm mb-2" list="pages" display="title" id="link">

                    <button class="btn btn-outline-danger btn-sm repeater-remove"><ion-icon name="trash-bin-outline"></ion-icon></button>
                </div>
                <button class="btn btn-outline-secondary btn-sm repeater-add w-100 rounded-0 rounded-bottom" style="margin-top: -1px;">Add Item</button>
            </div>

            <label class="form-label">Columns per Row</label>
            <input type="number" class="form-control" min="0" max="12" name="columns">

        <?php
    }

    public static function render( array $props ) {
        $column_width = 12 / $props['columns'];
        ?>
            <div class="d-flex flex-wrap">
                <?php foreach( $props['content'] as $key => $item ): ?>
                    <div class="col-md-<?= $column_width ?> p-3">
                        <a class="text-decoration-none d-block h-100" href="<?= Db::formatter($item->link, 'path', __ROOT__ ) ?>">
                            <div class="card shadow-sm p-4 h-100">
                                <ion-icon size="large" name="<?= $item->icon ?>" class="mb-4"></ion-icon>
                                <h3 class="h5 mb-3"><?= $item->title ?></h5>
                                <p class="m-0"><small><?= $item->description ?></small></p>
                            </div>
                        </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php
    }

}