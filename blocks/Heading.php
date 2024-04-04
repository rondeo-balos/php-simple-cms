<?php

namespace simpl\blocks;

use simpl\blocks\BaseBlock;

class Heading extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Heading',
            'icon' => 'text-outline',
            // These are the defaults
            'settings' => $this->saveSettings(),
            'props' => [
                'name' => 'Heading',
                'type' => 'h1',
                'content' => 'Lorem ipsum'
            ]
        ];

        $blockManager->add( $this->definition );
    }

    public function settings() {
        ?>
            <label class="form-label">Type</label>
            <select class="form-select form-select-sm mb-2" name="type">
                <option>h1</option>
                <option>h2</option>
                <option>h3</option>
                <option>h4</option>
                <option>h5</option>
                <option>h6</option>
            </select>

            <label class="form-label">Content</label>
            <input type="text" class="form-control form-control-sm mb-2" name="content">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <<?= $props['type'] ?>>
                <?= $props['content'] ?>
            </<?= $props['type'] ?>>
        <?php
    }

}