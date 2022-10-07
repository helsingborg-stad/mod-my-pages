<?php

namespace ModMyPages\Types;

use Closure;
use ModMyPages\Services\Types\ICookieRepository;
use ModMyPages\Services\Types\IGetQueriredObjectIdCallback;
use ModMyPages\Services\Types\ILoginUrlService;
use ModMyPages\Services\Types\IRedirectCallback;
use ModMyPages\Services\Types\ITokenService;


class ApplicationServices
{
    public ICookieRepository $cookieRepository;

    public IRedirectCallback $redirectCallback;

    public IGetQueriredObjectIdCallback $getQueriedObjectId;

    public ILoginUrlService $loginUrlService;

    public ITokenService $tokenService;

    public Closure $pageCacheBust;

    public function __construct(
        ICookieRepository $cookieRepository,
        IRedirectCallback $redirectCallback,
        IGetQueriredObjectIdCallback $getQueriedObjectId,
        ILoginUrlService $loginUrlService,
        ITokenService $tokenService,
        Closure $pageCacheBust
    ) {
        $this->cookieRepository = $cookieRepository;
        $this->redirectCallback = $redirectCallback;
        $this->getQueriedObjectId = $getQueriedObjectId;
        $this->loginUrlService = $loginUrlService;
        $this->tokenService = $tokenService;
        $this->pageCacheBust = $pageCacheBust;
    }
}
