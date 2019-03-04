<?php
/**
 * Plugin Name: Coming Soon wp
 * Version: 1.5.4
 * Description: Coming Soon Wp plugin is Modern and responsive, manage your website while launching soon , under construction & maintenance mode.
 * Author: dazzlersoft
 * Author URI: http://www.dazzlersoftware.com
 * Plugin URI: http://www.dazzlersoftware.com/blog
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;
define("DAZZ_CSW_TEXT_DOMAIN","DAZZ_CSW_lang" );
define("DAZZ_CSW_PLUGIN_URL", plugin_dir_url(__FILE__));

//Get Ready Plugin Translation
add_action('plugins_loaded', 'dazz_csw_language_translation');
function dazz_csw_language_translation() {
	load_plugin_textdomain( DAZZ_CSW_TEXT_DOMAIN, FALSE, dirname( plugin_basename(__FILE__)).'/language/' );
}

// Default Data 
register_activation_hook( __FILE__, 'dazz_cs_dd' );
function dazz_cs_dd()
{
	include('functions/default-data.php');
}

// Coming Soon wp Menu add 
add_action('admin_menu','dazz_coming_soon_wp_menu');

function dazz_coming_soon_wp_menu()
{
    //plugin menu name for coming soon plugin
    $menu = add_menu_page('Coming Soon wp', 'Coming Soon wp','administrator', 'dazz_coming_soon_wp','dazz_coming_soon_content','dashicons-media-text');

    //add hook to add styles and scripts for coming soon panel
    add_action( 'admin_print_styles-' . $menu, 'dazz_coming_soon_wp_script' );
}
require_once('functions/script.php');

function dazz_coming_soon_content()
{  
	require_once('backend/content.php');
}

function dazz_cs_launch()
{
	$dazz_cs_dashboard = unserialize(get_option('dazz_cs_dashboard'));
	$dazz_cs_status = $dazz_cs_dashboard['dazz_cs_status'];
	
	if($dazz_cs_status=="1")
	{	
		// Exit if a custom login page
		if(preg_match("/login|admin|dashboard|account/i",$_SERVER['REQUEST_URI']) > 0 ){
			return false;
		}		
		// Check if user is logged in.
		if (!is_user_logged_in())
		{
			$file = plugin_dir_path( __FILE__ )."frontend/index.php";
			include($file);
			exit();
		}
		else{			
			//get logined in user role
			$wp_get_current_user =  wp_get_current_user();
			$LoggedInUserID = $wp_get_current_user->ID;
			$UserData = get_userdata( $LoggedInUserID );
			//if user role not 'administrator' then redirect page 
			if($UserData->roles[0] != "administrator")
			{
				$file = plugin_dir_path( __FILE__ )."frontend/index.php";
				include($file);
				exit();
			}			
		}
	}
}
add_action( 'template_redirect', 'dazz_cs_launch' );

//Live Preview code
if (  (isset($_GET['dazz_cs_preview']) && $_GET['dazz_cs_preview'] == 'true') )
{ 		
	$file = plugin_dir_path( __FILE__ )."frontend/index.php";
	include($file);
	exit();
}

add_action('admin_bar_menu', 'dazz_cs_admin_bar_button', 1000);
function dazz_cs_admin_bar_button()
{	
	global $wp_admin_bar;
	$dazz_cs_dashboard = unserialize(get_option('dazz_cs_dashboard'));
	$dazz_cs_status = $dazz_cs_dashboard['dazz_cs_status'];
	if($dazz_cs_status=='0') return;
	$msg = __('Coming Soon Mode Active','');
	// Add Parent Menu
	$argsParent=array(
		'id' => 'myCustomMenu',
		'title' => $msg,
		'parent' => 'top-secondary',
		'href' => '?page=dazz_coming_soon_wp',
		'meta'   => array( 'class' => 'dazz_cs_admin_bar_button_cs' ),
	);
	$wp_admin_bar->add_menu($argsParent);
	?>
	<style>
		.dazz_cs_admin_bar_button_cs a{
			background: #916194 !important;
			color: #fff !important;
		}
		.dazz_cs_admin_bar_button_cs a:hover{
			background: #916194 !important;
			color: #fff !important;
		}
	</style>
	<?php
}
?>