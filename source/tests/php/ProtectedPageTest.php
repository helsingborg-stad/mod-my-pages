<?php

namespace ModMyPages\Test;

use ModMyPages\Services\Mock\MockGetQueriedObjectId;
use ModMyPages\Services\Mock\SpyRedirectCallback;

class ProtectedPageTest extends PluginTestCase
{
    public function testDenyUnauthenticated()
    {
        $redirectSpy = new SpyRedirectCallback();
        $this->createFakeApp([
            'protectedPages'        => [1336, 1337],
            'getQueriedObjectId'    => new MockGetQueriedObjectId(1337),
            'isAuthenticated'       => false,
            'redirectCallback'      => $redirectSpy,
        ])
            ->run()
            ->redirect();

        $this->assertTrue(count($redirectSpy::$redirects) === 1 && !empty($redirectSpy::$redirects[0]));
    }

    public function testDenyExpiredToken()
    {
        // TODO: Implement Token Validation
        $redirectSpy = new SpyRedirectCallback();
        $this->createFakeApp([
            'protectedPages'        => [1336, 1337],
            'getQueriedObjectId'    => new MockGetQueriedObjectId(1337),
            'isAuthenticated'       => false,
            'redirectCallback'      => $redirectSpy,
        ])
            ->run()
            ->redirect();

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
        ])
            ->run()
            ->redirect();

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
        ])
            ->run()
            ->redirect();

        $this->assertTrue(count($redirectSpy::$redirects) === 0);
    }
}
