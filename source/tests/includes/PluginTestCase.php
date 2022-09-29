<?php

namespace ModMyPages\Test;

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;
use Firebase\JWT\JWT;

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
        return \ModMyPages\Helper\Type::cast(
            array_merge([], $overrides),
            '\ModMyPages\Types\ApplicationServices'
        );
    }

    public function createFakeApp(array $overrides = [])
    {
        return \ModMyPages\Helper\Type::cast(
            array_merge([
                'protectedPages' => [],
                'serverPath' => '/',
                'isAuthenticated' => true,
                'services' => $this->createFakeServices(array_merge(
                    [
                        'cookieRepository'      => new \ModMyPages\Cookie\MemoryCookieRepository(),
                        'redirectCallback'      => new \ModMyPages\Redirects\NullRedirectCallback(),
                        'getQueriedObjectId'    => new \ModMyPages\Services\MockGetQueriedObjectId(),
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
