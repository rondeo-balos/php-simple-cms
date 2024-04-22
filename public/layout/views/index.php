<?php defined( 'ABSPATH' ) || exit;

use simpl\public\blocks\BlockManager;

if( $data ) {

    $blocks = json_decode( $data->blocks ) ?? json_decode( stripcslashes( $data->blocks ) );

    BlockManager::renderBlocks( $blocks );
    
}