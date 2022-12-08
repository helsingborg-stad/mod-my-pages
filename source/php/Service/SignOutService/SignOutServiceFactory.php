<?php

namespace ModMyPages\Service\SignOutService;

class SignOutServiceFactory
{
    public static function createFromEnv(array $args = []): \Closure
    {
        return defined('PHPUNIT_RUNNING')
            ? function (string $token) {
                //Do nothing
            }
            : function (string $token) {
                SignOutService::signOut($token);
            };
    }
}
