<?php

namespace ModMyPages\Deprecated\Types;

use Closure;
use ModMyPages\Redirect\IUseRedirect;
use ModMyPages\Service\CookieRepository\ICookieRepository;
use ModMyPages\Service\LoginUrlService\ILoginUrlService;
use ModMyPages\Service\MenuService\IMenuService;
use ModMyPages\Service\TokenService\ITokenService;

/**
 * @deprecated
 */
abstract class Application implements IApplicationRecipe
{
    public Closure $apiAuthSecret;

    public ICookieRepository $cookies;

    public ILoginUrlService $loginUrl;

    public ITokenService $tokenService;

    public IUseRedirect $useRedirect;

    public IMenuService $menuService;

    public Closure $signOutRedirectUrl;

    public Closure $signOutService;

    public Closure $isProtectedPage;

    public Closure $currentUrl;

    public Closure $myPagesMenu;

    public Closure $getPostType;

    public function __construct(array $args)
    {
        $this->apiAuthSecret = $args['apiAuthSecret'];
        $this->cookies = $args['cookieRepository'];
        $this->loginUrl = $args['loginUrlService'];
        $this->tokenService = $args['tokenService'];
        $this->useRedirect = $args['useRedirect'];
        $this->menuService = $args['menuService'];
        $this->signOutRedirectUrl = $args['signOutRedirectUrl'];
        $this->signOutService = $args['signOutService'];
        $this->isProtectedPage = $args['isProtectedPage'];
        $this->currentUrl = $args['currentUrl'];
        $this->myPagesMenu = $args['myPagesMenu'];
        $this->getPostType = $args['getPostType'];
    }
}
