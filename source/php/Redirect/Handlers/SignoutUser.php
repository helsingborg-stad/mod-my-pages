<?php

namespace ModMyPages\Redirect\Handlers;

use Closure;
use ModMyPages\Redirect\IRedirectHandler;
use ModMyPages\Redirect\IRedirectHandlerFactory;

class SignoutUser implements IRedirectHandler, IRedirectHandlerFactory
{
    private string $redirectUrl;

    private Closure $onRedirect;

    public function __construct($args)
    {
        $this->redirectUrl = $args['redirectUrl'];
        $this->onRedirect = $args['onRedirect'];
    }

    public function redirectUrl(array $args): string
    {
        ($this->onRedirect)();
        return $args['callbackUrl'] ?? $this->redirectUrl;
    }

    public function shouldRedirect(array $args): bool
    {
        return true;
    }

    public static function create(array $args = []): IRedirectHandler
    {
        return new SignoutUser($args);
    }
}
