<?php

namespace ModMyPages;

use ModMyPages\Helper\CacheBust;
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
        add_filter('Municipio/blade/view_paths', array($this, 'setBladeTemplatePaths'), 5);
        add_action('acf/init', array($this, 'optionsPage'), 5);
        add_action('init', array($this, 'registerMenus'), 5, 2);
        add_filter('Municipio/viewData', array($this, 'dropDownMenuController'));
        add_action('plugins_loaded', array($this, 'registerModules'));
        add_action('wp_enqueue_scripts', array($this, 'script'));
        add_action('wp_enqueue_scripts', array($this, 'style'));
        add_action('rest_api_init', function () {
            register_rest_route('mod-my-pages/v1', '/access-token', array(
                'methods' => 'GET',
                'callback' => fn () => ['token' => $_COOKIE[AccessToken::$cookieName] ?? ''],
            ));
        });
        add_filter(
            'ModMyPages/App/myPagesMenuItems',
            fn ($items) => array_map(
                function ($item) {
                    $item->classes = array_merge(
                        array_filter(
                            $item->classes,
                            fn ($c) => !empty($c)
                        ),
                        ['show-authenticated']
                    );
                    return $item;
                },
                $items
            ),
            10,
            1
        );

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
                    'cookieDomain'  => home_url(),
                    'jwtSecretKey'  => $this->apiAuthSecret,
                ]),
            ],
            $this->serverPath,
            $this->services->redirectCallback
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

    public function loginButton(): array
    {
        return [
            (object) [
                'title'         => __('Login', MOD_MY_PAGES_TEXT_DOMAIN),
                'url'           => ($this->services->loginUrlService)(),
                'attr_title'    => __('Login', MOD_MY_PAGES_TEXT_DOMAIN),
                'classes'       => ['hide-authenticated']
            ]
        ];
    }

    public function dropDownMenuController(array $data): array
    {
        $items = array_merge(
            $this->loginButton(),
            apply_filters(
                'ModMyPages/App/myPagesMenuItems',
                wp_get_nav_menu_items(get_nav_menu_locations()['my-pages-menu'] ?? 0) ?? []
            )
        );

        $dropdownItems = array_map(
            fn ($p) => [
                'text' => $p->title,
                'link' => $p->url,
                'attributeList' => [
                    'title' => $p->attr_title
                ],
                'classList' => $p->classes,
            ],
            $items
        );

        $data['myPagesMenu'] = [
            'dropdown'  => [
                'text'      => __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN),
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

    public function script()
    {
        wp_enqueue_script(
            'gdi-host',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('js/gdi-host.js'),
            null
        );

        wp_enqueue_script(
            'mod-my-pages-js',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('js/mod-my-pages.js'),
            null
        );

        wp_localize_script('gdi-host', 'modMyPages', ['restUrl' => get_rest_url()]);
    }

    public function style()
    {
        wp_enqueue_style(
            'mod-my-pages-styles',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('css/mod-my-pages.css'),
            null
        );
    }
}
