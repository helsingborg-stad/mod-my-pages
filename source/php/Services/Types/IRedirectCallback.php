<?php

namespace ModMyPages\Services\Types;

interface IRedirectCallback
{
    public function __invoke(string $redirectUrl): void;
}
