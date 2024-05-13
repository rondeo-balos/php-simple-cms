<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;

class HTML extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'HTML',
            'icon' => 'code-slash-outline',
            'type' => 'normal',
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
            <label class="form-label">HTML</label>
            <textarea class="form-control form-control mb-2" name="content"></textarea>
        <?php
    }

    public static function render( array $props ) {
        echo $props['content'] ?? '';
    }

}