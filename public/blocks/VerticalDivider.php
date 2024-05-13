<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;

class VerticalDivider extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'VerticalDivider',
            'icon' => 'remove-outline',
            'type' => 'normal',
            // These are the defaults
            'settings' => $this->saveSettings(),
            'props' => [
                'name' => 'VerticalDivider',
                'height' => '20',
                'class' => ''
            ]
        ];

        $blockManager->add( $this->definition );
    }

    public function settings() {
        ?>
            <label class="form-label">Height (px)</label>
            <input type="range" class="form-range" min="0" max="500" name="height">
            
            <label class="form-label">Additional Class</label>
            <input type="text" class="form-control" name="class">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <span class="d-block <?= $props['class'] ?? '' ?>" style="width: 1px; height: <?= $props['height'] ?? '' ?>px; background: linear-gradient(transparent, white); margin-left: auto; margin-right: auto;"></span>
        <?php
    }

}