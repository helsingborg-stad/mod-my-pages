<?php
namespace ModMyPages;

use ModMyPages\App;
use Brain\Monkey;
use Brain\Monkey\Functions;
use Mockery;

class ProtectedPageTest extends \PluginTestCase\PluginTestCase
{
    public function testDenyUnauthenticated()
    {
        Monkey\Functions\when('ModMyPages\Session\Profile\isAuthenticated')
            ->justReturn(false);
        Monkey\Functions\when('ModMyPages\get_posts')
            ->justReturn([13, 14]);
        Monkey\Functions\when('ModMyPages\get_queried_object_id')
            ->justReturn(13);

        Functions\expect('wp_redirect')
            ->once();

        (new App())
            ->redirect();
    }

    public function testAllowAuthenticated()
    {
        Monkey\Functions\when('ModMyPages\get_posts')
            ->justReturn([13, 14]);
        Monkey\Functions\when('ModMyPages\get_queried_object_id')
            ->justReturn(13);

        Functions\expect('wp_redirect')
            ->never();

        $this->setFakeToken();
        (new App())
            ->redirect();
    }
}
