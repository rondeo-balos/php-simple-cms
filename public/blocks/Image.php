<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;
use simpl\includes\Db;

class Image extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Image',
            'icon' => 'image-outline',
            'type' => 'normal',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'Image',
                'image' => 'https://placehold.co/600x400',
                'alt' => 'Lorem ipsum',
                'class' => ''
            ]
        ];
        $blockManager->add( $this->definition );
    }

    public function settings() {
        ?>
            <label class="form-label">Image</label>
            <input type="text" class="form-control form-control-sm mb-2" name="image" show="media">

            <label class="form-label">Alt</label>
            <input type="text" class="form-control form-control-sm mb-2" name="alt">
            
            <label class="form-label">Additional Class</label>
            <input type="text" class="form-control" name="class">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <img src="<?= Db::formatter($props['image'] ?? '', 'filepath', ROOT ) ?>" alt="<?= $props['alt'] ?? '' ?>" class="img-fluid <?= $props['class'] ?? '' ?>">
        <?php
    }

}