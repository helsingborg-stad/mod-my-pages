<?php

namespace ModMyPages;

use ModMyPages\Redirect\UseRedirect;
use ModMyPages\Session\Cookie;
use ModMyPages\Session\Token;
use ModPages\Admin\Settings;

class App
{
    public function __construct()
    {
        add_action('acf/init', array($this, 'optionsPage'), 5);
        add_action('template_redirect', array($this, 'redirect'), 5);
        add_filter('body_class', array($this, 'bodyClassNames'), 5);
        add_filter('Municipio/Navigation/Item', array($this, 'replaceMenuLabels'));
        add_filter('Municipio/blade/view_paths', array($this, 'addSearchableBladeTemplatePaths'), 1, 1);
        add_action('init', array($this, 'registerMyPagesMenu'), 5, 2);
        add_filter('Municipio/viewData', array($this, 'myPagesMenuController'), 1, 1);
    }

    public function redirect()
    {
        new UseRedirect([
            '/auth' => new Authentication([
                'successUrl' => home_url('/my-pages'),
                'errorUrl' => home_url('/404'),
            ]),
            '/signout' => new SignOut([
                'successUrl' => home_url(),
                'errorUrl' => home_url('/404'),
            ]),
            '*' => new ProtectedPage(
                array_map(
                    fn ($p) => $p->ID,
                    get_posts(
                        [
                            'post_type' => 'page',
                            'posts_per_page' => -1,
                            'meta_key' => 'mod_my_pages_protected_page',
                            'meta_value' => 1
                        ]
                    )
                )
            ),
        ]);
    }

    public function optionsPage()
    {
        new Admin\OptionsPage();
    }

    public function bodyClassNames(array $classNames)
    {
        return array_merge(
            $classNames,
            Cookie::get() && Token::isValid(Cookie::get()) ? ['is-authenticated'] : []
        );
    }

    public function replaceMenuLabels($item)
    {
        if (Cookie::get() && Token::isValid(Cookie::get())) {
            $item['label'] = Frontend\TemplateStrings::replace($item['label']);
        }
        return $item;
    }

    public function addSearchableBladeTemplatePaths(array $array): array
    {
        is_child_theme()
            ? array_splice($array, 2, 0, array(MOD_MY_PAGES_PATH . 'views/'))
            : array_unshift($array, MOD_MY_PAGES_PATH . 'views/');

        return $array;
    }

    public function registerMyPagesMenu()
    {
        register_nav_menu('my-pages-menu', __('My Pages Menu', MOD_MY_PAGES_TEXT_DOMAIN));
    }

    public function myPagesMenuController($data)
    {
        $redirectUrl = add_query_arg(['callbackUrl' => home_url('mina-sidor')], home_url('auth'));
        $loginUrl = add_query_arg(['redirect_url' => $redirectUrl], \ModMyPages\Admin\Settings::apiUrl() . '/api/v1/auth/login');
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
            'login'     => [
                'text'      => __('Login', MOD_MY_PAGES_TEXT_DOMAIN),
                'url'      => $loginUrl
            ],
            'dropdown'  => [
                'text'      => \ModMyPages\Session\Profile::name(),
                'items'     => $dropdownItems
            ],
        ];

        return $data;
    }
}
