<?php

namespace ModMyPages\Types;

use Closure;
use ModMyPages\Redirect\IUseRedirect;
use ModMyPages\Service\CookieRepository\ICookieRepository;
use ModMyPages\Service\LoginUrlService\ILoginUrlService;
use ModMyPages\Service\MenuService\IMenuService;
use ModMyPages\Service\TokenService\ITokenService;

abstract class Application implements IApplicationRecipe
{
    public Closure $apiAuthSecret;

    public Closure $protectedPages;

    public ICookieRepository $cookies;

    public ILoginUrlService $loginUrl;

    public ITokenService $tokenService;

    public IUseRedirect $useRedirect;

    public IMenuService $getMenuItems;

    public function __construct(array $args)
    {
        $this->protectedPages = $args['protectedPages'];
        $this->apiAuthSecret = $args['apiAuthSecret'];
        $this->cookies = $args['cookieRepository'];
        $this->loginUrl = $args['loginUrlService'];
        $this->tokenService = $args['tokenService'];
        $this->useRedirect = $args['useRedirect'];
        $this->getMenuItems = $args['menuService'];
    }
}
