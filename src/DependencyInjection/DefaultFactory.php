<?php

namespace DependencyInjection;

class DefaultFactory
{
    private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function build()
    {
        return new $this->class;
    }
}
