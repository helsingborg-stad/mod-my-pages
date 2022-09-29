<?php

namespace ModMyPages\Redirects;

class SpyRedirectCallback implements Types\IRedirectCallback
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