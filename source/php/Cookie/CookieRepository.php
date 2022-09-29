<?php

namespace ModMyPages\Cookie;

class CookieRepository implements Types\ICookieRepository
{
    public function get(string $key): string
    {
        return $_COOKIE[$key] ?? '';
    }

    public function set(string $key, string $value, int $cookieLength = 1200, string $cookieDomain = '', string $cookiePath = '')
    {
        $expiryDate = empty($value) ? $this->expiredDate() : $this->cookieLength($cookieLength);
        setcookie($key, $value, $expiryDate, $cookiePath, $cookieDomain, true, true);
    }

    public function cookieLength(int $lengthInSeconds): int
    {
        return time() + $lengthInSeconds;
    }

    public function expiredDate(): int
    {
        return $this->time() - 3600;
    }

    public function time()
    {
        return time();
    }
}
