<?php

namespace ModMyPages;

use ModMyPages\Redirect\UseRedirect;
use ModMyPages\Session\Cookie;
use ModMyPages\Session\Token;

class App
{
    private $settings;

    public function __construct()
    {
        add_action('acf/init', array($this, 'optionsPage'), 5);
        add_action('template_redirect', array($this, 'redirect'), 5);
        add_filter('body_class', array($this, 'bodyClassNames'), 5);
    }

    public function redirect()
    {
        new UseRedirect([
                '/auth' => new Authentication([
                    'successUrl' => home_url('/my-pages'),
                    'errorUrl' => home_url('/404'),
                ]),
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
}
