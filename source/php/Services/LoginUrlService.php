<?php

namespace ModMyPages\Services;

use Closure;
use ModMyPages\Services\Types\ILoginUrlService;

class LoginUrlService implements ILoginUrlService
{
    protected Closure $createLoginUrl;

    public function __construct(
        string $apiUrl,
        string $homeUrl,
        string $defaultCallbackUrl,
        array $redirectUrlParams = []
    ) {
        $buildUrlWithQueryArgs = fn ($url, $params) => $url . '?'  . http_build_query($params);

        $buildRedirectUrl = fn (string $callbackUrl) => $buildUrlWithQueryArgs(
            $homeUrl . '/auth',
            array_merge(['callbackUrl' => $callbackUrl], $redirectUrlParams)
        );

        $buildLoginUrl = fn (string $callbackUrl = '') => $buildUrlWithQueryArgs(
            $apiUrl .  '/api/v1/auth/login',
            ['redirect_url' => $buildRedirectUrl(!empty($callbackUrl) ? $callbackUrl : $defaultCallbackUrl)]
        );

        $this->createLoginUrl = fn (string $callbackUrl = ''): string => $buildLoginUrl($callbackUrl);
    }

    function buildUrl(string $callbackUrl = ''): string
    {
        return ($this->createLoginUrl)($callbackUrl);
    }

    public function __invoke(string $callbackUrl = ''): string
    {
        return $this->buildUrl($callbackUrl);
    }
}
