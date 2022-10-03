<?php

namespace ModMyPages\Types;

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

    function __construct(
        ICookieRepository $cookieRepository,
        IRedirectCallback $redirectCallback,
        IGetQueriredObjectIdCallback $getQueriedObjectId,
        ILoginUrlService $loginUrlService,
        ITokenService $tokenService
    ) {
        $this->cookieRepository = $cookieRepository;
        $this->redirectCallback = $redirectCallback;
        $this->getQueriedObjectId = $getQueriedObjectId;
        $this->loginUrlService = $loginUrlService;
        $this->tokenService = $tokenService;
    }
}
