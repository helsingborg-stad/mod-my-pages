<?php

namespace ModMyPages\PostType\MyPages;

use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\PostType\MyPages;
use ModMyPages\Service\WPService\GetPostType;

class PreventRobots implements ActionHookSubscriber
{
    protected GetPostType $wp;

    public function __construct(GetPostType $wp)
    {
        $this->wp = $wp;
    }

    public static function addActions()
    {
        return [
            ['wp_head', 'setNoIndexNoFollowMeta']
        ];
    }

    public function setNoIndexNoFollowMeta(): void
    {
        if ($this->wp->getPostType() === MyPages::POST_TYPE) {
            echo '<meta name="robots" content="noindex,nofollow">';
        }
    }
}
