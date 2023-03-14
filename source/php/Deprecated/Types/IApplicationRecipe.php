<?php

namespace ModMyPages\Deprecated\Types;

/**
 * @deprecated
 */
interface IApplicationRecipe
{
    public function run(): Application;

    public function redirect();

    public function setBladeTemplatePaths(array $paths): array;
}
