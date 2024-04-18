<?php defined( 'ABSPATH' ) || exit;

if( $data ) {

    $blocks = json_decode( $data->blocks ) ?? json_decode( stripcslashes( $data->blocks ) );

    foreach( $blocks as $block ) {
        $blockClass = "simpl\\public\\blocks\\" . $block->name;
        
        if (class_exists($blockClass)) {
            $blockClass::render( get_object_vars($block) );
        } else {
            echo "Block class $block->name not found.";
        }
    }
    
}