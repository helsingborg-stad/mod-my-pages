<?php

namespace ModMyPages\Types;

interface IApplicationRecipe
{
    public function run(): Application;

    public function redirect();

    public function setBladeTemplatePaths(array $paths): array;
}
