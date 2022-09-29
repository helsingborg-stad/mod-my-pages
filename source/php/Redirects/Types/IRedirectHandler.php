<?php

namespace ModMyPages\Redirects\Types;

interface IRedirectHandler
{
    public function redirectUrl(array $queryParams): string;
    public function shouldRedirect(array $queryParams): bool;
}

