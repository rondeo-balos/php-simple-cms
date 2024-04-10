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
                ]]
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
                    <input type="text" class="form-control form-control-sm mb-2">
                    
                    <label class="form-label">Description</label>
                    <textarea class="form-control form-control-sm mb-2"></textarea>

                    <button class="btn btn-outline-danger btn-sm repeater-remove"><ion-icon name="trash-bin-outline"></ion-icon></button>
                </div>
                <button class="btn btn-outline-secondary btn-sm repeater-add w-100 rounded-0 rounded-bottom" style="margin-top: -1px;">Add Item</button>
            </div>

        <?php
    }

    public static function render( array $props ) {
        ?>
            <div class="accordion" id="<?= $props['name'] ?>">
                <?php foreach( $props['content'] as $key => $item ): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button <?= $key === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key ?>" aria-expanded="<?= $key === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $key ?>">
                            <strong><?= $item->INPUT ?></strong>
                        </button>
                        </h2>
                        <div id="collapse<?= $key ?>" class="accordion-collapse collapse <?= $key === 0 ? 'show' : '' ?>" data-bs-parent="#<?= $props['name'] ?>">
                            <div class="accordion-body">
                                <?= $item->TEXTAREA ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
    }

}