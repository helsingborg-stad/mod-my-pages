<?php

namespace ModMyPages;

use ModMyPages\Redirects\UseRedirect;
use ModMyPages\Redirects\Handlers\ProtectedPage;
use ModMyPages\Redirects\Handlers\SignoutUser;
use ModMyPages\Redirects\Handlers\AuthenticateUser;
use ModMyPages\Types\Application;

class App extends Application
{
    public function run() : Application
    {
        add_action('template_redirect', array($this, 'redirect'), 5);
        add_filter('body_class', array($this, 'bodyClassNames'), 5);
        return $this;
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

    public function bodyClassNames(array $classNames)
    {
        return array_merge(
            $classNames,
            $this->isAuthenticated ? ['is-authenticated'] : []
        );
    }
}
