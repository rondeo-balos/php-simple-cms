<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;
use simpl\includes\Db;

class Nav extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Nav',
            'icon' => 'list-outline',
            'type' => 'repeater',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'Nav',
                'content' => [[
                    'label' => 'Label',
                    'link' => ''
                ]],
                'direction' => 'flex-row',
                'align' => '',
                'width' => '100',
                'class' => ''
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

                    <label class="form-label">Label</label>
                    <input type="text" class="form-control form-control-sm mb-2" id="label">
                    
                    <label class="form-label">Link/Page</label>
                    <input type="text" class="form-control form-control-sm mb-2" list="pages" display="title" id="link">

                    <button class="btn btn-outline-danger btn-sm repeater-remove"><ion-icon name="trash-bin-outline"></ion-icon></button>
                </div>
                <button class="btn btn-outline-secondary btn-sm repeater-add w-100 rounded-0 rounded-bottom" style="margin-top: -1px;">Add Item</button>
            </div>

            <label class="form-label">Direction</label>
            <select class="form-select" name="direction">
                <option value="flex-row">Horizontal</option>
                <option value="flex-column">Vertical</option>
            </select>

            <label class="form-label">Align</label>
            <select class="form-select" name="align">
                <option value="justify-content-start">Start</option>
                <option value="justify-content-center">Center</option>
                <option value="justify-content-end">End</option>
            </select>

            <label class="form-label">Minimum Width (px)</label>
            <input type="number" class="form-control" min="0" max="1000" step="1" name="width">
            
            <label class="form-label">Additional Class</label>
            <input type="text" class="form-control" name="class">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <ul class="nav <?= $props['direction'] ?> <?= $props['align'] ?> <?= $props['class'] ?>" style="min-width: <?= $props['width'] ?>px">
                <?php foreach( $props['content'] as $key => $item ): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Db::formatter( $item->link, 'path', __ROOT__ ) ?>"><?= $item->label ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php
    }

}