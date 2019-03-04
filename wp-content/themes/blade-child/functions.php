<?php

/**
 * Child Theme
 * 
 */
 
function grve_blade_child_theme_setup() {
	
}
add_action( 'after_setup_theme', 'grve_blade_child_theme_setup' );

add_filter('ms_frontend_handle_registration', '__return_false'); 
add_action( 'gform_user_registered', 'pi_gravity_registration_autologin', 10, 4 );
/**
* Auto login after registration.
*/
function pi_gravity_registration_autologin( $user_id, $user_config, $entry, $password ) {
$user = get_userdata( $user_id );
$user_login = $user->user_login;
$user_password = $password;

wp_signon( array(
'user_login' => $user_login,
'user_password' => $user_password,
'remember' => false
) );
}

//allow redirection, even if my theme starts to send output to the browser
add_action('init', 'do_output_buffer');
function do_output_buffer() {
        ob_start();
}

add_action('wp_head','wpmy_redirect_logged_in_users_away_from_home');
function wpmy_redirect_logged_in_users_away_from_home() {
	global $pagenow; 

    if( is_user_logged_in() && !is_super_admin()  && $pagenow != 'wp-signup.php' && ( is_home() || is_front_page() ) ) {
		wp_redirect('http://thesis.gatofalante.com/dashboard/');
		exit;
    }
}

add_action( 'template_redirect', function() {

    if( !(is_home() || is_front_page() || is_page('login') || is_page(10595)) ) {

        if (!is_user_logged_in()) {
            wp_redirect( 'http://thesis.gatofalante.com/' ) ;        // redirect all...
            exit();
        }

    }

});


add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);
function add_login_logout_link($items, $args) {
        ob_start();
        wp_loginout('index.php');
        $loginoutlink = ob_get_contents();
        ob_end_clean();
	 	if( $args->theme_location == 'grve_header_nav' )
        	$items .= '<li class="menu-item loginout"><span>'. $loginoutlink .'</span></li>';
    return $items;
}

function my_ajax_handler(){
    global $wpdb;
	$unis=array();
	$additional_unis=array();
	$used_ids = implode(',', $_GET['ids']);	
	$country = $_GET['country'];
	$str = "SELECT * FROM universities ORDER BY RAND() LIMIT 10";
	//only if country is set
	if(strlen($country)) {
		if(strlen($used_ids)) {  
	$str = "SELECT * FROM universities WHERE  country = '".$country."' AND id NOT IN (" .$used_ids. ") ORDER BY id ASC LIMIT 10";
		}
		else {
	$str = "SELECT * FROM universities WHERE  country = '".$country."' ORDER BY id ASC LIMIT 10";
		}
	}
	
	$unis = $wpdb->get_results($str, ARRAY_A);
	//not enough unis in the country
	if(count($unis) <10) {
		$difference = 10 - count($unis);
		if(strlen($used_ids)) {  
 			$additional_unis = $wpdb->get_results("SELECT  * FROM universities WHERE id NOT IN (" .$used_ids. ") ORDER BY id ASC LIMIT ".$difference, ARRAY_A);
		}
	else {
		$additional_unis = $wpdb->get_results("SELECT  * FROM universities ORDER BY id ASC LIMIT ".$difference, ARRAY_A);
		}
 	}//end count adjust
	$results = array_merge($unis, $additional_unis);	
    echo json_encode($results);
    wp_die();
}
add_action( 'wp_ajax_call_my_ajax_handler', 'my_ajax_handler' );
//add_action( 'wp_ajax_nopriv_call_my_ajax_handler', 'my_ajax_handler' );

wp_enqueue_script( 'my-ajax-script', get_stylesheet_directory_uri() . '/unicall_script.js', array('jquery'));
wp_localize_script( 'my-ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
//Omit closing PHP tag to avoid accidental whitespace output errors.
