<?php

namespace ModMyPages;

use ModMyPages\Redirects\UseRedirect;
use ModMyPages\Redirects\Handlers\ProtectedPage;
use ModMyPages\Redirects\Handlers\Signout;
use ModMyPages\Redirects\Handlers\AuthenticateUser;


class App extends Types\Application
{
    public function __construct()
    {
        $this->hooks();
    }

    public function hooks()
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
                '/signout' => new Signout(
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
