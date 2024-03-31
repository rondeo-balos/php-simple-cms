<?php

namespace simpl\blocks;

use simpl\blocks\BaseBlock;

class HTML implements BaseBlock{
    
    public $definition = [
        'name' => 'HTML',
        'icon' => 'logo-html5',
        'fields' => [
            'content' => 'code'
        ]
    ];

    public $props = [
        'name' => 'HTML',
        'content' => '<!-- Start here -->'
    ];

    public function __construct() {
        global $blockManager;
        $blockManager->add( $this->definition );
    }

    public function render( string $props ) {
        $props = json_decode( $props );
        ?>
            <?= $props['content'] ?>
        <?php
    }

} new HTML;