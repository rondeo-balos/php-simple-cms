<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;
use simpl\includes\Db;

class CTA extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'CTA',
            'icon' => 'push-outline',
            'type' => 'normal',
            // These are the defaults
            'settings' => $this->saveSettings(),
            'props' => [
                'name' => 'CTA',
                'type' => 'h1',
                'width' => '100',
                'align' => 'text-center',
                'heading' => 'Lorem ipsum',
                'content' => 'Lorem ipsum dolor sit amet.',
                'link' => '',
                'label' => 'Let\'s Go',
                'background' => '#fff',
                'color' => '#000',
                'class' => ''
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

            <label class="form-label">Width (px)</label>
            <input type="range" class="form-range" min="0" max="100" name="width">

            <label class="form-label">Text align</label>
            <select class="form-select" name="align">
                <option value="text-start">Left</option>
                <option value="text-center">Center</option>
                <option value="text-end">Right</option>
            </select>

            <label class="form-label">Heading</label>
            <input type="text" class="form-control form-control-sm mb-2" name="heading">

            <hr>

            <label class="form-label">Content</label>
            <textarea class="form-control form-control mb-2" name="content"></textarea>

            <hr>

            
            <label class="form-label">Button Link</label>
            <input type="text" class="form-control form-control-sm mb-2" list="pages" display="title" name="link">

            <label class="form-label">Button Label</label>
            <input type="text" class="form-control form-control-sm mb-2" name="label">

            <label class="form-label">Button Background</label>
            <input type="color" class="form-control form-control-color form-control-sm mb-2" name="background">

            <label class="form-label">Button Text Color</label>
            <input type="color" class="form-control form-control-color form-control-sm mb-2" name="color">
            
            <label class="form-label">Additional Class</label>
            <input type="text" class="form-control" name="class">
        <?php
    }

    public static function render( array $props ) {
        $rand = rand( 1111, 99999 );
        ?>
            <div style="max-width: <?= $props['width'] ?>%;" class="<?= $props['class'] ?>">
                <<?= $props['type'] ?>  class="<?= $props['align'] ?? '' ?>">
                    <?= $props['heading'] ?? '' ?>
                </<?= $props['type'] ?>>

                <p><?= $props['content']; ?></p>
                
                <a href="<?= Db::formatter($props['link'], 'path', __ROOT__ ) ?>" class="btn btn-primary mb-2 btn-<?= $rand ?>">
                    <?= $props['label'] ?>
                </a>
                <style>
                    .btn-<?= $rand ?> {
                        --bs-btn-color: <?= $props['color'] ?>;
                        --bs-btn-bg: <?= $props['background'] ?>;
                        --bs-btn-border-color: <?= $props['background'] ?>;
                        --bs-btn-hover-color: <?= $props['color'] ?>;
                        --bs-btn-hover-bg: #{shade-color(<?= $props['background'] ?>, 10%)};
                        --bs-btn-hover-border-color: #{shade-color(<?= $props['background'] ?>, 10%)};
                        --bs-btn-focus-shadow-rgb: <?= $props['background'] ?>;
                        --bs-btn-active-color: <?= $props['background'] ?>;
                        --bs-btn-active-bg: #{shade-color(<?= $props['background'] ?>, 20%)};
                        --bs-btn-active-border-color: #{shade-color(<?= $props['background'] ?>, 20%)};
                    }
                </style>
            </div>
        <?php
    }

}