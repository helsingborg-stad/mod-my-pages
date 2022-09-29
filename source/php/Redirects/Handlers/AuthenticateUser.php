<?php

namespace ModMyPages\Redirects\Handlers;

use ModMyPages\Token\AccessToken;
use ModMyPages\Services\Types\ITokenService;
use ModMyPages\Services\Types\ICookieRepository;
use ModMyPages\Redirects\Types\IRedirectHandler;

class AuthenticateUser implements IRedirectHandler
{
    private string $successUrl;

    private string $errorUrl;

    private ICookieRepository $cookies;

    private ITokenService $tokenService;

    public function __construct(array $args)
    {
        $this->successUrl = $args['successUrl'];
        $this->errorUrl = $args['errorUrl'];
        $this->cookies = $args['cookies'];
        $this->tokenService = $args['tokenService'];
    }

    public function redirectUrl(array $args): string
    {
        $jwt = ($this->tokenService)($args['ts_session_id']);

        if (!empty($jwt) && true) {
            $this->cookies->set(AccessToken::$cookieName, $jwt);
            return $args['callbackUrl'] ?? $this->successUrl;
        }

        return $this->errorUrl;
    }

    public function shouldRedirect(array $args): bool
    {
        return !empty($args['ts_session_id']);
    }
}
