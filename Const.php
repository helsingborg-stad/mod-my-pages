<?php

if (!defined('MOD_MY_PAGES_PATH')) {
    define('MOD_MY_PAGES_PATH', __DIR__ . '/');
}

if (!defined('MOD_MY_PAGES_URL')) {
    define('MOD_MY_PAGES_URL', function_exists('plugins_url') ? plugins_url('', __FILE__) : '');
}

if (!defined('MOD_MY_PAGES_DIST_URL')) {
    define('MOD_MY_PAGES_DIST_URL', is_string(MOD_MY_PAGES_URL) ? MOD_MY_PAGES_URL : '' . '/'  . 'dist/');
}

if (!defined('MOD_MY_PAGES_TEMPLATE_PATH')) {
    define('MOD_MY_PAGES_TEMPLATE_PATH', MOD_MY_PAGES_PATH . 'templates/');
}
if (!defined('MOD_MY_PAGES_TEXT_DOMAIN')) {
    define('MOD_MY_PAGES_TEXT_DOMAIN', 'mod-my-pages');
}

if (!defined('MOD_MY_PAGES_MODULE_PATH')) {
    define('MOD_MY_PAGES_MODULE_PATH', MOD_MY_PAGES_PATH . 'source/php/Modularity/Modules/');
}
