<?php

namespace ModMyPages\Types;

interface IApplicationRecipe
{
    public function run(): Application;

    public function redirect();

    public function setBladeTemplatePaths(array $paths): array;

    public function registerOptionsPage();

    public function registerMenus();

    public function dropdownMenuController(array $data): array;
}
