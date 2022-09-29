<?php

namespace ModMyPages\Test;

use Brain\Monkey\Functions;
use Mockery;
use ModMyPages\Services\MockGetQueriedObjectId;
use ModMyPages\Redirects\SpyRedirectCallback;
use ModMyPages\Cookie\Constants\AccessToken;

class SignoutTest extends \ModMyPages\Test\PluginTestCase
{
    public function testRemoveCookieAndRedirect()
    {
        $redirectSpy = new SpyRedirectCallback();
        $cookieRepository = new \ModMyPages\Cookie\MemoryCookieRepository();
        $cookieRepository->set(AccessToken::$cookieName, $this->createFakeToken());
        $cookieExistsBeforeInit = !empty($cookieRepository->get(AccessToken::$cookieName));
        
        $this->createFakeApp([
            'serverPath'            => '/signout',
            'cookieRepository'      => $cookieRepository,
            'redirectCallback'      => $redirectSpy,
        ])->redirect();

        $this->assertTrue($cookieExistsBeforeInit);
        $this->assertTrue($cookieRepository->get(AccessToken::$cookieName) === '');
    }
}

