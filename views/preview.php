<?php

use simpl\Db;
use simpl\model\Preview;
defined( 'ABSPATH' ) || exit;

$token = $get['__p'];
Db::createInstance();

$preview = Preview::where( 'token', '=', $token )->first();
$data = json_decode( $preview->data );
$blocks = json_decode( $data->blocks );

foreach( $blocks as $block ) {
    $blockClass = "simpl\\blocks\\" . $block->name;
    
    if (class_exists($blockClass)) {
        $blockClass::render( get_object_vars($block) );
    } else {
        echo "Block class $block->name not found.";
    }
}