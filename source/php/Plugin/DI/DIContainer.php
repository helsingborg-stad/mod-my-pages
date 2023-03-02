<?php

namespace ModMyPages\Plugin\DI;

interface DIContainer
{
    public function bind($name, $dependency);
    public function resolve($name);
    /**
     *
     * @param string $class
     * @return object
     */
    public function make($class);
}
