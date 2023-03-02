<?php

namespace ModMyPages\Service\LoginUrlService;

use ModMyPages\Admin\Settings;

class LoginUrlServiceFactory
{
    public static function createFromEnv(array $args = []): ILoginUrlService
    {
        return new LoginUrlService(
            self::createApiUrl($args['apiUrl'] ?? ''),
            self::createHomeUrl($args['homeUrl'] ?? ''),
            self::createDefaultCallbackUrl($args['defaultCallbackUrl'] ?? ''),
            self::createQueryArgsForRedirectUrl()
        );
    }

    private static function createApiUrl(string $mockUrl = ''): \Closure
    {
        $apiUrl = fn () => Settings::apiUrl();
        $mockApiUrl = fn () => !empty($mockUrl) ? $mockUrl : 'http://localhost:3000';

        return defined('PHPUNIT_RUNNING')
            ? $mockApiUrl
            : $apiUrl;
    }

    private static function createHomeUrl(string $mockUrl = ''): \Closure
    {
        $homeUrl = fn () => home_url();
        $mockHomeUrl = fn () => !empty($mockUrl) ? $mockUrl : 'http://example.test';

        return defined('PHPUNIT_RUNNING')
            ? $mockHomeUrl
            : $homeUrl;
    }

    private static function createDefaultCallbackUrl(string $mockUrl = ''): \Closure
    {
        $defaultCallbackUrl = fn (): string => Settings::signInRedirectUrl();

        $mockDefaultCallbackUrl = fn () => !empty($mockUrl) ? $mockUrl : 'http://example.test/mina-sidor';

        return defined('PHPUNIT_RUNNING')
            ? $mockDefaultCallbackUrl
            : $defaultCallbackUrl;
    }

    private static function createQueryArgsForRedirectUrl(array $queryArgs = []): array
    {
        return defined('WP_DEBUG') && WP_DEBUG
            ? array_merge(['debug' => 1], $queryArgs)
            : $queryArgs;
    }
}
