<?php

namespace simpl\blocks;

use simpl\blocks\BaseBlock;

class Heading implements BaseBlock{
    
    public $definition = [];

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Heading',
            'icon' => 'text-outline',
            'fields' => [
                'type' => [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ],
                'content' => 'text'
            ],
            // These are the defaults
            'props' => [
                'name' => 'Heading',
                'type' => 'h1',
                'content' => 'Lorem ipsum'
            ]
        ];

        $blockManager->add( $this->definition );
    }

    public static function render( array $props ) {
        ?>
            <<?= $props['type'] ?>>
                <?= $props['content'] ?>
            </<?= $props['type'] ?>>
        <?php
    }

}