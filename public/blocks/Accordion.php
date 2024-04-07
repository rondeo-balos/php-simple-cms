<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;

class Accordion extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'Accordion',
            'icon' => 'list-outline',
            'type' => 'repeater',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'Accordion',
                'accordion_title' => [''],
                'accordion_description' => ['']
            ]
        ];
        $blockManager->add( $this->definition );
    }

    /**
     * Generate field settings for the page builder
     */
    public function settings() {
        ?>
            <div class="rounded-start-end repeater">
                <div class="form-group p-3 repeater-base border">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control form-control-sm mb-2" name="accordion_title[]">
                    
                    <label class="form-label">Description</label>
                    <textarea class="form-control form-control-sm mb-2" name="accordion_description[]"></textarea>

                    <button class="btn btn-outline-danger btn-sm repeater-remove"><ion-icon name="trash-bin-outline"></ion-icon></button>
                </div>
                <button class="btn btn-outline-secondary btn-sm repeater-add w-100 rounded-0 rounded-bottom" style="margin-top: -1px;">Add Item</button>
            </div>

        <?php
    }

    public static function render( array $props ) {
        
    }

}