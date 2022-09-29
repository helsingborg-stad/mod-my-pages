<?php

// Get around direct access blockers.
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/../../../');
}

define('MOD_MY_PAGES_PATH', __DIR__ . '/../../../');
define('MOD_MY_PAGES_URL', 'https://example.com/wp-content/plugins/' . 'modularity-mod-my-pages');
define('MOD_MY_PAGES_TEMPLATE_PATH', MOD_MY_PAGES_PATH . 'templates/');
define('MOD_MY_PAGES_TEXT_DOMAIN', '');
define('PHPUNIT_RUNNING', 1);

// Register the autoloader
$loader = require __DIR__ . '/../../../vendor/autoload.php';
$loader->addPsr4('ModMyPages\\Test\\', __DIR__ . '/../php/');

require_once __DIR__ . '/PluginTestCase.php';
// require_once __DIR__ . '/Repository/FakeAuthService.php';
// require_once __DIR__ . '/Repository/FakeToken.php';
// require_once __DIR__ . '/Repository/NullExitCallback.php';
// require_once __DIR__ . '/Repository/NullSettings.php';
// require_once __DIR__ . '/Repository/FakeRepository.php';
