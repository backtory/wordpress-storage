<?php

/*
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.-
 *
 * @link              amgir.ir
 * @since             1.0.0
 * @package           Backtory_Storage
 *
 * @wordpress-plugin
 * Plugin Name:       Backtory Storage
 * Plugin URI:        backtory.com
 * Description:       Backtory Storage Wordpress plugin
 * Version:           1.0.0
 * Author:            Backtory
 * Author URI:        backtory.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       backtory-storage
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
set_time_limit(0);

require_once "vendor/autoload.php";
require_once "const.php";
require_once "functions.php";
require_once "admin/partials/backtory-storage-actions.php";
require_once "admin/partials/backtory-storage-templates.php";

define( 'PLUGIN_VERSION', '1.0.0' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-backtory-storage-activator.php
 */
function activate_backtory_storage() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-backtory-storage-activator.php';
	Backtory_Storage_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-backtory-storage-deactivator.php
 */
function deactivate_backtory_storage() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-backtory-storage-deactivator.php';
	Backtory_Storage_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_backtory_storage' );
register_deactivation_hook( __FILE__, 'deactivate_backtory_storage' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-backtory-storage.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_backtory_storage() {
	$plugin = new Backtory_Storage();
	$plugin->run();
}

run_backtory_storage();