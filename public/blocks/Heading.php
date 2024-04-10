<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;

class Heading extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Heading',
            'icon' => 'text-outline',
            'type' => 'normal',
            // These are the defaults
            'settings' => $this->saveSettings(),
            'props' => [
                'name' => 'Heading',
                'type' => 'h1',
                'content' => 'Lorem ipsum',
                'width' => '100',
                'align' => 'text-center'
            ]
        ];

        $blockManager->add( $this->definition );
    }

    public function settings() {
        ?>
            <label class="form-label">Type</label>
            <select class="form-select form-select-sm mb-2" name="type">
                <option value="h1">H1</option>
                <option value="h2">H2</option>
                <option value="h3">H3</option>
                <option value="h4">H4</option>
                <option value="h5">H5</option>
                <option value="h6">H6</option>
            </select>

            <label class="form-label">Content</label>
            <input type="text" class="form-control form-control-sm mb-2" name="content">

            <label class="form-label">Width (px)</label>
            <input type="range" class="form-range" min="0" max="100" name="width">

            <label class="form-label">Text align</label>
            <select class="form-select" name="align">
                <option value="text-start">Left</option>
                <option value="text-center">Center</option>
                <option value="text-end">Right</option>
            </select>
        <?php
    }

    public static function render( array $props ) {
        ?>
            <<?= $props['type'] ?> style="max-width: <?= $props['width'] ?>%;" class="<?= $props['align'] ?? '' ?>">
                <?= $props['content'] ?? '' ?>
            </<?= $props['type'] ?>>
        <?php
    }

}