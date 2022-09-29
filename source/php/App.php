<?php

namespace ModMyPages;

use ModMyPages\Types\Application;
use ModMyPages\Redirects\UseRedirect;
use ModMyPages\Redirects\Handlers\SignoutUser;
use ModMyPages\Redirects\Handlers\ProtectedPage;
use ModMyPages\Redirects\Handlers\AuthenticateUser;

class App extends Application
{
    public function run(): Application
    {
        add_action('template_redirect', array($this, 'redirect'), 5);
        add_filter('body_class', array($this, 'bodyClassNames'), 5);
        add_filter('Municipio/blade/view_paths', array($this, 'setBladeTemplatePaths'), 5);
        add_action('acf/init', array($this, 'optionsPage'), 5);
        add_action('init', array($this, 'registerMenus'), 5, 2);

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

    public function setBladeTemplatePaths(array $array): array
    {
        is_child_theme()
        ? array_splice($array, 2, 0, array(MOD_MY_PAGES_PATH . 'views/'))
        : array_unshift($array, MOD_MY_PAGES_PATH . 'views/');

        return $array;
    }

    public function optionsPage()
    {
        new Admin\OptionsPage();
    }

    public function registerMenus()
    {
        register_nav_menu('my-pages-menu', __('My Pages Menu', MOD_MY_PAGES_TEXT_DOMAIN));
    }
}
