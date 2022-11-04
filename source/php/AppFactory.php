<?php

namespace ModMyPages;

use ModMyPages\Admin\Settings;
use ModMyPages\App;
use ModMyPages\Redirect\UseRedirectFactory;
use ModMyPages\Service\CookieRepository\CookieRepositoryFactory;
use ModMyPages\Services\CookieRepository;
use ModMyPages\Services\LoginUrlServiceFactory;
use ModMyPages\Services\TokenService;
use ModMyPages\Token\AccessToken;
use ModMyPages\Types\Application;
use ModMyPages\Types\ApplicationServices;
use ModMyPages\Types\IApplicationFactory;

class AppFactory implements IApplicationFactory
{
    public static function create(array $args = []): Application
    {
        return new App(
            array_merge(
                [
                    'useRedirect' => UseRedirectFactory::createFromEnv(),
                    'cookieRepository'      => CookieRepositoryFactory::createFromEnv(),
                    'protectedPages'    => fn () => get_posts(
                        [
                            'post_type' => 'page',
                            'posts_per_page' => -1,
                            'meta_key' => 'mod_my_pages_protected_page',
                            'meta_value' => 1,
                            'fields' => 'ids'
                        ]
                    ) ?? [],
                    'tokenService'          => new TokenService(),
                    'loginUrlService'       => LoginUrlServiceFactory::create(
                        Settings::apiUrl(),
                        home_url(),
                        home_url('/mina-sidor'),
                        defined('WP_DEBUG') && WP_DEBUG ? ['debug' => 1] : []
                    ),
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
                ],
                $args
            )
        );
    }
}
