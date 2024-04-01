<?php

namespace simpl\blocks;

use simpl\blocks\BaseBlock;

class Heading implements BaseBlock{
    
    public $definition = [
        'name' => 'Heading',
        'icon' => 'text-outline',
        'fields' => [
            'type' => [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ],
            'content' => ''
        ],
        'props' => [
            'name' => 'Heading',
            'type' => 'h1',
            'content' => 'this is heading'
        ]
    ];

    public function __construct() {
        global $blockManager;
        $blockManager->add( $this->definition );
    }

    public static function render( string $props ) {
        $props = json_decode( $props );
        ?>
            <<?= $props['type'] ?>>
                <?= $props['content'] ?>
            </<?= $props['type'] ?>>
        <?php
    }

} new Heading;