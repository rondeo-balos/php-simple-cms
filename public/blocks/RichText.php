<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;

class RichText extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'RichText',
            'icon' => 'document-text-outline',
            'type' => 'normal',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'RichText',
                'content' => 'Lorem ipsum',
                'width' => '100',
                'align' => 'text-center',
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
            <label class="form-label">Content</label>
            <div id="editor" name="content" class="mb-2"></div>
            <script>
                const quill = new Quill( '#editor', {
                    modules: {
                        toolbar: [
                            ['bold', 'italic'],
                            ['link', 'blockquote'],
                            [{list: 'ordered'}, {list: 'bullet'}]
                        ]
                    },
                    theme: 'snow'
                } );
                var content = $( '#editor .ql-editor' );
                Object.defineProperty( document.querySelector( '#editor' ), 'value', {
                    get: function() {
                        return content.html();
                    },
                    set: function( value ) {
                        content.html( value );
                    }
                });
            </script>

            <label class="form-label">Width (px)</label>
            <input type="range" class="form-range" min="0" max="100" name="width">

            <label class="form-label">Text align</label>
            <select class="form-select" name="align">
                <option value="text-start">Left</option>
                <option value="text-center">Center</option>
                <option value="text-end">Right</option>
            </select>
            
            <label class="form-label">Additional Class</label>
            <input type="text" class="form-control" name="class">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <div style="max-width: <?= $props['width'] ?>%;" class="<?= $props['align'] ?? '' ?> <?= $props['class'] ?>">
                <?= $props['content'] ?>
            </div>
        <?php
    }

}