<?php

namespace ModMyPages\Service\WPService;

interface WpGetNavMenuItems
{

    /**
     * wp_get_nav_menu_items
     * Retrieves all menu items of a navigation menu.
     *
     * @param string $menu — Menu ID, slug, name
     * @param array $args — { Optional. Arguments to pass to get_posts().
     * @return array|null — Array of menu items, otherwise null.
     */
    public function wpGetNavMenuItems(string $menu, ?array $args = []): ?array;
}
