<?php

namespace ModMyPages\Deprecated;

use Firebase\JWT\Key;
use ModMyPages\Deprecated\Types\Application;
use ModMyPages\Helper\CacheBust;
use ModMyPages\Notice\ModalNoticeCodes;
use ModMyPages\PostType\MyPages;
use ModMyPages\Redirect\Handlers\AuthenticateUser;
use ModMyPages\Redirect\Handlers\SignOutUser;
use ModMyPages\Token\AccessToken;

/**
 * @deprecated
 */
class App extends Application
{
    public function run(): Application
    {
        add_action('template_redirect', array($this, 'redirect'), 5);
        add_action('wp_enqueue_scripts', array($this, 'scripts'));
        add_action('wp_enqueue_scripts', array($this, 'styles'));
        add_filter('Municipio/blade/view_paths', array($this, 'setBladeTemplatePaths'), 5);
        add_filter('ModMyPages/UI/DropdownMenu::items', array($this, 'disableInstantPageOnMenuItems'), 10, 1);
        add_filter('body_class', array($this, 'protectPage'), 20, 1);
        add_filter('body_class', array($this, 'pendingAuthenticationClassName'), 20, 1);

        return $this;
    }

    /**
     * @return void
     */
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

    public function scripts(): void
    {
        wp_enqueue_script(
            'gdi-host',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('js/gdi-host.js')
        );

        wp_register_script(
            'mod-my-pages-js',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('js/mod-my-pages.js'),
            ['gdi-host']
        );

        wp_localize_script('gdi-host', 'modMyPages', [
            'restUrl' => get_rest_url(),
            'noticeCodes' => [
                'INACTIVE_SIGNOUT' => ModalNoticeCodes::INACTIVE_SIGNOUT
            ]
        ]);
    }

    public function styles(): void
    {
        wp_enqueue_style(
            'mod-my-pages-styles',
            MOD_MY_PAGES_DIST_URL . CacheBust::name('css/mod-my-pages.css')
        );
    }

    public function setBladeTemplatePaths(array $paths): array
    {
        array_unshift($paths, MOD_MY_PAGES_PATH . 'views/');

        return $paths;
    }

    /**
     * @return array[]
     *
     * @psalm-return array<array>
     */
    public function disableInstantPageOnMenuItems(array $items): array
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

    /**
     * @return (mixed|string)[]
     *
     * @psalm-return array<'protected-page'|mixed>
     */
    public function protectPage(array $classes): array
    {
        return array_merge($classes, ($this->getPostType)() === MyPages::POST_TYPE ? ['protected-page'] : []);
    }

    /**
     * @return (mixed|string)[]
     *
     * @psalm-return array{0: 'is-authenticating',...}
     */
    public function pendingAuthenticationClassName(array $classes): array
    {
        return array_merge($classes, ['is-authenticating']);
    }
}
