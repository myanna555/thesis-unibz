<?php 

require_once( dirname( dirname( dirname( dirname( __FILE__ )))) . '/wp-load.php' );

global $wpdb;
$current_user = wp_get_current_user();

if($wpdb !=null && $current_user !=null) {
$wpdb->insert( 
	'user_progress', 
	array( 
		'user_id' => $current_user->ID, 
		'step' => $step_id
		
	), 
	array( 
		'%s', 
		'%s'
	) 
);
}//end insert progress

?>
