<?php

namespace ModMyPages\Types;

interface IApplicationFactory
{
    public static function create(array $args): Application;
}
