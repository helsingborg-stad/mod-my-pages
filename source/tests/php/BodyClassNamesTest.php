<?php

namespace ModMyPages\Test;

use ModMyPages\Services\Mock\MemoryCookieRepository;
use ModMyPages\Token\AccessToken;

class BodyClassNamesTest extends PluginTestCase
{
    public function testUserIsAuthenticated()
    {
        $cookieRepository = new MemoryCookieRepository();
        $cookieRepository->set(AccessToken::$cookieName, $this->createFakeToken());

        $app = $this->createFakeApp(
            [
                'isAuthenticated'   => true,
                'cookieRepository'  => $cookieRepository
            ]
        )
            ->run();

        $classNames = ['home', 'example-css-class'];
        $bodyClassNames = $app->bodyClassNames($classNames);

        $this->assertCount(count($classNames) + 1, $bodyClassNames);
        $this->assertContains('is-authenticated', $bodyClassNames);
    }

    public function testUserIsNotAuthenticated()
    {
        $cookieRepository = new MemoryCookieRepository();
        $cookieRepository->set(AccessToken::$cookieName, '');

        $app = $this->createFakeApp(
            [
                'isAuthenticated'   => false,
                'cookieRepository'  => $cookieRepository
            ]
        )
            ->run();

        $classNames = ['home', 'example-css-class'];
        $bodyClassNames = $app->bodyClassNames($classNames);

        $this->assertEquals($classNames, $bodyClassNames);
    }
}
