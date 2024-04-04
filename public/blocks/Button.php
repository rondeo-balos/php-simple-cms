<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;
use simpl\includes\Db;

class Button extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Button',
            'icon' => 'link-outline',
            // These are the defaults
            'settings' => $this->saveSettings(),
            'props' => [
                'name' => 'Button',
                'link' => '',
                'label' => 'Let\'s go!'
            ]
        ];
        $blockManager->add( $this->definition );
    }

    public function settings() {
        ?>
            <label class="form-label">Link</label>
            <input type="text" class="form-control form-control-sm mb-2" list="pages" display="title" name="link">

            <label class="form-label">Label</label>
            <input type="text" class="form-control form-control-sm mb-2" name="label">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <a href="<?= Db::formatter($props['link'], 'path', __ROOT__ ) ?>" class="btn btn-primary mb-2">
                <?= $props['label'] ?>
            </a>
        <?php
    }

}