<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;
use simpl\includes\Db;

class Flexbox extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Flexbox',
            'icon' => 'grid-outline',
            'type' => 'normal',
            // These are the defaults
            'settings' => $this->saveSettings(),
            'props' => [
                'name' => 'Flexbox',
                'direction' => 'flex-row',
                'blocks' => [
                    [
                        
                        'name' => 'Heading',
                        'type' => 'h1',
                        'content' => 'Lorem ipsum',
                        'width' => '100',
                        'align' => 'text-center'
                    ],
                    [
                        'name' => 'Button',
                        'link' => '',
                        'label' => 'Let\'s go!',
                        'background' => '#fff',
                        'color' => '#000'
                    ]
                ]
            ]
        ];
        $blockManager->add( $this->definition );
    }

    public function settings() {
        ?>
            <label class="form-label">Direction</label>
            <select class="form-select" name="direction">
                <option value="flex-row">Row</option>
                <option value="flex-row-reverse">Row Reverse</option>
                <option value="flex-column">Column</option>
                <option value="flex-column-reverse">Column Reverse</option>
            </select>
        <?php
    }

    public static function render( array $props ) {
        ?>
            <div class="d-flex <?= $props['direction'] ?>">
                <?php
                    if( !empty( $props['blocks'] ) ) {
                        BlockManager::renderBlocks( $props['blocks'], '<div class="flex-fill">', '</div>' );
                    }
                ?>
            </div>
        <?php
    }

}