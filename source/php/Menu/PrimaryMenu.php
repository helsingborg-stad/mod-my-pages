<?php

namespace ModMyPages\Menu;

use ModMyPages\PostType\MyPages;

class PrimaryMenu extends DropdownMenu
{
    const MENU_SLUG = 'my-pages-menu-primary';
    const MENU_SLUG_CAMEL_CASE = 'myPagesPrimaryMenu';

    protected static function description(): string
    {
        return __('My Pages Primary Menu (for logged in users)', MOD_MY_PAGES_TEXT_DOMAIN);
    }

    protected function afterLoginRedirectUrl(): string
    {
        return $this->acf->getOption('my_pages_primary_menu_after_sign_in_redirect_url') ?: '';
    }

    protected function label(): string
    {
        return $this->acf->getOption('my_pages_primary_menu_label') ?:
            __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN);
    }

    protected function active(): bool
    {
        return $this->acf->getOption('my_pages_primary_menu_active') ?: false;
    }

    protected function hideLabel(): bool
    {
        return $this->acf->getOption('my_pages_primary_menu_hide_label') ?: false;
    }

    public function scripts(): void
    {
        if ($this->active() && $this->query->getPostType() !== MyPages::POST_TYPE) {
            $this->script->wpEnqueueScript('mod-my-pages-js');
        }
    }
}
