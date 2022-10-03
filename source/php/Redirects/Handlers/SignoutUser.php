<?php

namespace ModMyPages\Redirects\Handlers;

use ModMyPages\Redirects\Types\IRedirectHandler;
use ModMyPages\Repository\Types\Cookie;
use ModMyPages\Services\Types\ICookieRepository;
use ModMyPages\Token\AccessToken;

class SignoutUser implements IRedirectHandler
{
    private ICookieRepository $cookies;

    private string $url;

    public function __construct(string $redirectUrl, ICookieRepository $cookies)
    {
        $this->url = $redirectUrl;
        $this->cookies = $cookies;
    }

    public function redirectUrl(array $args): string
    {
        $this->cookies->set(AccessToken::$cookieName, '');
        return $args['callbackUrl'] ?? $this->url;
    }

    public function shouldRedirect(array $args): bool
    {
        return true;
    }
}
