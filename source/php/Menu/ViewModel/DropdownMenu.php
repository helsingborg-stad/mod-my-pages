<?php

namespace ModMyPages\Menu\ViewModel;

class DropdownMenu
{
    use DropdownMenuFactoryMethod;

    public string $id;

    public bool $active;

    public string $label;

    public bool $hideLabel;

    public bool $hideIcon;

    public array $items;

    public bool $onlyShowForAuthenciated;
}

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
        $dropdownMenu->items = array_map([self::class, '_toArray'], [...$items]);
        return $dropdownMenu;
    }

    private static function _toArray($obj)
    {
        return (array) $obj;
    }
}
