<?php

namespace ModMyPages\Services\Mock;

use ModMyPages\Services\Types\IRedirectCallback;

class SpyRedirectCallback implements IRedirectCallback
{
    public static array $redirects;
    public function __construct()
    {
        self::$redirects = [];
    }

    public function __invoke(string $redirectUrl): void
    {
        self::$redirects[] = $redirectUrl;
    }
}
