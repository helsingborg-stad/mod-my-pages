<?php

namespace ModMyPages\Types;

use Closure;
use ModMyPages\Redirect\IUseRedirect;
use ModMyPages\Services\Types\ICookieRepository;
use ModMyPages\Services\Types\ILoginUrlService;
use ModMyPages\Services\Types\ITokenService;

abstract class Application implements IApplicationRecipe
{
    public Closure $apiAuthSecret;

    public Closure $protectedPages;

    public ICookieRepository $cookies;

    public ILoginUrlService $loginUrl;

    public ITokenService $tokenService;

    public IUseRedirect $useRedirect;

    public Closure $getMenuItemsByMenuName;

    public function __construct(array $args)
    {
        $this->protectedPages = $args['protectedPages'];
        $this->apiAuthSecret = $args['apiAuthSecret'];
        $this->cookies = $args['cookieRepository'];
        $this->loginUrl = $args['loginUrlService'];
        $this->tokenService = $args['tokenService'];
        $this->useRedirect = $args['useRedirect'];
        $this->getMenuItemsByMenuName = $args['getMenuItemsByMenuName'];
    }
}
