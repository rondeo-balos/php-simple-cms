<?php

namespace simpl\blocks;

use simpl\blocks\BaseBlock;
use simpl\includes\Db;

class Button implements BaseBlock{
    
    public $definition = [
        'name' => 'Button',
        'icon' => 'link-outline',
        'fields' => [
            'link' => 'datalist:pages',
            'label' => 'text'
        ],
        // These are the defaults
        'props' => [
            'name' => 'Button',
            'link' => '',
            'label' => 'Let\'s go!'
        ]
    ];

    public function __construct( BlockManager $blockManager ) {
        $blockManager->add( $this->definition );
    }

    public static function render( array $props ) {
        ?>
            <a href="<?= Db::formatter($props['link'], 'path', __ROOT__ ) ?>">
                <?= $props['label'] ?>
            </a>
        <?php
    }

}