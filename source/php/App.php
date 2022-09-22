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
        if (!Cookie::get() || !Token::isValid(Cookie::get())) {
            return $item;
        }
        $item['label'] = Frontend\TemplateStrings::replace($item['label']);
        return $item;
    }
}
