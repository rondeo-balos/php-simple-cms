<?php

namespace simpl\blocks;

use simpl\blocks\BaseBlock;
use simpl\includes\Db;

class Image implements BaseBlock{
    
    public $definition = [];

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Image',
            'icon' => 'image-outline',
            'fields' => [
                'image' => 'datalist:media',
                'alt' => 'text'
            ],
            // These are the defaults
            'props' => [
                'name' => 'Image',
                'image' => 'media|1',
                'alt' => 'Lorem ipsum'
            ]
        ];
        $blockManager->add( $this->definition );
    }

    public static function render( array $props ) {
        ?>
            <img src="<?= Db::formatter($props['image'], 'filepath', ROOT ) ?>" alt="<?= $props['alt'] ?>">
        <?php
    }

}