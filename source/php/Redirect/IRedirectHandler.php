<?php

namespace ModMyPages\Redirect;

interface IRedirectHandler
{
    public function redirect(array $args): string;
    public function validate(array $args): bool;
}

