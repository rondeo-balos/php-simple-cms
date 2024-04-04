<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;
use simpl\includes\Db;

class Button extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Button',
            'icon' => 'link-outline',
            // These are the defaults
            'settings' => $this->saveSettings(),
            'props' => [
                'name' => 'Button',
                'link' => '',
                'label' => 'Let\'s go!',
                'background' => '#fff',
                'color' => '#000'
            ]
        ];
        $blockManager->add( $this->definition );
    }

    public function settings() {
        ?>
            <label class="form-label">Link</label>
            <input type="text" class="form-control form-control-sm mb-2" list="pages" display="title" name="link">

            <label class="form-label">Label</label>
            <input type="text" class="form-control form-control-sm mb-2" name="label">

            <label class="form-label">Background Color</label>
            <input type="color" class="form-control form-control-color form-control-sm mb-2" name="background">

            <label class="form-label">Text Color</label>
            <input type="color" class="form-control form-control-color form-control-sm mb-2" name="color">
        <?php
    }

    public static function render( array $props ) {
        $rand = rand( 1111, 99999 );
        ?>
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
        <?php
    }

}