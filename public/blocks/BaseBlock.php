<?php

namespace simpl\public\blocks;

class BaseBlock {

    
    public $definition = [];

    /**
     * Generate field settings for the page builder
     */
    public function settings(){}
    
    public function saveSettings(): string {
        ob_start();
        $this->settings();
        return htmlentities( ob_get_clean() );
    }

    /**
     * Render output
     */
    public static function render( array $props ){}

}