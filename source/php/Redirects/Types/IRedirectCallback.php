<?php

namespace ModMyPages\Redirects\Types;

interface IRedirectCallback
{
    public function __invoke(string $redirectUrl): void;
}
