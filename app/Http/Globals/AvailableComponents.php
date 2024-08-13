<?php

namespace App\Http\Globals;

class AvailableComponents {

    public static function get() : array {
        return [
            'Container',
            'Heading',
            'Image',
            'Text'
        ];
    }

}