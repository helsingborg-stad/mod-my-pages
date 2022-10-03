<?php

namespace ModMyPages\Types;

use ModMyPages\Types\ApplicationServices;

abstract class Application implements IApplicationRecipe
{
    public bool $isAuthenticated;

    public string $serverPath;

    public array $protectedPages;

    public ApplicationServices $services;

    function __construct(
        bool $isAuthenticated,
        string $serverPath,
        array $protectedPages,
        ApplicationServices $services
    ) {
        $this->isAuthenticated = $isAuthenticated;
        $this->serverPath = $serverPath;
        $this->protectedPages = $protectedPages;
        $this->services = $services;
    }
}
