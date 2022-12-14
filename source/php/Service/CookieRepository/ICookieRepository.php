<?php

namespace ModMyPages\Service\CookieRepository;

interface ICookieRepository
{
    public function get(string $key): string;
    public function set(
        string $key,
        string $value,
        int $cookieLength = 1200,
        string $cookieDomain = '',
        string $cookiePath = ''
    );
}
