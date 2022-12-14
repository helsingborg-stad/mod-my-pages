<?php

namespace ModMyPages\Test;

use Brain\Monkey\Functions;

class OptionsPageTest extends PluginTestCase
{
    public function testRegisterOptionsPage()
    {
        Functions\expect('acf_add_options_sub_page')->once();

        $this->createFakeApp()
            ->run()
            ->registerOptionsPage();


        self::assertNotFalse(has_action('acf/init', 'ModMyPages\App->registerOptionsPage()'));
    }
}
