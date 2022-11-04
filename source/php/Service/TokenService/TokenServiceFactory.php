<?php

namespace ModMyPages\Service\TokenService;

class TokenServiceFactory
{
    public static function createFromEnv(array $args = []): ITokenService
    {
        return defined('PHPUNIT_RUNNING')
            ? new MockTokenService($args['mockTokenResponse'] ?? '')
            : new TokenService();
    }
}
