<?php

namespace ModMyPages\Services\Types;

interface ITokenService
{
    public function __invoke(string $sessionId): string;
}
