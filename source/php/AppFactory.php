<?php

namespace ModMyPages;

use ModMyPages\App;
use ModMyPages\Redirect\UseRedirectFactory;
use ModMyPages\Service\CookieRepository\CookieRepositoryFactory;
use ModMyPages\Service\LoginUrlService\LoginUrlServiceFactory;
use ModMyPages\Service\TokenService\TokenServiceFactory;
use ModMyPages\Types\Application;

class AppFactory
{
    public static function createFromEnv(array $args = []): Application
    {
        return new App(
            array_merge(
                [
                    'useRedirect'           => UseRedirectFactory::createFromEnv(),
                    'cookieRepository'      => CookieRepositoryFactory::createFromEnv(),
                    'loginUrlService'       => LoginUrlServiceFactory::createFromEnv(),
                    'tokenService'          => TokenServiceFactory::createFromEnv(),
                    'apiAuthSecret'         => fn () => get_field('mod_my_pages_api_auth_secret', 'options') ?? '',
                    'getMenuItemsByMenuName' => function ($menuName) {
                        $toArray = fn ($items) => array_map(fn ($obj) => (array) $obj, $items);
                        $getMenuItemsByMenuName = fn ($name) => $toArray(
                            wp_get_nav_menu_items(
                                get_nav_menu_locations()[$name] ?? 0
                            ) ?? []
                        );
                        return $getMenuItemsByMenuName($menuName);
                    },
                    'protectedPages'        => fn () => get_posts(
                        [
                            'post_type' => 'page',
                            'posts_per_page' => -1,
                            'meta_key' => 'mod_my_pages_protected_page',
                            'meta_value' => 1,
                            'fields' => 'ids'
                        ]
                    ) ?? [],
                ],
                $args
            )
        );
    }
}
