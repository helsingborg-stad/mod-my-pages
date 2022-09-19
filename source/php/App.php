<?php

namespace ModMyPages;

class App
{
    public function __construct()
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(array(
                'page_title' => __('My Pages settings', MOD_MY_PAGES_TEXT_DOMAIN),
                'menu_title' => __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN),
                'menu_slug' => 'my-pages-settings',
                'parent_slug' => 'options-general.php',
                'capability' => 'manage_options'
            ));
        }
    }
}
