<?php
/*
 * Plugin Name: Blade Extension
 * Description: This plugin extends Visual Composer and adds custom post type capabilities.
 * Author: Greatives Team
 * Author URI: http://greatives.eu
 * Version: 2.6.5
 * Text Domain: grve-blade-vc-extension
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'GRVE_BLADE_VC_EXT_VERSION' ) ) {
	define( 'GRVE_BLADE_VC_EXT_VERSION', '2.6.5' );
}

if ( ! defined( 'GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH' ) ) {
	define( 'GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL' ) ) {
	define( 'GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! class_exists( 'GRVE_BLADE_VC_Extension_Plugin' ) ) {

	class GRVE_BLADE_VC_Extension_Plugin {

		/**
		 * @action plugins_loaded
		 * @return GRVE_BLADE_VC_Extension_Plugin
		 * @static
		 */
		public static function init()
		{

			static $instance = false;

			if ( ! $instance ) {
				load_plugin_textdomain( 'grve-blade-vc-extension' , false , dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
				$instance = new GRVE_BLADE_VC_Extension_Plugin;
			}
			return $instance;

		}

		/* Add Visual Composer Plugin*/

		private function __construct() {

			if ( is_user_logged_in() ) {
				add_action( 'admin_enqueue_scripts' , $this->marshal( 'grve_vc_extension_add_scripts' ) );
			}
			add_action( 'wp_enqueue_scripts' , $this->marshal( 'grve_vc_extension_add_front_end_scripts' ) );

			require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'includes/grve-functions.php';
			require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'includes/grve-add-param.php';
			require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'includes/grve-shortcode-param.php';


			//Shortcodes
			if( function_exists( 'vc_lean_map' ) || function_exists( 'vc_map' ) ) {

				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_title.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_divider.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_button.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_quote.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_dropcap.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_slogan.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_callout.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_progress_bar.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_pricing_table.php';

				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_message_box.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_icon.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_icon_box.php';

				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_image_text.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_media_box.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_single_image.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_gallery.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_slider.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_video.php';

				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_social.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_gmap.php';

				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_team.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_blog.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_portfolio.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_testimonial.php';
				if ( class_exists( 'woocommerce' ) ) {
					require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_products.php';
				}
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_counter.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_pie_chart.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_typed_text.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_promo.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_flexible_carousel.php';
				require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'shortcodes/grve_countdown.php';

			}

		}

		public function GRVE_BLADE_VC_Extension_Plugin() {
			$this->__construct();
		}

		public function grve_vc_extension_add_scripts( $hook ) {
			wp_enqueue_style('grve-vc-elements', GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL .'assets/css/grve-vc-elements.css', array(), time(), 'all');
			wp_enqueue_style('grve-vc-multi-checkbox', GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL .'assets/css/grve-multi-checkbox.css', array(), time(), 'all');
			wp_enqueue_style('grve-vc-simple-line-icons', GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL .'assets/css/simple-line-icons.css', array(), '2.2.3', 'all');
		}

		public function grve_vc_extension_add_front_end_scripts() {
			wp_register_style( 'grve-vc-simple-line-icons', GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL .'assets/css/simple-line-icons.css', array(), '2.2.3', 'all' );
		}

		public function marshal( $method_name ) {
			return array( &$this , $method_name );
		}
	}

	/**
	 * Initialize the Visual Composer Extension Plugin
	 */
	add_action( 'init' , array( 'GRVE_BLADE_VC_Extension_Plugin' , 'init' ), 12 );


	/**
	 * Initialize Custom Post Types
	 */
	function grve_blade_vce_rewrite_flush() {
		grve_blade_vce_register_custom_post_init();
		flush_rewrite_rules();
	}
	register_activation_hook( __FILE__, 'grve_blade_vce_rewrite_flush' );

	function grve_blade_vce_register_custom_post_init() {
		require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'includes/grve-portfolio-post-type.php';
		require_once GRVE_BLADE_VC_EXT_PLUGIN_DIR_PATH . 'includes/grve-testimonial-post-type.php';
	}
	add_action( 'init', 'grve_blade_vce_register_custom_post_init', 9 );

	function grve_blade_vce_body_class( $classes ){
		$blade_ext_ver = 'grve-vce-ver-' . GRVE_BLADE_VC_EXT_VERSION;
		return array_merge( $classes, array( $blade_ext_ver ) );
	}
	add_filter( 'body_class', 'grve_blade_vce_body_class' );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.