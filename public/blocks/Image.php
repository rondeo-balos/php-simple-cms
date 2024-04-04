<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;
use simpl\includes\Db;

class Image extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Image',
            'icon' => 'image-outline',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'Image',
                'image' => 'media|1',
                'alt' => 'Lorem ipsum'
            ]
        ];
        $blockManager->add( $this->definition );
    }

    public function settings() {
        ?>
            <label class="form-label">Image</label>
            <input type="text" class="form-control form-control-sm mb-2" name="image">

            <label class="form-label">Alt</label>
            <input type="text" class="form-control form-control-sm mb-2" name="alt">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <img src="<?= Db::formatter($props['image'], 'filepath', ROOT ) ?>" alt="<?= $props['alt'] ?>" class="img-fluid">
        <?php
    }

}