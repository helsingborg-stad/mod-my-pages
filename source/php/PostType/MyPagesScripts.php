<?php

namespace ModMyPages\PostType;

use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\Service\WPService\GetPostType;
use ModMyPages\Service\WPService\WpEnqueueScript;

class MyPagesScripts implements ActionHookSubscriber
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
        return [
            ['wp_enqueue_scripts', 'scripts', 20]
        ];
    }

    public function scripts(): void
    {
        if ($this->wp->getPostType() === MyPages::$postType) {
            $this->script->wpEnqueueScript('mod-my-pages-js');
        }
    }
}
