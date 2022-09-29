<?php

namespace ModMyPages\Services\Mock;

use ModMyPages\Services\Types\ITokenService;
use ModMyPages\Admin\Settings;

class MockTokenService implements ITokenService
{
    public string $response;

    public function __construct(string $mockResponse)
    {
        $this->response = $mockResponse;
    }

    public function __invoke(string $sessionId): string
    {
        return $this->response;
    }
}
