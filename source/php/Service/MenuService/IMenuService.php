<?php

namespace ModMyPages\Service\MenuService;

interface IMenuService
{
    public function __invoke(string $menu): array;

    public function getMenuItems(string $menu): array;
}
