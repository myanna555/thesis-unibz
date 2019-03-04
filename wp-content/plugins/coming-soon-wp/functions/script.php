<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
function dazz_coming_soon_wp_script()
{
	wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
	wp_enqueue_style('thickbox');
	wp_enqueue_style('dazz_csw-bootstrap_css', DAZZ_CSW_PLUGIN_URL.'assets/css/bootstrap.css');
	wp_enqueue_style('dazz_csw-font-awesome_min', DAZZ_CSW_PLUGIN_URL.'assets/css/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('dazz_csw-rcsp_jquery-ui', DAZZ_CSW_PLUGIN_URL.'assets/css/rcsp_jquery-ui.css');
	wp_enqueue_style('dazz_csw-backend', DAZZ_CSW_PLUGIN_URL.'assets/css/backend.css');
	
	//dailog pop css
	wp_enqueue_style('dazz_csw-dialog', DAZZ_CSW_PLUGIN_URL.'assets/css/dialog/dialog.css');
	wp_enqueue_style('dazz_csw-dialog-box-style', DAZZ_CSW_PLUGIN_URL.'assets/css/dialog/dialog-box-style.css');
	wp_enqueue_style('dazz_csw-dialog-wilma', DAZZ_CSW_PLUGIN_URL.'assets/css/dialog/dialog-jamie.css');
	
	
	wp_enqueue_script('theme-preview');
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script('dazz_csw-media-uploads',DAZZ_CSW_PLUGIN_URL.'assets/js/media-upload-script.js',array('media-upload','thickbox','jquery'));
	wp_enqueue_script('dazz_csw-time-picker', DAZZ_CSW_PLUGIN_URL.'assets/js/jquery-ui-timepicker.js',array('jquery','jquery-ui-datepicker'));
	wp_enqueue_script('dazz_csw-my-color-picker-script', DAZZ_CSW_PLUGIN_URL.'assets/js/my-color-picker-script.js', array( 'wp-color-picker' ), false, true );
	wp_enqueue_script('dazz_csw-bootstrap_min_js',DAZZ_CSW_PLUGIN_URL.'assets/js/bootstrap.min.js');
	
	//dailog pop js
	wp_enqueue_script('dazz_csw-snap-svg-min',DAZZ_CSW_PLUGIN_URL.'assets/js/dialog/snap.svg-min.js');
	wp_enqueue_script('dazz_csw-modernizr-custom',DAZZ_CSW_PLUGIN_URL.'assets/js/dialog/modernizr.custom.js');
	wp_enqueue_script('dazz_csw-classie',DAZZ_CSW_PLUGIN_URL.'assets/js/dialog/classie.js');
	wp_enqueue_script('dazz_csw-dialogFx',DAZZ_CSW_PLUGIN_URL.'assets/js/dialog/dialogFx.js'); 
	
}
add_action( 'admin_notices', 'wpsm_dazz_cs_review' );
function wpsm_dazz_cs_review() {

	// Verify that we can do a check for reviews.
	$review = get_option( 'wpsm_dazz_cs_review' );
	$time	= time();
	$load	= false;
	if ( ! $review ) {
		$review = array(
			'time' 		=> $time,
			'dismissed' => false
		);
		add_option('wpsm_dazz_cs_review', $review);
		//$load = true;
	} else {
		// Check if it has been dismissed or not.
		if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) && (isset( $review['time'] ) && (($review['time'] + (DAY_IN_SECONDS * 2)) <= $time)) ) {
			$load = true;
		}
	}
	// If we cannot load, return early.
	if ( ! $load ) {
		return;
	}

	// We have a candidate! Output a review message.
	?>
	<div class="notice notice-info is-dismissible wpsm-dazz-cs-review-notice">
		<div style="float:left;margin-right:10px;margin-bottom:5px;">
			<img style="width:100%;width: 150px;height: auto;" src="<?php echo DAZZ_CSW_PLUGIN_URL.'assets/images/icon-show.png'; ?>" />
		</div>
		<p style="font-size:18px;">'Hi! We saw you have been using <strong>Coming Soon Plugin</strong> for a few days and wanted to ask for your help to <strong>make the plugin better</strong>.We just need a minute of your time to rate the plugin. Thank you!</p>
		<p style="font-size:18px;"><strong><?php _e( '~ dazzlersoft', '' ); ?></strong></p>
		<p style="font-size:19px;"> 
			<a style="color: #fff;background: #ef4238;padding: 5px 7px 4px 6px;border-radius: 4px;" href="https://wordpress.org/support/plugin/coming-soon-wp/reviews/?filter=5#new-post" class="wpsm-dazz-cs-dismiss-review-notice wpsm-dazz-cs-review-out" target="_blank" rel="noopener">Rate the plugin</a>&nbsp; &nbsp;
			<a style="color: #fff;background: #27d63c;padding: 5px 7px 4px 6px;border-radius: 4px;" href="#"  class="wpsm-dazz-cs-dismiss-review-notice wpsm-rate-later" target="_self" rel="noopener"><?php _e( 'Nope, maybe later', '' ); ?></a>&nbsp; &nbsp;
			<a style="color: #fff;background: #31a3dd;padding: 5px 7px 4px 6px;border-radius: 4px;" href="#" class="wpsm-dazz-cs-dismiss-review-notice wpsm-rated" target="_self" rel="noopener"><?php _e( 'I already did', '' ); ?></a>
		</p>
	</div>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$(document).on('click', '.wpsm-dazz-cs-dismiss-review-notice, .wpsm-dazz-cs-dismiss-notice .notice-dismiss', function( event ) {
				if ( $(this).hasClass('wpsm-dazz-cs-review-out') ) {
					var wpsm_rate_data_val = "1";
				}
				if ( $(this).hasClass('wpsm-rate-later') ) {
					var wpsm_rate_data_val =  "2";
					event.preventDefault();
				}
				if ( $(this).hasClass('wpsm-rated') ) {
					var wpsm_rate_data_val =  "3";
					event.preventDefault();
				}

				$.post( ajaxurl, {
					action: 'wpsm_dazz_cs_dismiss_review',
					wpsm_rate_data_dazz_cs : wpsm_rate_data_val
				});
				
				$('.wpsm-dazz-cs-review-notice').hide();
				//location.reload();
			});
		});
	</script>
	<?php
}

add_action( 'wp_ajax_wpsm_dazz_cs_dismiss_review', 'wpsm_dazz_cs_dismiss_review' );
function wpsm_dazz_cs_dismiss_review() {
	if ( ! $review ) {
		$review = array();
	}
	
	if($_POST['wpsm_rate_data_dazz_cs']=="1"){
		$review['time'] 	 = time();
		$review['dismissed'] = false;
		
	}
	if($_POST['wpsm_rate_data_dazz_cs']=="2"){
		$review['time'] 	 = time();
		$review['dismissed'] = false;
		
	}
	if($_POST['wpsm_rate_data_dazz_cs']=="3"){
		$review['time'] 	 = time();
		$review['dismissed'] = true;
		
	}
	update_option( 'wpsm_dazz_cs_review', $review );
	die;
}

?>