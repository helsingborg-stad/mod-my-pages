<?php

namespace ModMyPages\PostType;

use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\Service\WPService\GetPostType;

class MyPagesPreventRobots implements ActionHookSubscriber
{
    protected GetPostType $wp;

    public function __construct(GetPostType $wp)
    {
        $this->wp = $wp;
    }

    public static function addActions()
    {
        return [
            ['wp_head', 'preventIndexing']
        ];
    }

    public function preventIndexing(): void
    {
        if ($this->wp->getPostType() === MyPages::$postType) {
            echo '<meta name="robots" content="noindex,nofollow">';
        }
    }
}
