<?php

namespace ModMyPages\Test;

use ModMyPages\Services\LoginUrlServiceFactory;

class LoginButtonTest extends PluginTestCase
{
    public function testShowLoginButtonForUnauthenticatedUsers()
    {
        $this->createFakeApp()
            ->run();

        self::assertNotFalse(has_filter('Municipio/viewData', 'ModMyPages\App->loginButtonController()'));
    }

    public function testHideLoginButtonForAuthenticatedUsers()
    {
        $this->createFakeApp(['isAuthenticated' => true])
            ->run();

        self::assertFalse(has_filter('Municipio/viewData', 'ModMyPages\App->loginButtonController()'));
    }

    public function testEnsureViewHasTextAndUrlForLoginButton()
    {
        $app = $this->createFakeApp()
            ->run();

        $viewData = $app->loginButtonController([
            'loremipsu'             => true,
            'exampleData'           => [],
        ]);

        self::assertArrayHasKey('myPagesMenu', $viewData);
        self::assertNotEmpty($viewData['myPagesMenu']['login']['url'] ?? '');
        self::assertNotEmpty($viewData['myPagesMenu']['login']['text'] ?? '');
    }

    public function testLoginUrlHasCorrectRedirectUrl()
    {
        $getPathFromUrl = fn ($url) => parse_url($url)['path'] ?? '';
        $getQueryStringFromUrl = fn ($url) => parse_url($url)['query'] ?? '';

        $app = $this->createFakeApp()
            ->run();

        $result = $app->loginButtonController([]);

        $loginUrl = $result['myPagesMenu']['login']['url'] ?? '';
        parse_str($getQueryStringFromUrl($loginUrl), $loginUrlQuery);

        $redirectUrl = $loginUrlQuery['redirect_url'] ?? '';

        self::assertArrayHasKey('redirect_url', $loginUrlQuery ?? []);
        self::assertNotEmpty($redirectUrl);
        self::assertEquals('/auth', $getPathFromUrl($redirectUrl));
    }

    public function testLoginUrlHasCorrectCallbackUrl()
    {
        $EXPECT_CALLBACK_URL_TO_HAVE_THIS_PATH = '/should-be-this-path';
        $getPathFromUrl = fn ($url) => parse_url($url)['path'] ?? '';
        $getQueryStringFromUrl = fn ($url) => parse_url($url)['query'] ?? '';

        $app = $this->createFakeApp(
            [
                'loginUrlService' => LoginUrlServiceFactory::create(
                    $this->apiUrl(),
                    $this->homeUrl(),
                    $this->homeUrl() . $EXPECT_CALLBACK_URL_TO_HAVE_THIS_PATH
                )
            ]
        )
            ->run();

        $result = $app->loginButtonController([]);

        $loginUrl = $result['myPagesMenu']['login']['url'] ?? '';
        parse_str($getQueryStringFromUrl($loginUrl), $loginUrlQuery);

        $redirectUrl = $loginUrlQuery['redirect_url'] ?? '';
        parse_str($getQueryStringFromUrl($redirectUrl), $redirectUrlQuery);

        $callbackUrl = $redirectUrlQuery['callbackUrl'] ?? '';

        self::assertArrayHasKey('callbackUrl', $redirectUrlQuery ?? []);
        self::assertNotEmpty($callbackUrl);
        self::assertEquals($EXPECT_CALLBACK_URL_TO_HAVE_THIS_PATH . 'TEST BROKEN TEST', $getPathFromUrl($callbackUrl));
    }
}
