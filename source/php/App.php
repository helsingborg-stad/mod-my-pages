<?php

namespace ModMyPages;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use ModMyPages\Helper\Blade;
use ModMyPages\Helper\CacheBust;
use ModMyPages\Notice\NoticeCodes;
use ModMyPages\PostTypes\MyPages;
use ModMyPages\Redirect\Handlers\AuthenticateUser;
use ModMyPages\Redirect\Handlers\SignOutUser;
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
        add_action('wp_enqueue_scripts', array($this, 'scripts'));
        add_action('wp_enqueue_scripts', array($this, 'styles'));
        add_action('rest_api_init', array($this, 'registerRestRoutes'));
        add_filter('Municipio/blade/view_paths', array($this, 'setBladeTemplatePaths'), 5);
        add_filter('Municipio/viewData', array($this, 'dropdownMenuController'));
        add_filter('ModMyPages/UI/DropdownMenu::items', array($this, 'disableInstantPageOnMenuItems'), 10, 1);
        add_filter('wp_footer', array($this, 'notice'), 10, 1);
        add_filter('body_class', array($this, 'protectPage'), 20, 1);
        add_filter('body_class', array($this, 'pendingAuthenticationClassName'), 20, 1);
        add_filter('Municipio/viewData', array($this, 'protectedPagePromptController'));
        add_action('init', array(new MyPages(), 'registerPostType'), 9);

        return $this;
    }

    public function redirect()
    {
        $this->useRedirect
            ->use('/auth', AuthenticateUser::create([
                'successUrl'    => home_url('/my-pages'),
                'errorUrl'      => home_url('/404'),
                'tokenService'  => $this->tokenService,
                'jwtSecretKey'  => new Key(($this->apiAuthSecret)(), 'HS256'),
                'onSuccess'     => function ($jwt) {
                    $this->cookies->set(AccessToken::$cookieName, $jwt);
                },
            ]))
            ->use('/signout', SignOutUser::create([
                'redirectUrl' => ($this->signOutRedirectUrl)(),
                'onRedirect' => function () {
                    $token = $this->cookies->get(AccessToken::$cookieName);
                    if (!empty($token)) {
                        ($this->signOutService)($token);
                        $this->cookies->set(AccessToken::$cookieName, '');
                    }
                },
            ]))
            ->redirect();
    }

    public function registerRestRoutes()
    {
        register_rest_route('mod-my-pages/v1', '/access-token', array(
            'methods' => 'POST',
            'callback' => function () {
                $tryDecodeToken = function (string $jwt) {
                    $decoded = null;
                    try {
                        $decoded = JWT::decode(
                            $jwt,
                            new Key(($this->apiAuthSecret)(), 'HS256')
                        );
                    } catch (Exception $e) {
                        $this->cookies->set(AccessToken::$cookieName, '');
                    }

                    return $decoded;
                };

                $token = $this->cookies->get(AccessToken::$cookieName);

                return [
                    'token' => $tryDecodeToken($token) ? $token : '',
                    'expires' => $tryDecodeToken($token)->exp ?? 0,
                    'decoded' => $tryDecodeToken($token)
                ];
            },
        ));
    }

    public function notice()
    {
        if (
            !empty($_GET['notice'])
            && $_GET['notice'] === NoticeCodes::INACTIVE_SIGNOUT
        ) {
            echo Blade::render('source/php/Notice/modal-notice.blade.php', [
                'labels' => [
                    'modalTitle' => __('You have been automatically logged out.', MOD_MY_PAGES_TEXT_DOMAIN),
                    'buttonText' => __('Close', MOD_MY_PAGES_TEXT_DOMAIN),
                ]
            ]);
        }
    }

    public function dropdownMenuController(array $data): array
    {
        $menuPositions = [
            'enabled' => 'header',
            'disabled' => 'none',
            'protected-pages' => ($this->getPostType)() === MyPages::$postType ? 'helper' : 'none'
        ];

        $createMyPagesMenu = fn () => [
            'dropdown'  => [
                'text'      => __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN),
                'items'     => DropdownMenu::create(
                    ($this->menuService)('my-pages-menu'),
                    fn () => ($this->loginUrl)()
                ),
            ],
            'position' => $menuPositions[($this->myPagesMenu)()]
        ];

        $data['myPagesMenu'] = $createMyPagesMenu();

        return $data;
    }

    public function registerMenus()
    {
        register_nav_menu('my-pages-menu', __('My Pages Menu', MOD_MY_PAGES_TEXT_DOMAIN));
    }

    public function registerOptionsPage()
    {
        new Admin\OptionsPage();
    }

    public function scripts()
    {
        wp_enqueue_script(
            'gdi-host',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('js/gdi-host.js')
        );

        wp_enqueue_script(
            'mod-my-pages-js',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('js/mod-my-pages.js')
        );

        wp_localize_script('gdi-host', 'modMyPages', [
            'restUrl' => get_rest_url(),
            'noticeCodes' => [
                'INACTIVE_SIGNOUT' => NoticeCodes::INACTIVE_SIGNOUT
            ]
        ]);
    }

    public function styles()
    {
        wp_enqueue_style(
            'mod-my-pages-styles',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('css/mod-my-pages.css')
        );
    }

    public function setBladeTemplatePaths(array $array): array
    {
        array_unshift($array, MOD_MY_PAGES_PATH . 'views/');

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

    public function protectPage(array $classes)
    {
        return array_merge($classes, ($this->getPostType)() === MyPages::$postType ? ['protected-page'] : []);
    }


    public function protectedPagePromptController(array $data): array
    {
        $data['protectedPagePrompt'] = [
            'isProtectedPage' => ($this->getPostType)() === MyPages::$postType,
            'loginButton'     => [
                'text' => __('Login', MOD_MY_PAGES_TEXT_DOMAIN),
                'url' => ($this->loginUrl)(($this->currentUrl)()),
            ],
            'homeButton'     => [
                'text' => __('Back to homepage', MOD_MY_PAGES_TEXT_DOMAIN),
                'url' => home_url(),
            ],
        ];

        return $data;
    }

    public function pendingAuthenticationClassName(array $classes)
    {
        return array_merge($classes, ['is-authenticating']);
    }
}
