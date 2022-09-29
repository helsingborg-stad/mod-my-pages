<?php

namespace ModMyPages\Test;

use Brain\Monkey\Functions;
use Mockery;
use ModMyPages\Services\MockGetQueriedObjectId;
use ModMyPages\Redirects\SpyRedirectCallback;

class ProtectedPageTest extends \ModMyPages\Test\PluginTestCase
{
    public function testDenyUnauthenticated()
    {
        $redirectSpy = new SpyRedirectCallback();
        $this->createFakeApp([
            'protectedPages'        => [1336, 1337],
            'getQueriedObjectId'    => new MockGetQueriedObjectId(1337),
            'isAuthenticated'       => false,
            'redirectCallback'      => $redirectSpy,
        ])->redirect();
        
        $this->assertTrue(count($redirectSpy::$redirects) === 1 && !empty($redirectSpy::$redirects[0]));
    }
    
    public function testDenyExpiredToken()
    {
        $redirectSpy = new SpyRedirectCallback();
        $this->createFakeApp([
            'protectedPages'        => [1336, 1337],
            'getQueriedObjectId'    => new MockGetQueriedObjectId(1337),
            'isAuthenticated'       => false,
            'redirectCallback'      => $redirectSpy,
        ])->redirect();
        
        $this->assertTrue(count($redirectSpy::$redirects) === 1 && !empty($redirectSpy::$redirects[0]));
    }

    public function testAllowNotProtectedPages()
    {
        $redirectSpy = new SpyRedirectCallback();
        $this->createFakeApp([
            'protectedPages'        => [1336, 1337],
            'getQueriedObjectId'    => new MockGetQueriedObjectId(1),
            'isAuthenticated'       => false,
            'redirectCallback'      => $redirectSpy,
        ])->redirect();
        
        $this->assertTrue(count($redirectSpy::$redirects) === 0);
    }

    public function testAllowAuthenticated()
    {
        $redirectSpy = new SpyRedirectCallback();
        $this->createFakeApp([
            'protectedPages'        => [1336, 1337],
            'getQueriedObjectId'    => new MockGetQueriedObjectId(1337),
            'isAuthenticated'       => true,
            'redirectCallback'      => $redirectSpy,
        ])->redirect();
        
        $this->assertTrue(count($redirectSpy::$redirects) === 0);
    }
}

