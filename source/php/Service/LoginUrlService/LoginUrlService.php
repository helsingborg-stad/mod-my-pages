<?php

namespace ModMyPages\Service\LoginUrlService;

use Closure;

class LoginUrlService implements ILoginUrlService
{
    protected Closure $createLoginUrl;

    public function __construct(
        Closure $apiUrl,
        Closure $homeUrl,
        Closure $defaultCallbackUrl,
        array $redirectUrlParams = []
    ) {
        $buildUrlWithQueryArgs = fn($url, $params): string => $url .
            '?' .
            http_build_query($params);

        $buildRedirectUrl = fn(string $callbackUrl): string => $buildUrlWithQueryArgs(
            $homeUrl() . '/auth',
            array_merge(['callbackUrl' => $callbackUrl], $redirectUrlParams)
        );

        $buildLoginUrl = fn(string $callbackUrl = ''): string => $buildUrlWithQueryArgs(
            $apiUrl() . '/api/v1/auth/login',
            [
                'redirect_url' => $buildRedirectUrl(
                    !empty($callbackUrl) ? $callbackUrl : $defaultCallbackUrl()
                ),
            ]
        );

        $this->createLoginUrl = fn(string $callbackUrl = ''): string => $buildLoginUrl(
            $callbackUrl
        );
    }

    public function buildUrl(?string $url = ''): string
    {
        return ($this->createLoginUrl)($url);
    }

    public function __invoke(?string $url = ''): string
    {
        return $this->buildUrl($url);
    }
}
