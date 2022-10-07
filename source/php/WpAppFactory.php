<?php

namespace ModMyPages;

use ModMyPages\Admin\Settings;
use ModMyPages\AppFactory;
use ModMyPages\Services\CookieRepository;
use ModMyPages\Services\GetQueriedObjectId;
use ModMyPages\Services\LoginUrlServiceFactory;
use ModMyPages\Services\RedirectCallback;
use ModMyPages\Services\TokenService;
use ModMyPages\Token\AccessToken;
use ModMyPages\Types\Application;
use ModMyPages\Types\IApplicationFactory;

class WpAppFactory implements IApplicationFactory
{
    public static function create(array $args = []): Application
    {
        $homeUrlPath = parse_url(home_url());
        $serverPath = empty($homeUrlPath['path'])
            ? $_SERVER['REQUEST_URI']
            : str_replace($homeUrlPath['path'], '', $_SERVER['REQUEST_URI']);

        return AppFactory::create([
            'isAuthenticated'   => !empty($_COOKIE[AccessToken::$cookieName]),
            'cookieDomain'      => $_SERVER['SERVER_NAME'] ?? '',
            'serverPath'        => $serverPath,
            'protectedPages'    => get_posts(
                [
                    'post_type' => 'page',
                    'posts_per_page' => -1,
                    'meta_key' => 'mod_my_pages_protected_page',
                    'meta_value' => 1,
                    'fields' => 'ids'
                ]
            ) ?? [],
            'cookieRepository'      => new CookieRepository(),
            'redirectCallback'      => new RedirectCallback(),
            'getQueriedObjectId'    => new GetQueriedObjectId(),
            'tokenService'          => new TokenService(),
            'loginUrlService'       => LoginUrlServiceFactory::create(
                Settings::apiUrl(),
                home_url(),
                home_url('/mina-sidor'),
                defined('WP_DEBUG') && WP_DEBUG ? ['debug' => 1] : []
            ),
        ]);
    }
}
