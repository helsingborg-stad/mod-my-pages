<?php

namespace ModMyPages\Service\CookieRepository;

use ModMyPages\Service\CookieRepository\CookieRepository;
use ModMyPages\Service\CookieRepository\ICookieRepository;
use ModMyPages\Service\CookieRepository\MemoryCookieRepository;

class CookieRepositoryFactory
{
    public static function createFromEnv(): ICookieRepository
    {
        return !defined('PHPUNIT_RUNNING') ? new CookieRepository() : new MemoryCookieRepository();
    }
}
