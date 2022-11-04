<?php

namespace ModMyPages\Service\LoginUrlService;

interface ILoginUrlService
{
    public function __invoke(string $url): string;

    public function buildUrl(string $url = ''): string;
}
