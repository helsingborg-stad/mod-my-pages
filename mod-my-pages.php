<?php

/**
 * Plugin Name:       Mod My Pages
 * Plugin URI:        https://github.com/helsingborg-stad/mod-my-pages
 * Description:       Modularity Wordpress Plugin
 * Version:           1.0.0
 * Author:            Nikolas Ramstedt
 * Author URI:        https://github.com/helsingborg-stad
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       mod-my-pages
 * Domain Path:       /languages
 */

// Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('MOD_MY_PAGES_PATH', plugin_dir_path(__FILE__));
define('MOD_MY_PAGES_URL', plugins_url('', __FILE__));
define('MOD_MY_PAGES_TEMPLATE_PATH', MOD_MY_PAGES_PATH . 'templates/');
define('MOD_MY_PAGES_TEXT_DOMAIN', 'mod-my-pages');

load_plugin_textdomain(MOD_MY_PAGES_TEXT_DOMAIN, false, MOD_MY_PAGES_PATH . '/languages');

require_once MOD_MY_PAGES_PATH . 'Public.php';

// Register the autoloader
require __DIR__ . '/vendor/autoload.php';

// Acf auto import and export
add_action('acf/init', function () {
    $acfExportManager = new \AcfExportManager\AcfExportManager();
    $acfExportManager->setTextdomain('mod-my-pages');
    $acfExportManager->setExportFolder(MOD_MY_PAGES_PATH . 'source/php/AcfFields/');
    $acfExportManager->autoExport(array(
        'mod-my-pages-settings' => 'group_61ea7a87e8aaa' //Update with acf id here, settings view
    ));
    $acfExportManager->import();
});

// Start application
new ModMyPages\App();
