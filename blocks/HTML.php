<?php

namespace simpl\blocks;

use simpl\blocks\BaseBlock;
use simpl\includes\Db;

class HTML implements BaseBlock{
    
    public $definition = [];

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'HTML',
            'icon' => 'code-slash-outline',
            /**
             * This will generate field settings
             * downside is it's tedious and prone to breaking
             */
            'fields' => [
                'content' => 'textarea'
            ],
            // These are the defaults
            'props' => [
                'name' => 'HTML',
                'content' => ''
            ]
        ];
        $blockManager->add( $this->definition );
    }

    /**
     * Generate field settings for the page builder
     */
    public function settings() {
        ?>
            <textarea class="form-control" name="content"></textarea>
        <?php
    }

    public static function render( array $props ) {
        echo $props['content'];
    }

}