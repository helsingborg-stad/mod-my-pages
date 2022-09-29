<?php

namespace ModMyPages;

use ModMyPages\Types\ApplicationFactory;
use ModMyPages\Types\Application;
use ModMyPages\Types\ApplicationServices;
use ModMyPages\Cookie\CookieRepository;
use ModMyPages\Redirects\RedirectCallback;
use ModMyPages\Services\GetQueriedObjectId;
use ModMyPages\Services\TokenService;
use ModMyPages\Cookie\Constants\AccessToken;

class CreateApp implements ApplicationFactory
{
    public function __invoke(): Application
    {
        return $this->create(
            [
                'isAuthenticated'   => !empty($_COOKIE[AccessToken::$cookieName]),
                'cookieDomain'      => $_SERVER['SERVER_NAME'] ?? '',
                'serverPath'        => $_SERVER['PHP_SELF'],
                'protectedPages'    => get_posts(
                    [
                        'post_type' => 'page',
                        'posts_per_page' => -1,
                        'meta_key' => 'mod_my_pages_protected_page',
                        'meta_value' => 1,
                        'fields' => 'ids'
                    ]) ?? [],    
            ],
            $this->createServices(
                [
                    'cookieRepository'      => new CookieRepository(),
                    'redirectCallback'      => new RedirectCallback(),
                    'getQueriedObjectId'    => new GetQueriedObjectId(),
                    'tokenService'          => new TokenService()
                ],
            )
        );
    }

    public function createServices(array $services) : ApplicationServices
    {
        return \ModMyPages\Helper\Type::cast(
            $services,
            '\ModMyPages\Types\ApplicationServices'
        );
    }

    public function create(array $options, ApplicationServices $services): Application
    {
        return \ModMyPages\Helper\Type::cast(
            array_merge($options, ['services' => $services]),
            '\ModMyPages\App'
        );
    }
}
