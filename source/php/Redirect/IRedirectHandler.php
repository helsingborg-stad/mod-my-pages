<?php

namespace ModMyPages\Redirect;

interface IRedirectHandler
{
    public function redirectUrl(array $queryParams): string;
    public function shouldRedirect(array $queryParams): bool;
}
