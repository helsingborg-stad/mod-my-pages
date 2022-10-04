<?php

namespace ModMyPages;

use ModMyPages\Redirects\Handlers\AuthenticateUser;
use ModMyPages\Redirects\Handlers\ProtectedPage;
use ModMyPages\Redirects\Handlers\SignoutUser;
use ModMyPages\Redirects\UseRedirect;
use ModMyPages\Token\AccessToken;
use ModMyPages\Types\Application;

class App extends Application
{
    public function run(): Application
    {
        add_action('template_redirect', array($this, 'redirect'), 5);
        add_filter('body_class', array($this, 'bodyClassNames'), 5);
        add_filter('Municipio/blade/view_paths', array($this, 'setBladeTemplatePaths'), 5);
        add_action('acf/init', array($this, 'optionsPage'), 5);
        add_action('init', array($this, 'registerMenus'), 5, 2);

        (function (bool $isAuthenticated) {
            $controller = $isAuthenticated ? 'dropDownMenuController' : 'loginButtonController';
            add_filter('Municipio/viewData', array($this, $controller));
        })($this->isAuthenticated);

        add_action('plugins_loaded', array($this, 'registerModules'));


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

    public function bodyClassNames(array $classNames): array
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

    public function profile(): array
    {
        $jwt = $this->services->cookieRepository->get(AccessToken::$cookieName);
        $decoded = AccessToken::decode($jwt) ?? [];

        return [
            'name' => $decoded['payload']['name'] ?? ''
        ];
    }

    public function loginButtonController(array $data): array
    {
        $data['myPagesMenu'] = [
            'login'     => [
                'text'      => __('Login', MOD_MY_PAGES_TEXT_DOMAIN),
                'url'       => ($this->services->loginUrlService)()
            ],
        ];

        return $data;
    }

    public function dropDownMenuController(array $data): array
    {
        $dropdownItems = array_map(
            fn ($p) => [
                'text' => $p->title,
                'link' => $p->url,
                'attributeList' => [
                    'title' => $p->attr_title
                ],
                'classList' => $p->classes,
            ],
            wp_get_nav_menu_items(get_nav_menu_locations()['my-pages-menu'] ?? 0) ?? []
        );

        $data['myPagesMenu'] = [
            'dropdown'  => [
                'text'      => $this->profile()['name'],
                'items'     => $dropdownItems
            ],
        ];

        return $data;
    }

    public function registerModules()
    {
        foreach (['mod-my-account' => 'MyAccount'] as $slug => $name) {
            if (function_exists('modularity_register_module')) {
                modularity_register_module(
                    MOD_MY_PAGES_MODULE_PATH . "/" . $name,
                    $name
                );
            }

            add_filter(
                '/Modularity/externalViewPath',
                fn (array $paths) => array_merge(
                    $paths,
                    [
                        $slug => MOD_MY_PAGES_MODULE_PATH . "/" . $name . "/views"
                    ]
                ),
                1,
                3
            );
        }
    }
}
