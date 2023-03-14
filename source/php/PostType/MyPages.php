<?php

namespace ModMyPages\PostType;

class MyPages
{
    public static $postType = 'my-pages';

    public function __construct()
    {
        $this->registerPostType();
    }

    public function registerPostType(): void
    {
        $args = array(
            'menu_icon'          => 'dashicons-portfolio',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => array('title', 'editor', 'thumbnail', 'content', 'excerpt'),
            'show_in_rest'       => false,
        );

        $restArgs = array(
            'exclude_keys' => array('author', 'acf', 'guid', 'link', 'template', 'meta', 'taxonomy', 'menu_order')
        );

        $postType = new \ModMyPages\Helper\PostType(
            self::$postType,
            __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN),
            __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN),
            $args,
            array(),
            $restArgs
        );

        $postType->enableArchiveModules();
    }
}
