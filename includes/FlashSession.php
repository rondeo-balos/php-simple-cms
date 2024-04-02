<?php
namespace simpl\includes;

class FlashSession {

    public static function set( $key, $value ) {
        $_SESSION[ $key ] = $value;
    }

    public static function hasKey( $key ): bool {
        return isset( $_SESSION[ $key ] );
    }

    public static function get( $key ): mixed {
        $value = $_SESSION[ $key ];
        unset( $_SESSION[ $key ] );
        
        return $value;
    }

}