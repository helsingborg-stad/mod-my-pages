<?php

namespace ModMyPages\Test;

use Brain\Monkey\Functions;

class SetBladeTemplatePathTest extends PluginTestCase
{
    public function testIsMainTheme(): void
    {
        Functions\when('is_child_theme')->justReturn(false);

        $app = $this->createFakeApp()->run();

        $examplePaths = [
            '/Users/hassan/server/multi/wp-content/plugins/modularity/views/',
            '/Users/hassan/server/multi/wp-content/themes/municipio/views/',
        ];

        $bladePaths = $app->setBladeTemplatePaths($examplePaths);

        $this->assertCount(count($examplePaths) + 1, $bladePaths);
        $this->assertContains(MOD_MY_PAGES_PATH . 'views/', $bladePaths);
    }

    public function testIsChildTheme(): void
    {
        Functions\when('is_child_theme')->justReturn(true);

        $app = $this->createFakeApp()->run();

        $examplePaths = [
            '/Users/hassan/server/multi/wp-content/plugins/modularity/views/',
            '/Users/hassan/server/multi/wp-content/themes/municipio/views/',
        ];

        $bladePaths = $app->setBladeTemplatePaths($examplePaths);

        $this->assertCount(count($examplePaths) + 1, $bladePaths);
        $this->assertContains(MOD_MY_PAGES_PATH . 'views/', $bladePaths);
    }
}
