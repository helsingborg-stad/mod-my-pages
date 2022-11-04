<?php

namespace ModMyPages\Service\TokenService;

interface ITokenService
{
    public function __invoke(string $sessionId): string;
}
