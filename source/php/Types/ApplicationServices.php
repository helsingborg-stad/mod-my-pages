<?php

namespace ModMyPages\Types;

use Closure;
use ModMyPages\Redirect\IUseRedirect;
use ModMyPages\Services\Types\ICookieRepository;
use ModMyPages\Services\Types\IGetQueriredObjectIdCallback;
use ModMyPages\Services\Types\ILoginUrlService;
use ModMyPages\Services\Types\IRedirectCallback;
use ModMyPages\Services\Types\ITokenService;


class ApplicationServices
{
    public ICookieRepository $cookies;

    public ILoginUrlService $loginUrl;

    public ITokenService $tokenService;

    public IUseRedirect $useRedirect;

    public function __construct(
        ICookieRepository $cookieRepository,
        ILoginUrlService $loginUrlService,
        ITokenService $tokenService,
        IUseRedirect $useRedirect
    ) {
        $this->cookies = $cookieRepository;
        $this->loginUrl = $loginUrlService;
        $this->tokenService = $tokenService;
        $this->useRedirect = $useRedirect;
    }
}
