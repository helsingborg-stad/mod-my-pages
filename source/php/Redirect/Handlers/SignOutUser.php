<?php

namespace ModMyPages\Redirect\Handlers;

use Closure;
use ModMyPages\Redirect\IRedirectHandler;
use ModMyPages\Redirect\IRedirectHandlerFactory;

class SignOutUser implements IRedirectHandler, IRedirectHandlerFactory
{
    private string $redirectUrl;

    private Closure $onRedirect;

    public function __construct(array $args)
    {
        $this->redirectUrl = $args['redirectUrl'];
        $this->onRedirect = $args['onRedirect'];
    }

    public function redirectUrl(array $queryParams): string
    {
        ($this->onRedirect)();
        return $queryParams['callbackUrl'] ?? $this->redirectUrl;
    }

    public function shouldRedirect(array $queryParams): bool
    {
        return true;
    }

    public static function create(array $args = []): IRedirectHandler
    {
        return new SignOutUser($args);
    }
}
