<?php

namespace ModMyPages\Test;

use Brain\Monkey;
use Firebase\JWT\JWT;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ModMyPages\Deprecated\App;
use ModMyPages\Deprecated\AppFactory;
use ModMyPages\Redirect\UseRedirectFactory;
use ModMyPages\Service\LoginUrlService\LoginUrlServiceFactory;
use ModMyPages\Service\TokenService\TokenServiceFactory;
use PHPUnit\Framework\TestCase;

class PluginTestCase extends TestCase
{
    static $redirects = [];

    use MockeryPHPUnitIntegration;

    /**
     * Setup which calls \WP_Mock setup
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
        // A few common passthrough
        // 1. WordPress i18n functions
        Monkey\Functions\when('__')->returnArg(1);
        Monkey\Functions\when('_e')->returnArg(1);
        Monkey\Functions\when('_n')->returnArg(1);
        Monkey\Functions\when('home_url')->alias(fn($v = '') => $this->homeUrl() . $v);
    }

    public function apiUrl(): string
    {
        return 'http://api-url.test';
    }

    public function homeUrl(): string
    {
        return 'http://home-url.test';
    }

    public function createExpiredFakeToken(): string
    {
        return $this->createFakeToken(true);
    }

    public function fakeJwtSecret(): string
    {
        return 'test-jwt-secret';
    }

    public function createFakeToken(bool $isExpired = false, bool $hasInvalidSecret = false): string
    {
        return JWT::encode(
            [
                'id' => '201111223333',
                'name' => 'Example Person',
                'exp' => $isExpired ? time() - 600 : time() + 1200,
            ],
            !$hasInvalidSecret ? $this->fakeJwtSecret() : time(),
            'HS256'
        );
    }

    public function createRedirectSpy(): \Closure
    {
        return function ($url = ''): array {
            static $redirects = [];
            if (!empty($url)) {
                $redirects[] = $url;
            }
            return $redirects;
        };
    }

    public function createMockMenu(string $menuName): array
    {
        return [];
    }

    public function createFakeApp(array $args = []): App
    {
        return AppFactory::createFromEnv(
            array_merge(
                [
                    'apiAuthSecret' => fn() => $args['mockJwtSecret'] ?? $this->fakeJwtSecret(),
                    'getMenuItemsByMenuName' => fn($menuName) => $this->createMockmenu($menuName),
                    'useRedirect' => UseRedirectFactory::createFromEnv([
                        'mockPath' => $args['mockPath'] ?? null,
                        'mockRedirectCallback' => $args['mockRedirectCallback'] ?? null,
                    ]),
                    'loginUrlService' => LoginUrlServiceFactory::createFromEnv([
                        'apiUrl' => $args['mockApiUrl'] ?? $this->apiUrl(),
                        'homeUrl' => $args['mockHomeUrl'] ?? $this->homeUrl(),
                    ]),
                    'tokenService' => TokenServiceFactory::createFromEnv([
                        'mockTokenResponse' =>
                            $args['mockTokenResponse'] ??
                            $this->createFakeToken(
                                $args['mockExpiredToken'] ?? false,
                                $args['mockInvalidToken'] ?? false
                            ),
                    ]),
                    'signOutRedirectUrl' => fn() => $this->homeUrl(),
                    'isProtectedPage' => fn(): bool => false,
                    'currentUrl' => fn(): string => $this->homeUrl(),
                ],
                $args
            )
        );
    }

    /**
     * Teardown which calls \WP_Mock tearDown
     *
     * @return void
     */
    public function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}
