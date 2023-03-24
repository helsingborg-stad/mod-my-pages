<?php

namespace ModMyPages;

use ModMyPages\Plugin\ApplicationFactory;
use ModMyPages\Plugin\DI\DIContainer;
use ModMyPages\Plugin\PluginManager;

abstract class Application extends PluginManager
{
    use ApplicationFactory;

    public function __construct(DIContainer $DI)
    {
        $this->bootstrap($DI);
        $this->init($DI, $this);
    }

    /**
     * Initialize plugin components with dependecies and registering WP hooks
     */
    public function init(DIContainer $DI, PluginManager $plugin): void
    {
        $plugin
            ->register($DI->make(Admin\OptionsPage::class))
            ->register($DI->make(Admin\AcfSelectIcons::class))
            ->register($DI->make(Rest\AccessToken::class))
            ->register($DI->make(Menu\PrimaryMenu::class))
            ->register($DI->make(Menu\SecondaryMenu::class))
            ->register($DI->make(PostType\MyPages\Register::class))
            ->register($DI->make(PostType\MyPages\Scripts::class))
            ->register($DI->make(PostType\MyPages\RewriteSlug::class))
            ->register($DI->make(PostType\MyPages\Scripts::class))
            ->register($DI->make(PostType\MyPages\PreventRobots::class))
            ->register($DI->make(PostType\MyPages\LoginPrompt::class))
            ->register($DI->make(Notice\ModalNotice::class))
            ->register($DI->make(Modularity\RegisterModules::class));
    }

    /**
     * Boostraps the plugin with services & dependecies
     */
    abstract public function bootstrap(DIContainer $DI): void;
}
