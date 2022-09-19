<?php

// Get around direct access blockers.
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/../../../');
}

define('MOD_MY_PAGES_PATH', __DIR__ . '/../../../');
define('MOD_MY_PAGES_URL', 'https://example.com/wp-content/plugins/' . 'modularity-mod-my-pages');
define('MOD_MY_PAGES_TEMPLATE_PATH', MOD_MY_PAGES_PATH . 'templates/');


// Register the autoloader
$loader = require __DIR__ . '/../../../vendor/autoload.php';
$loader->addPsr4('ModMyPages\\Test\\', __DIR__ . '/../php/');

require_once __DIR__ . '/PluginTestCase.php';
