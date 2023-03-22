<?php

namespace ModMyPages\PostType\MyPages;

use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\PostType\MyPages;
use ModMyPages\Service\ACFService\ACFGetOption;
use ModMyPages\Service\LoginUrlService\ILoginUrlService;
use ModMyPages\Service\WPService\GetPostType;
use ModMyPages\Service\WPService\HomeUrl;

class LoginPrompt implements ActionHookSubscriber
{
    protected GetPostType $wp;
    protected ACFGetOption $acf;
    protected HomeUrl $query;
    protected ILoginUrlService $loginUrl;

    public function __construct(
        GetPostType $wp,
        ACFGetOption $acf,
        HomeUrl $query,
        ILoginUrlService $loginUrl
    ) {
        $this->wp = $wp;
        $this->acf = $acf;
        $this->query = $query;
        $this->loginUrl = $loginUrl;
    }

    public static function addActions()
    {
        return [
            ['Municipio/viewData', 'protectedPagePromptController']
        ];
    }

    public function protectedPagePromptController(array $data): array
    {
        $data['protectedPagePrompt'] = [
            'isProtectedPage' => $this->wp->getPostType() === MyPages::POST_TYPE,
            'title'     => $this->acf->getOption('login_prompt_title') ?: __('Log in to view the content', MOD_MY_PAGES_TEXT_DOMAIN),
            'content'     => $this->acf->getOption('login_prompt_content') ?: '',
            'loginButton'     => [
                'text' => $this->acf->getOption('login_prompt_login_button_label') ?: __('Login', MOD_MY_PAGES_TEXT_DOMAIN),
                'url' => $this->loginUrl->buildUrl($this->query->homeUrl($_SERVER['REQUEST_URI'] ?? '')),
            ],
            'homeButton'     => [
                'text' => $this->acf->getOption('login_prompt_home_button_label') ?: __('Back to homepage', MOD_MY_PAGES_TEXT_DOMAIN),
                'url' => $this->query->homeUrl(),
            ]
        ];

        return $data;
    }
}
