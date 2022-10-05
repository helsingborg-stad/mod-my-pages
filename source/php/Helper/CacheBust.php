<?php

namespace ModMyPages\Helper;

class CacheBust
{
    public static function name($name)
    {
        $jsonPath = MOD_MY_PAGES_PATH . apply_filters(
            'ModMyPages/Helper/CacheBust/RevManifestPath',
            'dist/manifest.json'
        );

        $revManifest = [];
        if (file_exists($jsonPath)) {
            $revManifest = json_decode(file_get_contents($jsonPath), true);
        } elseif ($this->isDebug()) {
            echo '<div style="color:red">Error: Assets not built. Go to ' . MOD_MY_PAGES_PATH . ' and run gulp. See ' . MOD_MY_PAGES_PATH . 'README.md for more info.</div>';
        }

        return $revManifest[$name] ?? '';
    }

    public function isDebug()
    {
        return defined('WP_DEBUG') && WP_DEBUG;
    }
}
