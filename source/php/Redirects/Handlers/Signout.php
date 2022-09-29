<?php
namespace ModMyPages\Redirects\Handlers;

use ModMyPages\Repository\Types\Cookie;
use ModMyPages\Redirects\Types\IRedirectHandler;
use ModMyPages\Cookie\Types\ICookieRepository;
use ModMyPages\Cookie\Constants\AccessToken;

class Signout implements IRedirectHandler
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