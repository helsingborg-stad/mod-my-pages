<?php

namespace ModMyPages\Menu\ViewModel;

trait DropdownItemFactoryMethod
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
