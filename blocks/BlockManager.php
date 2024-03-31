<?php

namespace simpl\blocks;

class BlockManager {

    public array $blocks = [];

    public function add( $definition ) {
        $this->blocks[ $definition['name'] ] = $definition;
    }

}