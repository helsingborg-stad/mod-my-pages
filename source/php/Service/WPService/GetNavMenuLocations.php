<?php

namespace ModMyPages\Service\WPService;

interface GetNavMenuLocations
{
    /**
     * get_nav_menu_locations
     * Registered navigation menu locations and the menus assigned them. If none are registered, an empty array.
     *
     * @return array
     */
    public function getNavMenuLocations(): array;
}
