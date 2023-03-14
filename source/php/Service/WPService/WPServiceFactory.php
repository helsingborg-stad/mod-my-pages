<?php

namespace ModMyPages\Service\WPService;

class WPServiceFactory
{
    public static function create(): WPService
    {
        return new class implements WPService
        {
            public function wpGetNavMenuItems($menu, $args = []): ?array
            {
                return wp_get_nav_menu_items($menu, $args) ?: null;
            }

            public function getNavMenuLocations(): array
            {
                return get_nav_menu_locations();
            }

            public function registerNavMenu($location, string $description): void
            {
                register_nav_menu($location, $description);
            }

            public function getPostType(?int $postId = null): ?string
            {
                return get_post_type($postId) ?: null;
            }

            public function homeUrl(string $path = "", string $scheme = null): string
            {
                return home_url($path, $scheme);
            }

            public function isArchive(): bool
            {
                return is_archive();
            }

            public function isSingle(): bool
            {
                return is_single();
            }

            public function registerRestRoute(string $namespace, string $route, array $args): bool
            {
                return register_rest_route($namespace, $route, $args);
            }

            public function wpEnqueueStyle(string $handle, ?string $src = null, ?array $deps = null, ?string $ver = null, ?string $media = null): void
            {
                wp_enqueue_style($handle, $src ?? '', $deps ?? [], $ver ?? false, $media ?? 'all');
            }

            public function wpEnqueueScript(string $handle, ?string $src = null, ?array $deps = null, ?string $ver = null, ?bool $inFooter = null): void
            {
                wp_enqueue_script($handle, $src ?? '', $deps ?? [], $ver ?? false, $inFooter ?? false);
            }
        };
    }
}
