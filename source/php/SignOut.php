<?php

namespace ModMyPages;

class SignOut implements \ModMyPages\Redirect\IRedirectHandler
{
    private string $successUrl;
    private string $errorUrl;

    public function __construct(array $args)
    {
        $this->successUrl = $args['successUrl'];
        $this->errorUrl = $args['errorUrl'];
    }

    public function validate(array $args): bool
    {
        var_dump(\ModMyPages\Session\Cookie::get());
        return !empty(\ModMyPages\Session\Cookie::get());
    }

    public function redirect(array $args): string
    {
        \ModMyPages\Session\Cookie::set("");
        return $args['callbackUrl'] ?? $this->successUrl;
    }
}
