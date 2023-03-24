<?php

namespace ModMyPages\PostType\MyPages;

use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\PostType\MyPages;
use ModMyPages\Service\WPService\GetPostType;
use ModMyPages\Service\WPService\WpEnqueueScript;

class Scripts implements ActionHookSubscriber
{
    protected GetPostType $wp;
    protected WpEnqueueScript $script;

    public function __construct(GetPostType $wp, WpEnqueueScript $script)
    {
        $this->wp = $wp;
        $this->script = $script;
    }

    public static function addActions()
    {
        return [['wp_enqueue_scripts', 'scripts', 20]];
    }

    public function scripts(): void
    {
        if ($this->wp->getPostType() === MyPages::POST_TYPE) {
            $this->script->wpEnqueueScript('mod-my-pages-js');
        }
    }
}
