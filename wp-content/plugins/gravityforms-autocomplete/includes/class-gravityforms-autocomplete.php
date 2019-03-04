<?php

if (!class_exists('Gravityforms_Autocomplete')) {

	/**
	 * The core plugin class.
	 *
	 * This is used to define internationalization, admin-specific hooks, and
	 * public-facing site hooks.
	 *
	 * Also maintains the unique identifier of this plugin as well as the current
	 * version of the plugin.
	 */
	class Gravityforms_Autocomplete {

		protected $loader;
		protected $plugin_name;
		protected $version;

		public function __construct() {

			$this->plugin_name = 'gravityforms-autocomplete';
			$this->version = '1.0.1';
                        
                        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-gravityforms-field-autocomplete.php';

			$this->load_dependencies();
			$this->set_locale();
			$this->define_admin_hooks();
			$this->define_public_hooks();
		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - Gravityforms_Autocomplete_Loader. Orchestrates the hooks of the plugin.
		 * - Gravityforms_Autocomplete_i18n. Defines internationalization functionality.
		 * - Gravityforms_Autocomplete_Admin. Defines all hooks for the admin area.
		 * - Gravityforms_Autocomplete_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function load_dependencies() {

			/**
			 * The class responsible for orchestrating the actions and filters of the
			 * core plugin.
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-gravityforms-autocomplete-loader.php';

			/**
			 * The class responsible for defining internationalization functionality
			 * of the plugin.
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-gravityforms-autocomplete-i18n.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-gravityforms-autocomplete-admin.php';

			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-gravityforms-autocomplete-public.php';

			$this->loader = new Gravityforms_Autocomplete_Loader();
		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 * Uses the Gravityforms_Autocomplete_i18n class in order to set the domain and to register the hook
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function set_locale() {

			$plugin_i18n = new Gravityforms_Autocomplete_i18n();
			$plugin_i18n->set_domain($this->get_plugin_name());

			$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_admin_hooks() {
			$plugin_admin = new Gravityforms_Autocomplete_Admin($this->get_plugin_name(), $this->get_version());
            
            
            $this->loader->add_action('gform_routing_field_types', $plugin_admin, 'add_routing_field_types');

			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
                        
                        $this->loader->add_action('admin_init', $plugin_admin, 'gravityforms_settings');

			$this->loader->add_action("gform_editor_js", $plugin_admin, "add_autocomplete_editor_js");
			$this->loader->add_action("gform_field_standard_settings", $plugin_admin, "add_autocomplete_custom_settings", 10, 2);
			$this->loader->add_action('gform_enqueue_scripts', $plugin_admin, 'add_autocomplete_scripts', 10, 2);
		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_public_hooks() {
			$plugin_public = new Gravityforms_Autocomplete_Public($this->get_plugin_name(), $this->get_version());

			$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
			$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
			$this->loader->add_action('gform_after_submission', $plugin_public, 'gform_after_submission',10,2);
            
            $this->loader->add_action('wp_ajax_ga_get_choices_ajax', $plugin_public, 'get_choices_ajax');
            $this->loader->add_action('wp_ajax_nopriv_ga_get_choices_ajax', $plugin_public, 'get_choices_ajax');
		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since    1.0.0
		 */
		public function run() {
			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since     1.0.0
		 * @return    string    The name of the plugin.
		 */
		public function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @since     1.0.0
		 * @return    Gravityforms_Autocomplete_Loader    Orchestrates the hooks of the plugin.
		 */
		public function get_loader() {
			return $this->loader;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since     1.0.0
		 * @return    string    The version number of the plugin.
		 */
		public function get_version() {
			return $this->version;
		}

	}

}