<?php

namespace ModMyPages;

use ModMyPages\Redirects\UseRedirect;
use ModMyPages\Redirects\Handlers\ProtectedPage;


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
                // '/auth' => new Authentication([
                //     'successUrl'    => home_url('/my-pages'),
                //     'errorUrl'      => home_url('/404'),
                //     'authService'   => $this->services->tokenService,
                //     'cookieService' => $this->services->cookieService,
                // ]),
                // '/signout' => new SignOut([
                //     'successUrl' => home_url(),
                //     'errorUrl' => home_url('/404'),
                //     'accessToken'   => $this->services->cookieService,
                // ]),
            ],
            $this->serverPath,
            $this->services->redirectCallback
        );
    }
}
