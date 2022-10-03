<?php

namespace ModMyPages\Services\Types;

interface ILoginUrlServiceFactory
{
    public static function create(string $apiUrl, string $homeUrl, string $defaultCallbackUrl): ILoginUrlService;
}
