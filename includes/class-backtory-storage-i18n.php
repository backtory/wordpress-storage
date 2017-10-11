<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       amgir.ir
 * @since      1.0.0
 *
 * @package    Backtory_Storage
 * @subpackage Backtory_Storage/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Backtory_Storage
 * @subpackage Backtory_Storage/includes
 * @author     Abbas MG <www.abbas.mg@gmail.com>
 */
class Backtory_Storage_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'backtory-storage',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
