<?php

namespace ModMyPages\Test;

use ModMyPages\Service\CookieRepository\CookieRepositoryFactory;
use ModMyPages\Token\AccessToken;

class SignoutUserTest extends PluginTestCase
{
    public function testShouldRemoveCookie()
    {
        $redirectSpy = $this->createRedirectSpy();
        $cookieRepository = CookieRepositoryFactory::createFromEnv();
        $cookieRepository->set(AccessToken::$cookieName, $this->createFakeToken());

        $this->createFakeApp([
            'mockPath'              => '/signout',
            'mockRedirectCallback'  => $redirectSpy,
            'cookieRepository'      => $cookieRepository,
        ])
            ->run()
            ->redirect();

        $this->assertEquals('', $cookieRepository->get(AccessToken::$cookieName));
    }

    public function testShouldRedirect()
    {
        $redirectSpy = $this->createRedirectSpy();

        $this->createFakeApp([
            'mockPath'              => '/signout',
            'mockRedirectCallback'  => $redirectSpy
        ])
            ->run()
            ->redirect();

        $this->assertCount(1, $redirectSpy());
    }
}
