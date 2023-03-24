<?php

namespace ModMyPages\Redirect;

use ModMyPages\Redirect\IUseRedirect;

class UseRedirectFactory
{
    public static function createFromEnv(array $args = []): IUseRedirect
    {
        return new UseRedirect(
            self::createServerPathCallback($args['mockPath'] ?? '/'),
            self::createRedirectCallback($args['mockRedirectCallback'] ?? null)
        );
    }

    private static function createServerPathCallback(string $mockPath): \Closure
    {
        $serverPathCallback = function (): string {
            $homeUrlPath = parse_url(home_url());
            return empty($homeUrlPath['path'])
                ? $_SERVER['REQUEST_URI']
                : str_replace($homeUrlPath['path'], '', $_SERVER['REQUEST_URI']);
        };

        $mockCallback = fn(): string => $mockPath;

        return !defined('PHPUNIT_RUNNING') ? $serverPathCallback : $mockCallback;
    }

    private static function createRedirectCallback(\Closure $mockCallback = null): \Closure
    {
        $wpRedirectCallback = function (string $redirectUrl): void {
            wp_redirect($redirectUrl);
            exit();
        };

        $nullCallback = function (string $redirectUrl) use ($mockCallback): void {
            $mockCallback ? $mockCallback($redirectUrl) : null;
        };

        return !defined('PHPUNIT_RUNNING') ? $wpRedirectCallback : $nullCallback;
    }
}
