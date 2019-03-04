<?php

/*
 * @wordpress-plugin
 * Plugin Name:       Gravity Forms Autocomplete
 * Plugin URI:        https://codecanyon.net/user/ma-group
 * Description:       Gravity Forms Autocomplete.
 * Version:           1.5.0
 * Author:            ma_group
 * Author URI:        https://codecanyon.net/user/ma-group
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gravityforms-autocomplete
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('GravityForms_Autocomplete_Plugin')) {

	class GravityForms_Autocomplete_Plugin {

		function __construct() {
			register_activation_hook(__FILE__, array($this, 'install'));
			register_deactivation_hook(__FILE__, array($this, 'uninstall'));
			
			$this->run();
		}

		function install() { }

		function uninstall() { }
		
		function run() {
			require plugin_dir_path(__FILE__) . 'includes/class-gravityforms-autocomplete.php';
			$plugin = new Gravityforms_Autocomplete();
			$plugin->run();
		}

	}

}

new GravityForms_Autocomplete_Plugin();

