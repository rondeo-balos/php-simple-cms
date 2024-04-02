<?php

namespace simpl\blocks;

use simpl\blocks\BaseBlock;

class Button implements BaseBlock{
    
    public $definition = [
        'name' => 'Button',
        'icon' => 'link-outline',
        'fields' => [
            'link' => 'link',
            'label' => 'text'
        ],
        'props' => [
            'name' => 'Button',
            'link' => '',
            'label' => 'This is a button'
        ]
    ];

    public function __construct() {
        global $blockManager;
        $blockManager->add( $this->definition );
    }

    public static function render( array $props ) {
        ?>
            <a href="<?= $props['link'] ?>">
                <?= $props['label'] ?>
            </a>
        <?php
    }

} new Button;