<?php

namespace ModMyPages\Admin;

use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\Service\ACFService\ACFAddOptionsSubPage;

class OptionsPage implements ActionHookSubscriber
{
    private ACFAddOptionsSubPage $acf;

    public function __construct(ACFAddOptionsSubPage $acf)
    {
        $this->acf = $acf;
    }

    public static function addActions(): array
    {
        return [['acf/init', 'registerOptionsPage', 5]];
    }

    public function registerOptionsPage(): void
    {
        $this->acf->acfAddOPtionsSubPage([
            'page_title' => __('My Pages settings', MOD_MY_PAGES_TEXT_DOMAIN),
            'menu_title' => __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN),
            'menu_slug' => 'my-pages-settings',
            'parent_slug' => 'options-general.php',
            'capability' => 'manage_options',
        ]);
    }
}
