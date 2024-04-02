<?php
namespace simpl\actions;

use Psr\Container\ContainerInterface;

class BaseAction {

    protected $container;

    // constructor receives container instance
    public function __construct( ContainerInterface $container ) {
        $this->container = $container;
    }

}