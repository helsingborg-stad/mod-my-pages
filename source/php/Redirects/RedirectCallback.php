<?php

namespace ModMyPages\Redirects;

class RedirectCallback implements Types\IRedirectCallback
{
    public function __invoke(string $redirectUrl): void
    {
        wp_redirect($redirectUrl);
        exit;
    }
}