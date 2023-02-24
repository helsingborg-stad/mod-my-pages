<?php

namespace ModMyPages\Service\WPService;

class WPServiceFactory
{
    public static function create(): WPService
    {
        return new class implements WPService
        {
            public function wpGetNavMenuItems($menu, $args = []): ?array
            {
                return wp_get_nav_menu_items($menu, $args) ?: null;
            }

            public function getNavMenuLocations(): array
            {
                return get_nav_menu_locations() ?? [];
            }

            public function registerNavMenu(string $location, string $description)
            {
                return register_nav_menu($location, $description);
            }
        };
    }
}
