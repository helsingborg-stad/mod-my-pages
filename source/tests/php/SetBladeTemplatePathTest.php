<?php

namespace ModMyPages\Test;

use Mockery;
use Brain\Monkey\Functions;
use ModMyPages\Services\MockTokenService;
use ModMyPages\Cookie\Constants\AccessToken;
use ModMyPages\Cookie\MemoryCookieRepository;
use ModMyPages\Redirects\SpyRedirectCallback;

use ModMyPages\Services\MockGetQueriedObjectId;
class SetBladeTemplatePathTest extends \ModMyPages\Test\PluginTestCase
{
    public function testIsMainTheme()
    {
        Functions\when('is_child_theme')
            ->justReturn(false);

        $app = $this->createFakeApp()
            ->run();

        $examplePaths = [
            '/Users/hassan/server/multi/wp-content/plugins/modularity/views/',
            '/Users/hassan/server/multi/wp-content/themes/municipio/views/',
        ];

        $bladePaths = $app->setBladeTemplatePaths($examplePaths);
        
        $this->assertCount(count($examplePaths) + 1, $bladePaths);
        $this->assertContains(MOD_MY_PAGES_PATH . 'views/', $bladePaths);
    }

    public function testIsChildTheme()
    {
        Functions\when('is_child_theme')
            ->justReturn(true);

        $app = $this->createFakeApp()
            ->run();

        $examplePaths = [
            '/Users/hassan/server/multi/wp-content/plugins/modularity/views/',
            '/Users/hassan/server/multi/wp-content/themes/municipio/views/',
        ];

        $bladePaths = $app->setBladeTemplatePaths($examplePaths);
        
        $this->assertCount(count($examplePaths) + 1, $bladePaths);
        $this->assertContains(MOD_MY_PAGES_PATH . 'views/', $bladePaths);
    }
}

