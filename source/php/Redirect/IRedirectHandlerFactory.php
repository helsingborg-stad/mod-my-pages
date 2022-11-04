<?php

namespace ModMyPages\Redirect;

interface IRedirectHandlerFactory
{
    public static function create(array $args): IRedirectHandler;
}
