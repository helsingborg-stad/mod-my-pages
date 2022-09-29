<?php

namespace ModMyPages\Redirects;

class NullRedirectCallback implements Types\IRedirectCallback
{
    public function __invoke(string $redirectUrl): void
    {
    }
}