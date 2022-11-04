<?php

namespace ModMyPages\Service\MenuService;

class MenuServiceFactory
{
    public static function createFromEnv(array $args = []): IMenuService
    {
        return new MenuService(
            self::createGetNavMenuLocations(),
            self::createGetNavMenuItems(),
        );
    }

    private static function createGetNavMenuLocations(): \Closure
    {
        $getNavMenuLocations = fn () => get_nav_menu_locations();
        $mockNavMenuLocations = fn () => ['my-pages-menu' => 'my-pages-menu'];

        return defined('PHPUNIT_RUNNING')
            ? $mockNavMenuLocations
            : $getNavMenuLocations;
    }

    private static function createGetNavMenuItems(): \Closure
    {
        $getNavMenuItems = fn (string $menu) => wp_get_nav_menu_items($menu);
        $mockGetNavMenuItems = fn (string $menu) => [];

        return defined('PHPUNIT_RUNNING')
            ? $mockGetNavMenuItems
            : $getNavMenuItems;
    }
}
