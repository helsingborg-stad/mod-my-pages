<?php

namespace ModMyPages\Menu;

use ModMyPages\Menu\ViewModel\DropdownMenu;
use ModMyPages\Menu\ViewModel\DropdownMenuItem;

abstract class AbstractDropdownMenu extends AbstractMenu
{
    /**
     * @psalm-suppress CircularReference
     */
    const MENU_SLUG_CAMEL_CASE = self::MENU_SLUG_CAMEL_CASE;

    abstract protected function label(): string;

    protected function active(): bool
    {
        return false;
    }

    protected function hideLabel(): bool
    {
        return false;
    }

    protected function hideIcon(): bool
    {
        return false;
    }

    protected function onlyShowForAuthenciated(): bool
    {
        return false;
    }

    protected function afterLoginRedirectUrl(): string
    {
        return '';
    }

    /**
     * @param \WP_Post $post
     * @return DropdownMenuItem
     */
    protected function mapItem($post)
    {
        return DropdownMenuItem::create(
            $post->title,
            $post->url,
            array_merge($post->classes, ['show-authenticated']),
            [],
            ['data-no-instant' => '']
        );
    }

    /**
     *
     * @return list{DropdownMenuItem}|array<never, never>
     */
    protected function loginButton(): array
    {
        /**
         * @psalm-suppress CircularReference
         */
        return [
            DropdownMenuItem::create(
                __('Login', MOD_MY_PAGES_TEXT_DOMAIN),
                ($this->createLoginUrl)($this->afterLoginRedirectUrl()),
                ['hide-authenticated'],
                ['id' => static::MENU_SLUG_CAMEL_CASE . '-login'],
                [
                    'data-no-instant' => '',
                    'id' => static::MENU_SLUG . '-logout',
                ]
            ),
        ];
    }

    /**
     *
     * @return list{DropdownMenuItem}
     */
    protected function logoutButton(): array
    {
        /**
         * @psalm-suppress CircularReference
         */
        return [
            DropdownMenuItem::create(
                __('Logout', MOD_MY_PAGES_TEXT_DOMAIN),
                $this->site->homeUrl('/signout'),
                ['show-authenticated'],
                [],
                [
                    'data-no-instant' => '',
                    'id' => static::MENU_SLUG . '-logout',
                ]
            ),
        ];
    }

    /**
     * @param list{DropdownMenuItem} $items
     */
    public function controller($items): array
    {
        $menuItems = [...$this->loginButton(), ...$items, ...$this->logoutButton()];

        /**
         * @psalm-suppress CircularReference
         */
        $viewModel = DropdownMenu::create(
            static::MENU_SLUG,
            $this->label(),
            $this->active(),
            [
                'hideLabel' => $this->hideLabel(),
                'hideIcon' => $this->hideIcon(),
                'onlyShowForAuthenciated' => $this->onlyShowForAuthenciated(),
            ],
            ...$menuItems
        );

        /**
         * @psalm-suppress CircularReference
         */
        return [static::MENU_SLUG_CAMEL_CASE => $viewModel];
    }
}
