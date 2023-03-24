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

    /**
     * @var list<array>
     */
    public array $items;

    public bool $onlyShowForAuthenciated;
}
