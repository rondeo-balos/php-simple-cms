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
                'content' => [[
                    'INPUT' => 'Heading',
                    'TEXTAREA' => 'Description'
                ]],
                'width' => '100',
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
            <div class="rounded-start-end repeater" name="content">
                <div class="form-group p-3 repeater-container border">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control form-control-sm mb-2" id="INPUT">
                    
                    <label class="form-label">Description</label>
                    <textarea class="form-control form-control-sm mb-2" id="TEXTAREA"></textarea>

                    <button class="btn btn-outline-danger btn-sm repeater-remove"><ion-icon name="trash-bin-outline"></ion-icon></button>
                </div>
                <button class="btn btn-outline-secondary btn-sm repeater-add w-100 rounded-0 rounded-bottom" style="margin-top: -1px;">Add Item</button>
            </div>

            <label class="form-label">Width (px)</label>
            <input type="range" class="form-range" min="0" max="100" name="width">
            
            <label class="form-label">Additional Class</label>
            <input type="text" class="form-control" name="class">

        <?php
    }

    public static function render( array $props ) {
        ?>
            <div class="accordion <?= $props['class'] ?>" id="<?= $props['name'] ?? '' ?>" style="max-width: <?= $props['width'] ?? '' ?>%; margin-left: auto; margin-right: auto;">
                <?php foreach( $props['content'] as $key => $item ): ?>
                    <div class="accordion-item p-2 mb-2 rounded border-1 bg-body" style="box-shadow: none;">
                        <h3 class="accordion-header">
                        <button class="accordion-button <?= $key === 0 ? '' : 'collapsed' ?> rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key ?>" aria-expanded="<?= $key === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $key ?>" style="box-shadow: none; background: transparent !important;">
                            <strong><?= $item->INPUT ?? '' ?></strong>
                        </button>
                        </h3>
                        <div id="collapse<?= $key ?>" class="accordion-collapse collapse <?= $key === 0 ? 'show' : '' ?>" data-bs-parent="#<?= $props['name'] ?? '' ?>">
                            <div class="accordion-body">
                                <small><?= $item->TEXTAREA ?? '' ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
    }

}