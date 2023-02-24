<?php

namespace ModMyPages\Service\WPService;

interface RegisterNavMenu
{

    /**
     * register_nav_menu
     * Registers a navigation menu location for a theme.
     *
     * @param string $location — Menu location identifier, like a slug.
     * @param string $description — Menu location descriptive text.
     * @return mixed
     */
    public function registerNavMenu(string $location, string $description);
}
