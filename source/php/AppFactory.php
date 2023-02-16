<?php

namespace ModMyPages;

use ModMyPages\Admin\Settings;
use ModMyPages\App;
use ModMyPages\Redirect\UseRedirectFactory;
use ModMyPages\Service\CookieRepository\CookieRepositoryFactory;
use ModMyPages\Service\LoginUrlService\LoginUrlServiceFactory;
use ModMyPages\Service\MenuService\MenuServiceFactory;
use ModMyPages\Service\SignOutService\SignOutServiceFactory;
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
                    'menuService'           => MenuServiceFactory::createFromEnv(),
                    'apiAuthSecret'         => fn () => Settings::apiAuthSecret(),
                    'signOutRedirectUrl'    => fn () => Settings::signOutRedirectUrl(),
                    'myPagesMenu'           => fn () => Settings::myPagesMenu(),
                    'signOutService'        => SignOutServiceFactory::createFromEnv(),
                    'isProtectedPage'       => fn (): bool =>
                    get_queried_object_id() && in_array(
                        get_queried_object_id(),
                        Settings::protectedPages()
                    ),
                    'currentUrl'            => function () {
                        global $wp;
                        return home_url($wp->request) ?? '';
                    },
                    'getPostType'           => fn (int $postId = \null): string => get_post_type($postId) ?? ''
                ],
                $args
            )
        );
    }
}
