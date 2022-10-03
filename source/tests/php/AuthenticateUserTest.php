<?php

namespace ModMyPages\Test;

use ModMyPages\Services\Mock\MemoryCookieRepository;
use ModMyPages\Services\Mock\MockTokenService;
use ModMyPages\Services\Mock\SpyRedirectCallback;
use ModMyPages\Token\AccessToken;

class AuthenticateUserTest extends PluginTestCase
{
    public function testRemoveCookieAndRedirectToSuccessUrl()
    {
        $_GET['ts_session_id'] = 'fakeSession';

        $redirectSpy = new SpyRedirectCallback();
        $cookieRepository = new MemoryCookieRepository();
        $cookieDoesNotExistBeforeInit = empty($cookieRepository->get(AccessToken::$cookieName));

        $this->createFakeApp([
            'serverPath'            => '/auth',
            'cookieRepository'      => $cookieRepository,
            'redirectCallback'      => $redirectSpy,
        ])
            ->run()
            ->redirect();

        $this->assertTrue($cookieDoesNotExistBeforeInit);
        $this->assertTrue(!empty($cookieRepository->get(AccessToken::$cookieName)));
        $this->assertTrue(count($redirectSpy::$redirects) === 1);
    }

    public function testDontSetCookieAndRedirectToErrorUrl()
    {
        $_GET['ts_session_id'] = 'fakeSession';

        $redirectSpy = new SpyRedirectCallback();
        $cookieRepository = new MemoryCookieRepository();
        $cookieRepository->set(AccessToken::$cookieName, '');
        $cookieDoesNotExistBeforeInit = empty($cookieRepository->get(AccessToken::$cookieName));

        $this->createFakeApp([
            'serverPath'            => '/auth',
            'cookieRepository'      => $cookieRepository,
            'redirectCallback'      => $redirectSpy,
            'tokenService'          => new MockTokenService('')
        ])
            ->run()
            ->redirect();


        $cookiesDoesNotExistAfterInit = empty($cookieRepository->get(AccessToken::$cookieName));
        $redirectedOnce = count($redirectSpy::$redirects) === 1;
        $redirectedToErrorUrl = strpos($redirectSpy::$redirects[0] ?? '', '/404') !== false;

        $this->assertTrue($cookieDoesNotExistBeforeInit);
        $this->assertTrue($cookiesDoesNotExistAfterInit);
        $this->assertTrue($redirectedOnce);
        $this->assertTrue($redirectedToErrorUrl);
    }
}
