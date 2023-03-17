<?php

namespace ModMyPages\PostType\MyPages;

use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\PostType\MyPages;

class PreventAlgolia implements ActionHookSubscriber
{
    public static function addActions()
    {
        return [
            ['AlgoliaIndex/IndexablePostTypes', 'excludePostType']
        ];
    }

    public function excludePostType(array $postTypes): array
    {
        return array_filter($postTypes, fn ($postType) => $postType !== MyPages::POST_TYPE);
    }
}
