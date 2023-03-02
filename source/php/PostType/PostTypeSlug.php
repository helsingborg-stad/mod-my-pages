<?php

namespace ModMyPages\PostType;

use ModMyPages\Plugin\FilterHookSubscriber;
use ModMyPages\Service\ACFService\ACFGetOption;

class PostTypeSlug implements FilterHookSubscriber
{
    private ACFGetOption $acf;

    public function __construct(ACFGetOption $acf)
    {
        $this->acf = $acf;
    }

    public static function addFilters()
    {
        return [
            ['register_post_type_args', 'modifyPostTypes', 100, 2]
        ];
    }

    public function modifyPostTypes($args, $postType)
    {
        if (defined('MOD_MY_PAGES_DEFAULT_POST_TYPE_NAMES')) {
            return $args;
        }

        $postTypesToModify = [
            'my-pages' => [
                'slug' => 'mina-sidor',
                'singular' => __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN),
                'plural' => __('My Pages', MOD_MY_PAGES_TEXT_DOMAIN)
            ]
        ];

        if (!in_array($postType, array_keys($postTypesToModify))) {
            return $args;
        }

        if (!empty($postTypesToModify[$postType]['slug'])) {
            $args['rewrite'] = array(
                'slug' => $postTypesToModify[$postType]['slug']
            );
        }

        // Alter labels
        if (
            !empty($postTypesToModify[$postType]['plural'])
            && !empty($postTypesToModify[$postType]['singular'])
        ) {
            $args['labels'] = array(
                'name'              => $postTypesToModify[$postType]['plural'],
                'singular_name'     => $postTypesToModify[$postType]['singular'],
                'add_new'             => sprintf(
                    __('Add new %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($postTypesToModify[$postType]['singular'])
                ),
                'add_new_item'        => sprintf(
                    __('Add new %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($postTypesToModify[$postType]['singular'])
                ),
                'edit_item'           => sprintf(
                    __('Edit %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($postTypesToModify[$postType]['singular'])
                ),
                'new_item'            => sprintf(
                    __('New %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($postTypesToModify[$postType]['singular'])
                ),
                'view_item'           => sprintf(
                    __('View %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($postTypesToModify[$postType]['singular'])
                ),
                'search_items'        => sprintf(
                    __('Search %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($postTypesToModify[$postType]['plural'])
                ),
                'not_found'           => sprintf(
                    __('No %s found', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($postTypesToModify[$postType]['plural'])
                ),
                'not_found_in_trash'  => sprintf(
                    __('No %s found in trash', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($postTypesToModify[$postType]['plural'])
                ),
                'parent_item_colon'   => sprintf(
                    __('Parent %s:', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($postTypesToModify[$postType]['singular'])
                ),
                'menu_name'           => $postTypesToModify[$postType]['plural'],
            );
        }


        return $args;
    }
}
