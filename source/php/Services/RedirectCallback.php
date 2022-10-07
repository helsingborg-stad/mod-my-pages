<?php

namespace ModMyPages\Services;

use ModMyPages\Helper\PageCache;
use ModMyPages\Services\Types\IRedirectCallback;

class RedirectCallback implements IRedirectCallback
{
    public function __invoke(string $redirectUrl): void
    {
        PageCache::bypass();
        wp_redirect($redirectUrl);
        exit;
    }
}
