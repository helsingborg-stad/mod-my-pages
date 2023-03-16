<?php

namespace ModMyPages\PostType;

use ModMyPages\Plugin\ActionHookSubscriber;

class MyPagesPreventAlgolia implements ActionHookSubscriber
{
    public static function addActions()
    {
        return [
            ['AlgoliaIndex/IndexablePostTypes', 'preventIndexing']
        ];
    }

    public function preventIndexing(array $postTypes): array
    {
        return array_filter($postTypes, fn ($postType) => $postType !== MyPages::$postType);
    }
}
