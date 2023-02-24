<?php

namespace ModMyPages\Service\MenuService;

use Closure;

class MenuService implements IMenuService
{
    private Closure $getNavMenuLocations;
    private Closure $getNavMenuItems;

    function __construct(
        Closure $getNavMenuLocations,
        Closure $getNavMenuItems
    ) {
        $this->getNavMenuLocations = $getNavMenuLocations;
        $this->getNavMenuItems = $getNavMenuItems;
    }

    public function __invoke(string $menu): array
    {
        return $this->getMenuItems($menu);
    }

    public function getMenuItems(string $menu): array
    {
        $toArray = fn ($items) => array_map(fn ($obj) => (array) $obj, $items);
        $getMenuItemsByMenuName = fn ($name) => $toArray(
            ($this->getNavMenuItems)(
                ($this->getNavMenuLocations)()[$name] ?? 0
            ) ?: []
        );

        return $getMenuItemsByMenuName($menu);
    }
}
