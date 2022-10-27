<?php

namespace ModMyPages\Types;

interface IApplicationRecipe
{
    public function run(): Application;

    public function redirect();

    public function bodyClassNames(array $classNames): array;

    public function setBladeTemplatePaths(array $paths): array;

    public function optionsPage();

    public function registerMenus();

    public function dropDownMenuController(array $data): array;
}
