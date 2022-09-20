<?php

namespace ModMyPages\Session;

class Cookie
{
    private static $key = 'mypages_token';

    public static function set(string $value): void
    {
        if (empty($value)) {
            setcookie(self::$key, '', time() - 3600);
        }
        setcookie(self::$key, $value, ['httpOnly' => true, 'secure' => true]);
    }

    public static function get(): string
    {
        return $_COOKIE[self::$key] ?? '';
    }
}

