<?php

namespace ModMyPages\Menu;

use ModMyPages\PostType\MyPages;

class SecondaryMenu extends DropdownMenu
{
    const MENU_SLUG = 'my-pages-menu-secondary';
    const MENU_SLUG_CAMEL_CASE = 'myPagesSecondaryMenu';

    protected static function description(): string
    {
        return __('My Pages Secondary Menu (for logged in users)', MOD_MY_PAGES_TEXT_DOMAIN);
    }

    protected function label(): string
    {
        return  $this->acf->getOption('my_pages_secondary_menu')['menu_label'] ?: '{user.name}';
    }

    protected function active(): bool
    {
        return $this->query->getPostType() == MyPages::$postType
            && ($this->acf->getOption('my_pages_secondary_menu')['show_in_help_menu'] ?? false);
    }

    protected function hideIcon(): bool
    {
        return true;
    }

    protected function hideLabel(): bool
    {
        return $this->acf->getOption('my_pages_secondary_menu')['hide_label'] ?? false;
    }

    protected function loginButton(): array
    {
        return [];
    }

    protected function onlyShowForAuthenciated(): bool
    {
        return true;
    }
}