<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;
use simpl\includes\Db;

class Video extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Video',
            'icon' => 'videocam-outline',
            'type' => 'normal',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'Video',
                'source' => ''
            ]
        ];
        $blockManager->add( $this->definition );
    }

    public function settings() {
        ?>
            <label class="form-label">Source</label>
            <input type="text" class="form-control form-control-sm mb-2" name="source" show="media">
        <?php
    }

    public static function render( array $props ) {
        ?>
        <video width="100%" height="auto" controls class="object-fit-contain rounded">
            <source src="<?= Db::formatter($props['source'], 'filepath', ROOT ) ?>">
        </video>
        <?php
    }

}