<?php
namespace ModMyPages;

use ModMyPages\App;

use Brain\Monkey\Functions;
use Mockery;

class AppTest extends \PluginTestCase\PluginTestCase
{
    public function testRegisterOptionsPage()
    {
        Functions\expect('acf_add_options_sub_page')->once();

        (new App())
            ->optionsPage();

        self::assertNotFalse(has_action('acf/init', 'ModMyPages\App->optionsPage()'));
    }

    public function testRegisterMenu()
    {
        Functions\expect('register_nav_menu')->once();

        (new App())
            ->registerMyPagesMenu();

        self::assertNotFalse(has_action('init', 'ModMyPages\App->registerMyPagesMenu()'));
    }

    // public function testBladeTemplatePathsHook()
    // {
    //     new App();
    //     self::assertNotFalse(has_action('Municipio/blade/view_paths', 'ModMyPages\App->addSearchableBladeTemplatePaths()'));
    // }


    
    // public function testAddHooks()
    // {
    //     new App();
    
    //     self::assertNotFalse(has_action('admin_enqueue_scripts', 'ModMyPages\App->enqueueStyles()'));
    //     self::assertNotFalse(has_action('admin_enqueue_scripts', 'ModMyPages\App->enqueueScripts()'));
    // }

    // public function testEnqueueStyles()
    // {
    //     Functions\expect('wp_register_style')->once();
    //     Functions\expect('wp_enqueue_style')->once()->with('mod-my-pages-css');

    //     $app = new App();

    //     $app->enqueueStyles();
    // }

    // public function testEnqueueScripts()
    // {
    //     Functions\expect('wp_register_script')->once();
    //     Functions\expect('wp_enqueue_script')->once()->with('mod-my-pages-js');

    //     $app = new App();

    //     $app->enqueueScripts();
    // }
}
