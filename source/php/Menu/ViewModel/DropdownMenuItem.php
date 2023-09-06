<?php

namespace ModMyPages\Menu\ViewModel;

class DropdownMenuItem
{
    use DropdownItemFactoryMethod;

    public string $text;

    public string $link;

    public array $attributeList;

    public array $classList;

    public array $linkAttributeList;
}
