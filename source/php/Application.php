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
     * @param DIContainer $DI
     * @param PluginManager $plugin
     * @return void
     */
    public function init(DIContainer $DI, PluginManager $plugin)
    {
        $plugin
            ->register($DI->make(Admin\OptionsPage::class))
            ->register($DI->make(Rest\AccessToken::class))
            ->register($DI->make(Menu\PrimaryMenu::class))
            ->register($DI->make(Menu\SecondaryMenu::class))
            ->register($DI->make(PostType\MyPages::class))
            ->register($DI->make(PostType\PostTypeSlug::class))
            ->register($DI->make(Notice\ModalNotice::class));
    }

    /**
     * Abstract method required for concrete implementation that boostraps the plugin with services & dependecies
     *
     * @param DIContainer $DI
     * @return void
     */
    abstract public function bootstrap(DIContainer $DI);
}
