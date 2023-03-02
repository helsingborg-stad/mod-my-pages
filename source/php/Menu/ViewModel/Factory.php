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
        $dropdownMenu->items = array_map([self::class, '_toArray'], [...$items]);
        return $dropdownMenu;
    }

    private static function _toArray($obj)
    {
        return (array) $obj;
    }
}

trait DropdownMenuItemFactoryMethod
{
    public static function create(
        string $text,
        string $link,
        ?array $classList = [],
        ?array $attributeList = [],
        ?array $linkAttributeList = []
    ): DropdownMenuItem {
        $item = new DropdownMenuItem();
        $item->text = $text;
        $item->link = $link;
        $item->attributeList = $attributeList ?? [];
        $item->classList = $classList ?? [];
        $item->linkAttributeList = $linkAttributeList ?? [];
        return $item;
    }
}
