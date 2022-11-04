<?php

namespace ModMyPages\Types;

use ModMyPages\Redirect\IUseRedirect;
use ModMyPages\Services\Types\ICookieRepository;
use ModMyPages\Services\Types\ILoginUrlService;
use ModMyPages\Services\Types\ITokenService;
use ModMyPages\Types\ApplicationServices;

abstract class Application implements IApplicationRecipe
{
    public bool $isAuthenticated;

    public string $serverPath;

    public string $apiAuthSecret;

    public array $protectedPages;

    public ICookieRepository $cookies;

    public ILoginUrlService $loginUrl;

    public ITokenService $tokenService;

    public IUseRedirect $useRedirect;

    public \Closure $getMenuItemsByMenuName;

    public function __construct(array $args)
    {
        $this->isAuthenticated = $args['isAuthenticated'];
        $this->serverPath = $args['serverPath'];
        $this->protectedPages = $args['protectedPages'];
        $this->apiAuthSecret = $args['apiAuthSecret'];
        $this->cookies = $args['cookieRepository'];
        $this->loginUrl = $args['loginUrlService'];
        $this->tokenService = $args['tokenService'];
        $this->useRedirect = $args['useRedirect'];
        $this->getMenuItemsByMenuName = $args['getMenuItemsByMenuName'];
    }
}
