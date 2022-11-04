<?php

namespace ModMyPages\Test;

use ModMyPages\Service\CookieRepository\CookieRepositoryFactory;
use ModMyPages\Services\Mock\MockTokenService;
use ModMyPages\Token\AccessToken;

class UseRedirectTest extends PluginTestCase
{
    public function testShouldNotRedirect()
    {
        $redirectSpy = $this->createRedirectSpy();

        $this->createFakeApp([
            'mockPath'                  => '/',
            'mockRedirectCallback'      => $redirectSpy,
        ])
            ->run()
            ->redirect();

        $this->assertCount(0, $redirectSpy());
    }
}
