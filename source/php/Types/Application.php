<?php

namespace ModMyPages\Types;

class Application
{
    public bool $isAuthenticated;

    public string $serverPath;

    public array $protectedPages;

    public ApplicationServices $services;
}
