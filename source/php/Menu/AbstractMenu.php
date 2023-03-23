<?php

namespace ModMyPages\Menu;

use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\Plugin\FilterHookSubscriber;
use ModMyPages\Service\ACFService\ACFGetOption;
use ModMyPages\Service\LoginUrlService\ILoginUrlService;
use ModMyPages\Service\WPService\GetPostType;
use ModMyPages\Service\WPService\HomeUrl;
use ModMyPages\Service\WPService\WpEnqueueScript;
use ModMyPages\Service\WPService\WPNavService;

abstract class AbstractMenu implements ActionHookSubscriber, FilterHookSubscriber
{
    abstract protected static function description(): string;

    abstract public function controller($items): array;

    /**
     * @psalm-suppress CircularReference
     */
    const MENU_SLUG = self::MENU_SLUG;

    protected ACFGetOption $acf;

    protected WPNavService $wp;

    protected GetPostType $query;

    protected ILoginUrlService $createLoginUrl;

    protected HomeUrl $site;

    protected WpEnqueueScript $script;

    public function __construct(
        ACFGetOption $acf,
        WPNavService $wp,
        ILoginUrlService $createLoginUrl,
        GetPostType $query,
        HomeUrl $site,
        WpEnqueueScript $script
    ) {
        $this->createLoginUrl = $createLoginUrl;
        $this->acf = $acf;
        $this->wp = $wp;
        $this->query = $query;
        $this->site = $site;
        $this->script = $script;
    }

    public static function addActions()
    {
        return [
            ['init', 'registerMenus', 5],
            ['wp_enqueue_scripts', 'scripts', 30],
        ];
    }


    public function scripts(): void
    {
    }

    public static function addFilters(): array
    {
        return [
            ['Municipio/viewData', 'viewController']
        ];
    }


    private function getMenuItemsByLocation(string $location): array
    {
        return $this->wp->wpGetNavMenuItems(
            $this->wp->getNavMenuLocations()[$location] ?? 0
        ) ?: [];
    }

    protected function items(): array
    {
        /**
         * @psalm-suppress CircularReference
         */
        return $this->getMenuItemsByLocation(static::MENU_SLUG);
    }

    /**
     *
     * @param \WP_Post|mixed $post
     * @return \WP_Post|mixed
     */
    protected function mapItem($post)
    {
        return $post;
    }

    public function registerMenus(): void
    {
        /**
         * @psalm-suppress CircularReference
         */
        $this->wp->registerNavMenu(
            static::MENU_SLUG,
            static::description()
        );
    }

    public function viewController(array $data): array
    {
        return array_merge(
            $this->controller(
                array_map([$this, 'mapItem'], $this->items())
            ),
            $data
        );
    }
}
