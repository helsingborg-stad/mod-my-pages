<?php

namespace ModMyPages\Session;

use ModMyPages\Admin\Settings;

class Cookie
{
    private static $key = 'mypages_token';

    public static function set(string $value): void
    {
        if (empty($value)) {
            setcookie(self::$key, '', time() - 3600);
        }
        setcookie(self::$key, $value, time() + Settings::sessionLength(), '/', $_SERVER['SERVER_NAME'], true, true);
    }

    public static function get(): string
    {
        return $_COOKIE[self::$key] ?? '';
    }

    public static function name(): string
    {
        return self::$key;
    }
}
