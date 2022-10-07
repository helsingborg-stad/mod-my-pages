<?php

namespace ModMyPages\Redirects\Handlers;

use ModMyPages\Redirects\Types\IRedirectHandler;
use ModMyPages\Services\Types\ICookieRepository;
use ModMyPages\Services\Types\ITokenService;
use ModMyPages\Token\AccessToken;

class AuthenticateUser implements IRedirectHandler
{
    private string $successUrl;

    private string $errorUrl;

    private ICookieRepository $cookies;

    private ITokenService $tokenService;

    private string $cookieDomain;

    public function __construct(array $args)
    {
        $this->successUrl = $args['successUrl'];
        $this->errorUrl = $args['errorUrl'];
        $this->cookies = $args['cookies'];
        $this->tokenService = $args['tokenService'];
        $this->cookieDomain = $args['cookieDomain'] ?? '';
    }

    public function redirectUrl(array $args): string
    {
        $jwt = ($this->tokenService)($args['ts_session_id']);

        if (!empty($jwt)) {
            $this->cookies->set(AccessToken::$cookieName, $jwt, 1200, $this->cookieDomain);
            return $args['callbackUrl'] ?? $this->successUrl;
        }

        return $this->errorUrl;
    }

    public function shouldRedirect(array $args): bool
    {
        return !empty($args['ts_session_id']);
    }
}
