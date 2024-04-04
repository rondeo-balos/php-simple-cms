<?php

namespace simpl\blocks;

use simpl\blocks\BaseBlock;
use simpl\includes\Db;

class HTML extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'HTML',
            'icon' => 'code-slash-outline',
            'settings' => $this->saveSettings(),
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
            <label class="form-label">Content</label>
            <textarea class="form-control form-control-sm mb-2" name="content"></textarea>
        <?php
    }

    public static function render( array $props ) {
        echo $props['content'];
    }

}