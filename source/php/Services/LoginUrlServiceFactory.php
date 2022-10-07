<?php

namespace ModMyPages\Services;

use ModMyPages\Services\Types\ILoginUrlService;
use ModMyPages\Services\Types\ILoginUrlServiceFactory;

class LoginUrlServiceFactory implements ILoginUrlServiceFactory
{
    public static function create(string $apiUrl, string $homeUrl, string $defaultCallbackUrl, array $redirectUrlParams = []): ILoginUrlService
    {
        return new LoginUrlService($apiUrl, $homeUrl, $defaultCallbackUrl, $redirectUrlParams);
    }
}
