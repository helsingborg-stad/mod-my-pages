<?php

namespace ModMyPages;

use Firebase\JWT\Key;
use ModMyPages\Helper\CacheBust;
use ModMyPages\Redirect\Handlers\AuthenticateUser;
use ModMyPages\Redirect\Handlers\SignoutUser;
use ModMyPages\Token\AccessToken;
use ModMyPages\Types\Application;
use ModMyPages\UI\DropdownMenu;

class App extends Application
{
    public function run(): Application
    {
        add_action('template_redirect', array($this, 'redirect'), 5);
        add_action('init', array($this, 'registerMenus'), 5, 2);
        add_action('acf/init', array($this, 'registerOptionsPage'), 5);
        add_action('plugins_loaded', array($this, 'registerModules'));
        add_action('wp_enqueue_scripts', array($this, 'scripts'));
        add_action('wp_enqueue_scripts', array($this, 'styles'));
        add_action('rest_api_init', array($this, 'registerRestRoutes'));
        add_filter('Municipio/blade/view_paths', array($this, 'setBladeTemplatePaths'), 5);
        add_filter('Municipio/viewData', array($this, 'dropdownMenuController'));
        add_filter('ModMyPages/UI/DropdownMenu::items', array($this, 'disableInstantPageOnMenuItems'), 10, 1);
        return $this;
    }

    public function redirect()
    {
        $this->useRedirect
            ->use('/signout', SignoutUser::create([
                'redirectUrl' => home_url(),
                'onRedirect' => function () {
                    $this->cookies->set(AccessToken::$cookieName, '');
                },
            ]))
            ->use('/auth', AuthenticateUser::create([
                'successUrl'    => home_url('/my-pages'),
                'errorUrl'      => home_url('/404'),
                'tokenService'  => $this->tokenService,
                'jwtSecretKey'  => new Key($this->apiAuthSecret, 'HS256'),
                'onSuccess'     => function ($jwt) {
                    $this->cookies->set(AccessToken::$cookieName, $jwt);
                },
            ]))
            ->redirect();
    }

    public function registerRestRoutes()
    {
        register_rest_route('mod-my-pages/v1', '/access-token', array(
            'methods' => 'POST',
            'callback' => fn () => [
                'token' => $this->cookies->get(AccessToken::$cookieName) ?? ''
            ],
        ));
    }

    public function dropdownMenuController(array $data): array
    {
        $createMyPagesMenu = fn () => [
            'dropdown'  => [
                'text'      => __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN),
                'items'     => DropdownMenu::create(
                    ($this->getMenuItemsByMenuName)('my-pages-menu'),
                    fn () => ($this->loginUrl)()
                ),
            ],
        ];

        $data['myPagesMenu'] = $createMyPagesMenu();

        return $data;
    }

    public function registerMenus()
    {
        register_nav_menu('my-pages-menu', __('My Pages Menu', MOD_MY_PAGES_TEXT_DOMAIN));
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

    public function registerOptionsPage()
    {
        new Admin\OptionsPage();
    }

    public function scripts()
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

    public function styles()
    {
        wp_enqueue_style(
            'mod-my-pages-styles',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('css/mod-my-pages.css'),
            null
        );
    }

    public function setBladeTemplatePaths(array $array): array
    {
        is_child_theme()
            ? array_splice($array, 2, 0, array(MOD_MY_PAGES_PATH . 'views/'))
            : array_unshift($array, MOD_MY_PAGES_PATH . 'views/');

        return $array;
    }

    public function disableInstantPageOnMenuItems(array $items)
    {
        return array_map(
            fn ($item) => array_merge($item, [
                'linkAttributeList' => array_merge(
                    $item['linkAttributeList'] ?? [],
                    ['data-no-instant' => '']
                )
            ]),
            $items
        );
    }
}
