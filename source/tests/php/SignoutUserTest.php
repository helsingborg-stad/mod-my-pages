<?php

namespace ModMyPages\Test;

use ModMyPages\Token\AccessToken;
use ModMyPages\Services\Mock\SpyRedirectCallback;
use ModMyPages\Services\Mock\MemoryCookieRepository;

class SignoutUserTest extends PluginTestCase
{
    public function testRemoveCookieAndRedirect()
    {
        $redirectSpy = new SpyRedirectCallback();
        $cookieRepository = new MemoryCookieRepository();
        $cookieRepository->set(AccessToken::$cookieName, $this->createFakeToken());
        $cookieExistsBeforeInit = !empty($cookieRepository->get(AccessToken::$cookieName));

        $this->createFakeApp([
            'serverPath'            => '/signout',
            'cookieRepository'      => $cookieRepository,
            'redirectCallback'      => $redirectSpy,
        ])
            ->run()
            ->redirect();

        $this->assertTrue($cookieExistsBeforeInit);
        $this->assertTrue($cookieRepository->get(AccessToken::$cookieName) === '');
    }
}
