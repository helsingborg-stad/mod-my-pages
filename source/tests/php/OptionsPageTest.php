<?php

namespace ModMyPages\Test;

use Mockery;
use Brain\Monkey\Functions;
use ModMyPages\Services\MockTokenService;
use ModMyPages\Cookie\Constants\AccessToken;
use ModMyPages\Cookie\MemoryCookieRepository;
use ModMyPages\Redirects\SpyRedirectCallback;

use ModMyPages\Services\MockGetQueriedObjectId;

class OptionsPageTest extends \ModMyPages\Test\PluginTestCase
{
    public function testRegisterOptionsPage()
    {
        Functions\expect('acf_add_options_sub_page')->once();

        $app = $this->createFakeApp()
            ->run()
            ->optionsPage();


        self::assertNotFalse(has_action('acf/init', 'ModMyPages\App->optionsPage()'));
    }
}

