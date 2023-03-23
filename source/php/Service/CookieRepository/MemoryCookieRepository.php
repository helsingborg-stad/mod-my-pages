<?php

namespace ModMyPages\Service\CookieRepository;

use ModMyPages\Service\CookieRepository\CookieRepository;

class MemoryCookieRepository extends CookieRepository implements ICookieRepository
{
    public static array $cookies = [];

    public function get(string $key): string
    {
        return !empty(self::$cookies[$key]) ? self::$cookies[$key]['value'] : '';
    }

    /**
     * @return void
     */
    public function set(
        string $key,
        string $value,
        int $cookieLength = 1200,
        string $cookieDomain = '',
        string $cookiePath = '/'
    ) {
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
