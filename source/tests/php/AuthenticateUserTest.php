<?php

namespace ModMyPages\Test;

use Brain\Monkey\Functions;
use Mockery;
use ModMyPages\Services\MockGetQueriedObjectId;
use ModMyPages\Redirects\SpyRedirectCallback;
use ModMyPages\Cookie\Constants\AccessToken;
use ModMyPages\Services\MockTokenService;

class AuthenticateUserTest extends \ModMyPages\Test\PluginTestCase
{
    public function testRemoveCookieAndRedirectToSuccessUrl()
    {
        $_GET['ts_session_id'] = 'fakeSession';

        $redirectSpy = new SpyRedirectCallback();
        $cookieRepository = new \ModMyPages\Cookie\MemoryCookieRepository();
        $cookieDoesNotExistBeforeInit = empty($cookieRepository->get(AccessToken::$cookieName));
        
        $this->createFakeApp([
            'serverPath'            => '/auth',
            'cookieRepository'      => $cookieRepository,
            'redirectCallback'      => $redirectSpy,
        ])->redirect();

        $this->assertTrue($cookieDoesNotExistBeforeInit);
        $this->assertTrue(!empty($cookieRepository->get(AccessToken::$cookieName)));
        $this->assertTrue(!empty($cookieRepository->get(AccessToken::$cookieName)));
        $this->assertTrue(count($redirectSpy::$redirects) === 1);
    }

    public function testDontSetCookieAndRedirectToErrorUrl()
    {
        $_GET['ts_session_id'] = 'fakeSession';

        $redirectSpy = new SpyRedirectCallback();
        $cookieRepository = new \ModMyPages\Cookie\MemoryCookieRepository();
        $cookieRepository->set(AccessToken::$cookieName, '');
        $cookieDoesNotExistBeforeInit = empty($cookieRepository->get(AccessToken::$cookieName));

        $this->createFakeApp([
            'serverPath'            => '/auth',
            'cookieRepository'      => $cookieRepository,
            'redirectCallback'      => $redirectSpy,
            'tokenService'          => new \ModMyPages\Services\MockTokenService('')
        ])->redirect();


        $cookiesDoesNotExistAfterInit = empty($cookieRepository->get(AccessToken::$cookieName));
        $redirectedOnce = count($redirectSpy::$redirects) === 1;
        $redirectedToErrorUrl = strpos($redirectSpy::$redirects[0], '/404') !== false;
        
        $this->assertTrue($cookieDoesNotExistBeforeInit);
        $this->assertTrue($cookiesDoesNotExistAfterInit);
        $this->assertTrue($redirectedOnce);
        $this->assertTrue($redirectedToErrorUrl);
    }
}

