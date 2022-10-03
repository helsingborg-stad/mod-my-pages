<?php

namespace ModMyPages\Services\Mock;

use ModMyPages\Services\Types\IRedirectCallback;

class NullRedirectCallback implements IRedirectCallback
{
    public function __invoke(string $redirectUrl): void
    {
    }
}
