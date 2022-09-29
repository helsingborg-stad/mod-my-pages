<?php

namespace ModMyPages\Test;

use Brain\Monkey\Functions;

class RegisterMenuTest extends PluginTestCase
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
