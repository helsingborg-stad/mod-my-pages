<?php

namespace ModMyPages\Test;

use Brain\Monkey;
use Firebase\JWT\JWT;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ModMyPages\App;
use ModMyPages\AppFactory;
use ModMyPages\Services\LoginUrlServiceFactory;
use ModMyPages\Services\Mock\MemoryCookieRepository;
use ModMyPages\Services\Mock\MockGetQueriedObjectId;
use ModMyPages\Services\Mock\MockTokenService;
use ModMyPages\Services\Mock\NullRedirectCallback;
use ModMyPages\Types\ApplicationServices;
use PHPUnit\Framework\TestCase;

class PluginTestCase extends TestCase
{
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
        Monkey\Functions\when('__')
            ->returnArg(1);
        Monkey\Functions\when('_e')
            ->returnArg(1);
        Monkey\Functions\when('_n')
            ->returnArg(1);
        Monkey\Functions\when('home_url')
            ->alias(fn ($v = '') => $this->homeUrl() . $v);
    }

    public function apiUrl()
    {
        return 'http://localhost:3000';
    }

    public function homeUrl()
    {
        return 'http://example.test';
    }

    public function createExpiredFakeToken(): string
    {
        return $this->createFakeToken(true);
    }

    public function createFakeToken(bool $isExpired = false): string
    {
        return JWT::encode(
            [
                'id' => '201111223333',
                'name' => 'Example Person',
                'exp' => $isExpired ? time() - 600 : time() + 1200
            ],
            'key',
            'HS256'
        );
    }

    public function createFakeApp(array $args = []): App
    {
        return AppFactory::create([
            'isAuthenticated'   => isset($args['isAuthenticated']) ? $args['isAuthenticated'] : false,
            'serverPath'        => $args['serverPath'] ?? '/',
            'protectedPages'    => $args['protectedPages'] ?? [],
            'cookieRepository'      => $args['cookieRepository'] ?? new MemoryCookieRepository(),
            'redirectCallback'      => $args['redirectCallback'] ?? new NullRedirectCallback(),
            'getQueriedObjectId'    => $args['getQueriedObjectId'] ?? new MockGetQueriedObjectId(),
            'tokenService'          => $args['tokenService'] ?? new MockTokenService($this->createFakeToken()),
            'loginUrlService'       => $args['loginUrlService'] ?? LoginUrlServiceFactory::create($this->apiUrl(), $this->homeUrl(), $this->homeUrl() . '/my-pages'),
            'pageCacheBust'         => fn () => null
        ]);
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
