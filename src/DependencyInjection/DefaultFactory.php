<?php

namespace DependencyInjection;

use ReflectionClass;

class DefaultFactory
{
    private $class;
    private DiContainer $container;

    public function __construct($class, DiContainer $container)
    {
        $this->class = $class;
        $this->container = $container;
    }

    public function build()
    {
        $params = [];

        $reflection = new ReflectionClass($this->class);
        $constructor = $reflection->getConstructor();

        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $reflectionParameter) {
                $params[] = $this->container->get($reflectionParameter->getType());
            }
        }

        return new $this->class(...$params);
    }
}
