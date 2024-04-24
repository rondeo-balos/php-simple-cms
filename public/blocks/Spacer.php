<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;

class Spacer extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Spacer',
            'icon' => 'chevron-expand-outline',
            'type' => 'normal',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'Spacer',
                'space' => '50',
                'class' => ''
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
            
            <label class="form-label">Additional Class</label>
            <input type="text" class="form-control" name="class">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <div class="w-100 <?= $props['class'] ?>" style="height: <?= $props['space'] ?>px;"></div>
        <?php
    }

}