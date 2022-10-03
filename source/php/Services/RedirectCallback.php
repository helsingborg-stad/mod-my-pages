<?php

namespace ModMyPages\Services;

use ModMyPages\Services\Types\IRedirectCallback;

class RedirectCallback implements IRedirectCallback
{
    public function __invoke(string $redirectUrl): void
    {
        wp_redirect($redirectUrl);
        exit;
    }
}
