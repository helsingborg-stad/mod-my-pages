<?php

namespace ModMyPages\Cookie;

class MemoryCookieRepository extends CookieRepository implements Types\ICookieRepository
{
    public static array $cookies = [];

    public function get(string $key): string
    {
        return !empty(self::$cookies[$key]) ? self::$cookies[$key]['value'] : '';
    }

    public function set(string $key, string $value, int $cookieLength = 1200, string $cookieDomain = '', string $cookiePath = '/')
    {
        if (!empty($value)) {
            self::$cookies[$key] = [
                'value' => $value,
                'cookieLength' => empty($cookieLength) ? $this->expiredDate() : $this->cookieLength($cookieLength),
                'cookieDomain' => $cookieDomain,
                'cookiePath'   => $cookiePath
            ];

            return;
        }

        if (empty($value) && !empty(self::$cookies[$key])) {
            unset(self::$cookies[$key]);
        }
    }
}
