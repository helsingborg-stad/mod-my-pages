<?php

namespace ModMyPages\Test;

use Mockery;
use Brain\Monkey\Functions;
use ModMyPages\Services\MockTokenService;
use ModMyPages\Cookie\Constants\AccessToken;
use ModMyPages\Cookie\MemoryCookieRepository;
use ModMyPages\Redirects\SpyRedirectCallback;

use ModMyPages\Services\MockGetQueriedObjectId;

class RegisterMenuTest extends \ModMyPages\Test\PluginTestCase
{
    public function testRegisterOptionsPage()
    {
        Functions\expect('register_nav_menu')->once();

        $app = $this->createFakeApp()
            ->run()
            ->registerMenus();

        self::assertNotFalse(has_action('init', 'ModMyPages\App->registerMenus()'));
    }
}

