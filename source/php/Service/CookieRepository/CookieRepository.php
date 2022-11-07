<?php

namespace ModMyPages\Service\CookieRepository;

use ModMyPages\Service\CookieRepository\ICookieRepository;

class CookieRepository implements ICookieRepository
{
    public function get(string $key): string
    {
        return $_COOKIE[$key] ?? '';
    }

    public function set(
        string $key,
        string $value,
        int $cookieLength = 1200,
        string $cookieDomain = '',
        string $cookiePath = ''
    ) {

        if (!headers_sent()) {
            if (
                !setcookie($key, $value, [
                    'expires'   => empty($value) ? $this->expiredDate() : 0,
                    'secure'    => true,
                    'httponly'  => true,
                    'path'      => '/',
                ])
                && defined('WP_DEBUG') && WP_DEBUG
            ) {
                error_log(print_r(new \WP_Error('Failed to set cookie'), true));
            }
        } elseif (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(print_r(new \WP_Error('Header already sent'), true));
        }
    }

    public function cookieLength(int $lengthInSeconds): int
    {
        return $this->time() + $lengthInSeconds;
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
