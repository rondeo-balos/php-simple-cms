<?php

namespace simpl\public\blocks;

use simpl\public\blocks\BaseBlock;

class RichText extends BaseBlock{

    public function __construct( BlockManager $blockManager ) {
        $this->definition = [
            'name' => 'RichText',
            'icon' => 'document-text-outline',
            'settings' => $this->saveSettings(),
            // These are the defaults
            'props' => [
                'name' => 'RichText',
                'content' => 'Lorem ipsum',
                'width' => '1000'
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
            <input type="range" class="form-range" min="0" max="1000" name="width">
        <?php
    }

    public static function render( array $props ) {
        ?>
            <div style="max-width: <?= $props['width'] ?>px;">
                <?= $props['content'] ?>
            </div>
        <?php
    }

}