<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;

class Spacer extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Spacer',
            'icon' => 'chevron-expand-outline',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'Spacer',
                'space' => '50'
            ]
        ];
        $blockManager->add( $this->definition );
    }

    /**
     * Generate field settings for the page builder
     */
    public function settings() {
        ?>
            <label class="form-label">Space</label>
            <input type="number" class="form-control form-control-sm mb-2" name="space">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <div style="height: <?= $props['space'] ?>px;"></div>
        <?php
    }

}