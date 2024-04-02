<?php
namespace simpl\controller;

use Psr\Container\ContainerInterface;

class BaseController {

    protected $container;

    // constructor receives container instance
    public function __construct( ContainerInterface $container ) {
        $this->container = $container;
    }

}