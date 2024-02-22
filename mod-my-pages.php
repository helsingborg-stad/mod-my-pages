<?php

/**
 * Plugin Name:       Mod My Pages
 * Plugin URI:        https://github.com/helsingborg-stad/mod-my-pages
 * Description:       Modularity Wordpress Plugin
 * Version: 1.0.5
 * Author:            Nikolas Ramstedt
 * Author URI:        https://github.com/helsingborg-stad
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       mod-my-pages
 * Domain Path:       /languages
 */

// Protect agains direct file access
if (!defined('WPINC')) {
    die;
}

define('MOD_MY_PAGES_PATH', plugin_dir_path(__FILE__));
define('MOD_MY_PAGES_URL', plugins_url('', __FILE__));
define('MOD_MY_PAGES_DIST_URL', MOD_MY_PAGES_URL . '/dist/');
define('MOD_MY_PAGES_TEMPLATE_PATH', MOD_MY_PAGES_PATH . 'templates/');
define('MOD_MY_PAGES_TEXT_DOMAIN', 'mod-my-pages');
define('MOD_MY_PAGES_MODULE_PATH', MOD_MY_PAGES_PATH . 'source/php/Modularity/Modules/');

// Register the autoloader
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

load_plugin_textdomain(MOD_MY_PAGES_TEXT_DOMAIN, false, plugin_basename(dirname(__FILE__)) . '/languages');

/**
 * @psalm-suppress UndefinedClass
 */
add_action('acf/init', function () {
    $acfExportManager = new \AcfExportManager\AcfExportManager();
    $acfExportManager->setTextdomain('mod-my-pages');
    $acfExportManager->setExportFolder(MOD_MY_PAGES_PATH . 'source/php/AcfFields/');
    $acfExportManager->autoExport(array(
        'mod-my-pages-settings'         => 'group_6328267265e02',
        'mod-my-pages-module-my-apps'   => 'group_6400c2b35050d',
    ));
    $acfExportManager->import();
});

/**
 * Soon to be refactored away in favor of below
 * @deprecated  
 */
ModMyPages\Deprecated\AppFactory::createFromEnv()
    ->run();

ModMyPages\Application::create();
