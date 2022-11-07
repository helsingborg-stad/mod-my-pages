<?php

namespace ModMyPages\Test;

class UseRedirectTest extends PluginTestCase
{
    public function testShouldNotRedirect()
    {
        $redirectSpy = $this->createRedirectSpy();

        $this->createFakeApp([
            'mockPath'                  => '/',
            'mockRedirectCallback'      => $redirectSpy,
        ])
            ->run()
            ->redirect();

        $this->assertCount(0, $redirectSpy());
    }
}
