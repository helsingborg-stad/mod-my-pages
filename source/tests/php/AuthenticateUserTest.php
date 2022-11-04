<?php

namespace ModMyPages\Test;

use ModMyPages\Service\CookieRepository\CookieRepositoryFactory;
use ModMyPages\Services\Mock\MockTokenService;
use ModMyPages\Token\AccessToken;

class AuthenticateUserTest extends PluginTestCase
{
    public function testShouldRedirect()
    {
        $_GET['ts_session_id'] = 'fakeSession';

        $redirectSpy = $this->createRedirectSpy();

        $this->createFakeApp([
            'mockPath'                  => '/auth',
            'mockRedirectCallback'      => $redirectSpy,
        ])
            ->run()
            ->redirect();

        $this->assertCount(1, $redirectSpy());
    }

    public function testShouldSetCookie()
    {
        $_GET['ts_session_id'] = 'fakeSession';

        $cookieRepository = CookieRepositoryFactory::createFromEnv();
        $cookieRepository->set(AccessToken::$cookieName, '');

        $this->createFakeApp([
            'mockPath'                  => '/auth',
            'cookieRepository'          => $cookieRepository,
        ])
            ->run()
            ->redirect();

        $this->assertNotEmpty($cookieRepository->get(AccessToken::$cookieName));
    }

    public function testShouldNotSetCookieWhenJwtSignatureIsInvalid()
    {
        $_GET['ts_session_id'] = 'fakeSession';

        $cookieRepository = CookieRepositoryFactory::createFromEnv();
        $cookieRepository->set(AccessToken::$cookieName, '');

        $this->createFakeApp([
            'mockPath'                  => '/auth',
            'cookieRepository'          => $cookieRepository,
            'mockInvalidToken'          => true
        ])
            ->run()
            ->redirect();

        $this->assertEquals('', $cookieRepository->get(AccessToken::$cookieName));
    }

    public function testShouldNotSetCookieWhenJwtIsExpired()
    {
        $_GET['ts_session_id'] = 'fakeSession';

        $cookieRepository = CookieRepositoryFactory::createFromEnv();
        $cookieRepository->set(AccessToken::$cookieName, '');

        $this->createFakeApp([
            'mockPath'                  => '/auth',
            'cookieRepository'          => $cookieRepository,
            'mockExpiredToken'          => true
        ])
            ->run()
            ->redirect();

        $this->assertEquals('', $cookieRepository->get(AccessToken::$cookieName));
    }

    public function testShouldNotSetCookieWhenTsSessionIdIsEmpty()
    {
        $cookieRepository = CookieRepositoryFactory::createFromEnv();
        $cookieRepository->set(AccessToken::$cookieName, '');

        $this->createFakeApp([
            'mockPath'                  => '/auth',
            'cookieRepository'          => $cookieRepository,
        ])
            ->run()
            ->redirect();

        $this->assertEquals('', $cookieRepository->get(AccessToken::$cookieName));
    }
}
