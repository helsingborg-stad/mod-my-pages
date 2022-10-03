<?php

namespace ModMyPages\Services\Types;

interface ILoginUrlService
{
    public function __invoke(string $url): string;

    public function buildUrl(string $url = ''): string;
}
