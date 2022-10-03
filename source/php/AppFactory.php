<?php

namespace ModMyPages;

use ModMyPages\Types\Application;
use ModMyPages\Types\ApplicationServices;
use ModMyPages\Types\IApplicationFactory;

class AppFactory implements IApplicationFactory
{
    public static function create(array $args): Application
    {
        return new App(
            $args['isAuthenticated'],
            $args['serverPath'],
            $args['protectedPages'],
            new ApplicationServices(
                $args['cookieRepository'],
                $args['redirectCallback'],
                $args['getQueriedObjectId'],
                $args['loginUrlService'],
                $args['tokenService'],
            ),
        );
    }
}
