<?php

namespace simpl\blocks;

class BlockManager {

    public array $definitions = [];

    public function add( $definition ) {
        $this->definitions[ $definition['name'] ] = $definition;
    }

}