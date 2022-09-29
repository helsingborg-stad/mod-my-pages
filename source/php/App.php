<?php

namespace ModMyPages;

use ModMyPages\Redirects\UseRedirect;
use ModMyPages\Redirects\Handlers\ProtectedPage;
use ModMyPages\Redirects\Handlers\SignoutUser;
use ModMyPages\Redirects\Handlers\AuthenticateUser;


class App extends Types\Application
{
    public function run()
    {
        add_action('template_redirect', array($this, 'redirect'), 5);
    }

    public function redirect()
    {
        new UseRedirect(
            [
                '*' => new ProtectedPage(
                    $this->protectedPages,
                    ($this->services->getQueriedObjectId)(),
                    !$this->isAuthenticated,
                ),
                '/signout' => new SignoutUser(
                    home_url(),
                    $this->services->cookieRepository
                ),
                '/auth' => new AuthenticateUser([
                    'successUrl'    => home_url('/my-pages'),
                    'errorUrl'      => home_url('/404'),
                    'tokenService'  => $this->services->tokenService,
                    'cookies'       => $this->services->cookieRepository,
                ]),
            ],
            $this->serverPath,
            $this->services->redirectCallback
        );
    }
}
