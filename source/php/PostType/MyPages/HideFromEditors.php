<?php

namespace ModMyPages\PostType\MyPages;

use ModMyPages\Plugin\FilterHookSubscriber;
use ModMyPages\PostType\MyPages;

class HideFromEditors implements FilterHookSubscriber
{
    public static function addFilters()
    {
        return [
            ['register_post_type_args', 'hideAdminMenu', 100, 2]
        ];
    }

    public function hideAdminMenu(array $args, string $postType): array
    {
        if ($postType !== MyPages::POST_TYPE && !is_user_logged_in()) {
            return $args;
        }

        if (!in_array('administrator', (array) (wp_get_current_user())->roles)) {
            $args['show_in_menu'] = false;
        }

        return $args;
    }
}
