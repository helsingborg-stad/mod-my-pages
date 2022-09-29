<?php

namespace ModMyPages\Cookie;

class MemoryCookieRepository extends CookieRepository implements Types\ICookieRepository
{
    public array $cookies = [];

    public function get(string $key): string
    {
        return !empty($this->cookies[$key]) ? $this->cookies[$key]['value'] : '';
    }

    public function set(string $key, string $value, int $cookieLength = 1200, string $cookieDomain = '', string $cookiePath = '/')
    {
        if (!empty($value)) {
            $this->cookies[$key] = [
                'value' => $value,
                'cookieLength' => empty($cookieLength) ? $this->expiredDate() : $this->coookieLength($cookieLength),
                'cookieDomain' => $cookieDomain,
                'cookiePath'   => $cookiePath
            ];

            return;
        }

        if (empty($value) && !empty($this->cookies[$key])) {
            unset($this->cookies[$key]);
        }
    }
}
