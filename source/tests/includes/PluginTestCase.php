<?php

namespace ModMyPages\Test;

use Brain\Monkey;
use Firebase\JWT\JWT;
use ModMyPages\Helper\Type;
use PHPUnit\Framework\TestCase;
use ModMyPages\Services\Mock\MockTokenService;
use ModMyPages\Services\Mock\NullRedirectCallback;
use ModMyPages\Services\Mock\MemoryCookieRepository;
use ModMyPages\Services\Mock\MockGetQueriedObjectId;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class PluginTestCase extends \PHPUnit\Framework\TestCase
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
            ->alias(fn ($v = '') => 'http://example.test' . $v);
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

    public function createFakeServices(array $overrides = [])
    {
        return Type::cast(
            array_merge([], $overrides),
            '\ModMyPages\Types\ApplicationServices'
        );
    }

    public function createFakeApp(array $overrides = [])
    {
        return Type::cast(
            array_merge([
                'protectedPages' => [],
                'serverPath' => '/',
                'isAuthenticated' => true,
                'services' => $this->createFakeServices(array_merge(
                    [
                        'cookieRepository'      => new MemoryCookieRepository(),
                        'redirectCallback'      => new NullRedirectCallback(),
                        'getQueriedObjectId'    => new MockGetQueriedObjectId(),
                        'tokenService'          => new MockTokenService($this->createFakeToken())
                    ],
                    $overrides
                ))
            ], $overrides),
            '\ModMyPages\App'
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
