<?php

namespace ModMyPages\PostType;

use ModMyPages\Plugin\ActionHookSubscriber;

class MyPagesPreventAlgolia implements ActionHookSubscriber
{
    public static function addActions()
    {
        return [
            ['algolia_should_index_searchable_post', 'preventIndexing']
        ];
    }

    public function preventIndexing(bool $shouldIndex, \WP_Post $post): bool
    {
        return $shouldIndex && $post->post_type !== MyPages::$postType;
    }
}
