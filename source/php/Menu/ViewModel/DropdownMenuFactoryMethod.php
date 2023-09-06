<?php

namespace ModMyPages\Menu\ViewModel;

trait DropdownMenuFactoryMethod
{
    public static function create(
        string $id,
        string $label,
        bool $active,
        ?array $args = [],
        DropdownMenuItem ...$items
    ): DropdownMenu {
        $dropdownMenu = new DropdownMenu();
        $dropdownMenu->id = $id;
        $dropdownMenu->active = $active;
        $dropdownMenu->label = $label;
        $dropdownMenu->hideLabel = $args['hideLabel'] ?? false;
        $dropdownMenu->hideIcon = $args['hideIcon'] ?? false;
        $dropdownMenu->onlyShowForAuthenciated = $args['onlyShowForAuthenciated'] ?? false;
        $dropdownMenu->items = array_map(fn(DropdownMenuItem $i) => (array) $i, $items ?: []);
        return $dropdownMenu;
    }
}
