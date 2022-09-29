<?php

namespace ModMyPages\Test;

use Brain\Monkey\Functions;
use Mockery;
use ModMyPages\Services\MockGetQueriedObjectId;
use ModMyPages\Redirects\SpyRedirectCallback;
use ModMyPages\Cookie\Constants\AccessToken;
use ModMyPages\Services\MockTokenService;
use ModMyPages\Cookie\MemoryCookieRepository;

class BodyClassNamesTest extends \ModMyPages\Test\PluginTestCase
{
    public function testUserIsAuthenticated()
    {
        $cookieRepository = new MemoryCookieRepository();
        $cookieRepository->set(AccessToken::$cookieName, $this->createFakeToken());
       
        $app = $this->createFakeApp(
            [
                'isAuthenticated'=> true,
                'cookieRepository' => $cookieRepository
            ])
            ->run();

        $classNames = ['home', 'example-css-class'];
        $bodyClassNames = $app->bodyClassNames($classNames);
        
        $this->assertCount(count($classNames) + 1, $bodyClassNames);
        $this->assertContains('is-authenticated', $bodyClassNames);
    }

    public function testUserIsNotAuthenticated()
    {
        $cookieRepository = new MemoryCookieRepository();
        $cookieRepository->set(AccessToken::$cookieName, '');
       
        $app = $this->createFakeApp(
            [
                'isAuthenticated'=> false,
                'cookieRepository' => $cookieRepository
            ])
            ->run();

        $classNames = ['home', 'example-css-class'];
        $bodyClassNames = $app->bodyClassNames($classNames);

        $this->assertEquals($classNames, $bodyClassNames);
    }
}

