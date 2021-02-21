<?php

namespace DependencyInjection;

class DiContainer
{
    private string $baseDir;
    private array $config;

    public function __construct() {
        $this->baseDir = realpath(dirname($_SERVER['DOCUMENT_ROOT']));
        $this->config = require $this->baseDir . '/config/factories.php';

        spl_autoload_register(__NAMESPACE__ .'\DiContainer::autoload');
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @return T
     */
    public function get(string $className)
    {
        if (isset($this->config[$className])) {
            $factory = new $this->config[$className]($this);
        } else {
            $factory = new DefaultFactory($className, $this);
        }

        return $factory->build();
    }

    private function autoload(string $classname): void
    {
        $filepath = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
        require_once $this->baseDir . '/src/' . $filepath . '.php';
    }
}
