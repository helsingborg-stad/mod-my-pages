<?php

namespace ModMyPages\Helper;

class CacheBust
{
    /**
     * @psalm-param 'css/mod-my-pages.css'|'js/gdi-host.js'|'js/mod-my-pages.js' $name
     */
    public static function name(string $name)
    {
        $jsonPath =
            MOD_MY_PAGES_PATH .
            apply_filters('ModMyPages/Helper/CacheBust/RevManifestPath', 'dist/manifest.json');

        $revManifest = [];
        if (file_exists($jsonPath)) {
            $revManifest = json_decode(file_get_contents($jsonPath), true);
        } elseif (self::isDebug()) {
            echo '<div style="color:red">Error: Assets not built. Go to ' .
                MOD_MY_PAGES_PATH .
                ' and run gulp. See ' .
                MOD_MY_PAGES_PATH .
                'README.md for more info.</div>';
        }

        return $revManifest[$name] ?? '';
    }

    private static function isDebug(): bool
    {
        return defined('WP_DEBUG') && WP_DEBUG;
    }
}
