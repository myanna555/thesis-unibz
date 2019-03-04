<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( function_exists( 'vc_add_shortcode_param' ) ) {

	function grve_blade_vce_multi_checkbox_settings_field( $param, $param_value ) {

		$param_line = '';
		$current_value = explode(",", $param_value);
		$values = is_array($param['value']) ? $param['value'] : array();

		foreach ( $values as $label => $v ) {
			$checked = in_array($v, $current_value) ? ' checked="checked"' : '';
			$checkbox_input_class = 'grve-checkbox-input-item';
			$checkbox_class = 'grve-checkbox-item';
			if ( '' == $v ) {
				$checkbox_input_class = 'grve-checkbox-input-item-all';
				$checkbox_class = 'grve-checkbox-item grve-checkbox-item-all';
			}
			$param_line .= '<div class="' . esc_attr( $checkbox_class ) . '"><input id="'. esc_attr( $param['param_name'] ) . '-' . esc_attr( $v ) .'" value="' . esc_attr( $v ) . '" class="'. esc_attr( $checkbox_input_class ) . '" type="checkbox" '.$checked.'> ' . __($label, "js_composer") . '</div>';
		}

		return '<div class="grve-multi-checkbox-container">' .
			   '  <input class="wpb_vc_param_value wpb-checkboxes '. esc_attr( $param['param_name'] ) . ' ' . esc_attr( $param['type'] ) . '_field" type="hidden" value="' . esc_attr( $param_value ) . '" name="' . esc_attr( $param['param_name'] ) . '"/>'
				. $param_line .
				'</div>';

	}
	vc_add_shortcode_param( 'grve_multi_checkbox', 'grve_blade_vce_multi_checkbox_settings_field', GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL . '/assets/js/grve-multi-checkbox.js' );

}

function grve_blade_vce_iconpicker_type_simplelineicons( $icons ) {
	$simplelineicons_icons = array(
		array( 'smp-icon-user' => 'smp-icon-user' ),
		array( 'smp-icon-people' => 'smp-icon-people' ),
		array( 'smp-icon-user-female' => 'smp-icon-user-female' ),
		array( 'smp-icon-user-follow' => 'smp-icon-user-follow' ),
		array( 'smp-icon-user-following' => 'smp-icon-user-following' ),
		array( 'smp-icon-user-unfollow' => 'smp-icon-user-unfollow' ),
		array( 'smp-icon-login' => 'smp-icon-login' ),
		array( 'smp-icon-logout' => 'smp-icon-logout' ),
		array( 'smp-icon-emotsmile' => 'smp-icon-emotsmile' ),
		array( 'smp-icon-phone' => 'smp-icon-phone' ),
		array( 'smp-icon-call-end' => 'smp-icon-call-end' ),
		array( 'smp-icon-call-in' => 'smp-icon-call-in' ),
		array( 'smp-icon-call-out' => 'smp-icon-call-out' ),
		array( 'smp-icon-map' => 'smp-icon-map' ),
		array( 'smp-icon-location-pin' => 'smp-icon-location-pin' ),
		array( 'smp-icon-direction' => 'smp-icon-direction' ),
		array( 'smp-icon-directions' => 'smp-icon-directions' ),
		array( 'smp-icon-compass' => 'smp-icon-compass' ),
		array( 'smp-icon-layers' => 'smp-icon-layers' ),
		array( 'smp-icon-menu' => 'smp-icon-menu' ),
		array( 'smp-icon-list' => 'smp-icon-list' ),
		array( 'smp-icon-options-vertical' => 'smp-icon-options-vertical' ),
		array( 'smp-icon-options' => 'smp-icon-options' ),
		array( 'smp-icon-arrow-down' => 'smp-icon-arrow-down' ),
		array( 'smp-icon-arrow-left' => 'smp-icon-arrow-left' ),
		array( 'smp-icon-arrow-right' => 'smp-icon-arrow-right' ),
		array( 'smp-icon-arrow-up' => 'smp-icon-arrow-up' ),
		array( 'smp-icon-arrow-up-circle' => 'smp-icon-up-circle' ),
		array( 'smp-icon-arrow-left-circle' => 'smp-icon-left-circle' ),
		array( 'smp-icon-arrow-right-circle' => 'smp-icon-right-circle' ),
		array( 'smp-icon-arrow-down-circle' => 'smp-icon-down-circle' ),
		array( 'smp-icon-check' => 'smp-icon-check' ),
		array( 'smp-icon-clock' => 'smp-icon-clock' ),
		array( 'smp-icon-plus' => 'smp-icon-plus' ),
		array( 'smp-icon-close' => 'smp-icon-close' ),
		array( 'smp-icon-trophy' => 'smp-icon-trophy' ),
		array( 'smp-icon-screen-smartphone' => 'smp-icon-screen-smartphone' ),
		array( 'smp-icon-screen-desktop' => 'smp-icon-screen-desktop' ),
		array( 'smp-icon-plane' => 'smp-icon-plane' ),
		array( 'smp-icon-notebook' => 'smp-icon-notebook' ),
		array( 'smp-icon-mustache' => 'smp-icon-mustache' ),
		array( 'smp-icon-mouse' => 'smp-icon-mouse' ),
		array( 'smp-icon-magnet' => 'smp-icon-magnet' ),
		array( 'smp-icon-energy' => 'smp-icon-energy' ),
		array( 'smp-icon-disc' => 'smp-icon-disc' ),
		array( 'smp-icon-cursor' => 'smp-icon-cursor' ),
		array( 'smp-icon-cursor-move' => 'smp-icon-cursor-move' ),
		array( 'smp-icon-crop' => 'smp-icon-crop' ),
		array( 'smp-icon-chemistry' => 'smp-icon-chemistry' ),
		array( 'smp-icon-speedometer' => 'smp-icon-speedometer' ),
		array( 'smp-icon-shield' => 'smp-icon-shield' ),
		array( 'smp-icon-screen-tablet' => 'smp-icon-screen-tablet' ),
		array( 'smp-icon-magic-wand' => 'smp-icon-magic-wand' ),
		array( 'smp-icon-hourglass' => 'smp-icon-hourglass' ),
		array( 'smp-icon-graduation' => 'smp-icon-graduation' ),
		array( 'smp-icon-ghost' => 'smp-icon-ghost' ),
		array( 'smp-icon-game-controller' => 'smp-icon-game-controller' ),
		array( 'smp-icon-fire' => 'smp-icon-fire' ),
		array( 'smp-icon-eyeglass' => 'smp-icon-eyeglass' ),
		array( 'smp-icon-envelope-open' => 'smp-icon-envelope-open' ),
		array( 'smp-icon-envelope-letter' => 'smp-icon-envelope-letter' ),
		array( 'smp-icon-bell' => 'smp-icon-bell' ),
		array( 'smp-icon-badge' => 'smp-icon-badge' ),
		array( 'smp-icon-anchor' => 'smp-icon-anchor' ),
		array( 'smp-icon-wallet' => 'smp-icon-wallet' ),
		array( 'smp-icon-vector' => 'smp-icon-vector' ),
		array( 'smp-icon-speech' => 'smp-icon-speech' ),
		array( 'smp-icon-puzzle' => 'smp-icon-puzzle' ),
		array( 'smp-icon-printer' => 'smp-icon-printer' ),
		array( 'smp-icon-present' => 'smp-icon-present' ),
		array( 'smp-icon-playlist' => 'smp-icon-playlist' ),
		array( 'smp-icon-pin' => 'smp-icon-pin' ),
		array( 'smp-icon-picture' => 'smp-icon-picture' ),
		array( 'smp-icon-handbag' => 'smp-icon-handbag' ),
		array( 'smp-icon-globe-alt' => 'smp-icon-globe-alt' ),
		array( 'smp-icon-globe' => 'smp-icon-globe' ),
		array( 'smp-icon-folder-alt' => 'smp-icon-folder-alt' ),
		array( 'smp-icon-folder' => 'smp-icon-folder' ),
		array( 'smp-icon-film' => 'smp-icon-film' ),
		array( 'smp-icon-feed' => 'smp-icon-feed' ),
		array( 'smp-icon-drop' => 'smp-icon-drop' ),
		array( 'smp-icon-drawar' => 'smp-icon-drawar' ),
		array( 'smp-icon-docs' => 'smp-icon-docs' ),
		array( 'smp-icon-doc' => 'smp-icon-doc' ),
		array( 'smp-icon-diamond' => 'smp-icon-diamond' ),
		array( 'smp-icon-cup' => 'smp-icon-cup' ),
		array( 'smp-icon-calculator' => 'smp-icon-calculator' ),
		array( 'smp-icon-bubbles' => 'smp-icon-bubbles' ),
		array( 'smp-icon-briefcase' => 'smp-icon-briefcase' ),
		array( 'smp-icon-book-open' => 'smp-icon-book-open' ),
		array( 'smp-icon-basket-loaded' => 'smp-icon-basket-loaded' ),
		array( 'smp-icon-basket' => 'smp-icon-basket' ),
		array( 'smp-icon-bag' => 'smp-icon-bag' ),
		array( 'smp-icon-action-undo' => 'smp-icon-action-undo' ),
		array( 'smp-icon-action-redo' => 'smp-icon-user' ),
		array( 'smp-icon-wrench' => 'smp-icon-action-redo' ),
		array( 'smp-icon-umbrella' => 'smp-icon-umbrella' ),
		array( 'smp-icon-trash' => 'smp-icon-trash' ),
		array( 'smp-icon-tag' => 'smp-icon-tag' ),
		array( 'smp-icon-support' => 'smp-icon-support' ),
		array( 'smp-icon-frame' => 'smp-icon-frame' ),
		array( 'smp-icon-size-fullscreen' => 'smp-icon-size-fullscreen' ),
		array( 'smp-icon-size-actual' => 'smp-icon-size-actual' ),
		array( 'smp-icon-shuffle' => 'smp-icon-shuffle' ),
		array( 'smp-icon-share-alt' => 'smp-icon-share-alt' ),
		array( 'smp-icon-share' => 'smp-icon-share' ),
		array( 'smp-icon-rocket' => 'smp-icon-rocket' ),
		array( 'smp-icon-question' => 'smp-icon-question' ),
		array( 'smp-icon-pie-chart' => 'smp-icon-pie-chart' ),
		array( 'smp-icon-pencil' => 'smp-icon-pencil' ),
		array( 'smp-icon-note' => 'smp-icon-note' ),
		array( 'smp-icon-loop' => 'smp-icon-loop' ),
		array( 'smp-icon-home' => 'smp-icon-home' ),
		array( 'smp-icon-grid' => 'smp-icon-grid' ),
		array( 'smp-icon-graph' => 'smp-icon-graph' ),
		array( 'smp-icon-microphone' => 'smp-icon-microphone' ),
		array( 'smp-icon-music-tone-alt' => 'smp-icon-music-tone-alt' ),
		array( 'smp-icon-music-tone' => 'smp-icon-music-tone' ),
		array( 'smp-icon-earphones-alt' => 'smp-icon-earphones-alt' ),
		array( 'smp-icon-earphones' => 'smp-icon-earphones' ),
		array( 'smp-icon-equalizer' => 'smp-icon-equalizer' ),
		array( 'smp-icon-like' => 'smp-icon-like' ),
		array( 'smp-icon-dislike' => 'smp-icon-dislike' ),
		array( 'smp-icon-control-start' => 'smp-icon-control-start' ),
		array( 'smp-icon-control-rewind' => 'smp-icon-control-rewind' ),
		array( 'smp-icon-control-play' => 'smp-icon-control-play' ),
		array( 'smp-icon-control-pause' => 'smp-icon-control-pause' ),
		array( 'smp-icon-control-forward' => 'smp-icon-control-forward' ),
		array( 'smp-icon-control-end' => 'smp-icon-control-end' ),
		array( 'smp-icon-volume-1' => 'smp-icon-volume-1' ),
		array( 'smp-icon-volume-2' => 'smp-icon-volume-2' ),
		array( 'smp-icon-volume-off' => 'smp-icon-volume-off' ),
		array( 'smp-icon-calendar' => 'smp-icon-calendar' ),
		array( 'smp-icon-bulb' => 'smp-icon-bulb' ),
		array( 'smp-icon-chart' => 'smp-icon-chart' ),
		array( 'smp-icon-ban' => 'smp-icon-ban' ),
		array( 'smp-icon-bubble' => 'smp-icon-bubble' ),
		array( 'smp-icon-camrecorder' => 'smp-icon-camrecorder' ),
		array( 'smp-icon-camera' => 'smp-icon-camera' ),
		array( 'smp-icon-cloud-download' => 'smp-icon-cloud-download' ),
		array( 'smp-icon-cloud-upload' => 'smp-icon-cloud-upload' ),
		array( 'smp-icon-envelope' => 'smp-icon-envelope' ),
		array( 'smp-icon-eye' => 'smp-icon-eye' ),
		array( 'smp-icon-flag' => 'smp-icon-flag' ),
		array( 'smp-icon-heart' => 'smp-icon-heart' ),
		array( 'smp-icon-info' => 'smp-icon-info' ),
		array( 'smp-icon-key' => 'smp-icon-key' ),
		array( 'smp-icon-link' => 'smp-icon-link' ),
		array( 'smp-icon-lock' => 'smp-icon-lock' ),
		array( 'smp-icon-lock-open' => 'smp-icon-lock-open' ),
		array( 'smp-icon-magnifier' => 'smp-icon-magnifier' ),
		array( 'smp-icon-magnifier-add' => 'smp-icon-magnifier-add' ),
		array( 'smp-icon-magnifier-remove' => 'smp-icon-magnifier-remove' ),
		array( 'smp-icon-paper-clip' => 'smp-icon-paper-clip' ),
		array( 'smp-icon-paper-plane' => 'smp-icon-paper-plane' ),
		array( 'smp-icon-power' => 'smp-icon-power' ),
		array( 'smp-icon-refresh' => 'smp-icon-refresh' ),
		array( 'smp-icon-reload' => 'smp-icon-reload' ),
		array( 'smp-icon-settings' => 'smp-icon-settings' ),
		array( 'smp-icon-star' => 'smp-icon-star' ),
		array( 'smp-icon-symble-female' => 'smp-icon-symble-female' ),
		array( 'smp-icon-symbol-male' => 'smp-icon-symbol-male' ),
		array( 'smp-icon-target' => 'smp-icon-target' ),
		array( 'smp-icon-credit-card' => 'smp-icon-credit-card' ),
		array( 'smp-icon-paypal' => 'smp-icon-paypal' ),
		array( 'smp-icon-social-tumblr' => 'smp-icon-social-tumblr' ),
		array( 'smp-icon-social-twitter' => 'smp-icon-social-twitter' ),
		array( 'smp-icon-social-facebook' => 'smp-icon-social-facebook' ),
		array( 'smp-icon-social-instagram' => 'smp-icon-social-instagram' ),
		array( 'smp-icon-social-linkedin' => 'smp-icon-social-linkedin' ),
		array( 'smp-icon-social-pinterest' => 'smp-icon-social-pinterest' ),
		array( 'smp-icon-social-github' => 'smp-icon-social-github' ),
		array( 'smp-icon-social-gplus' => 'smp-icon-social-gplus' ),
		array( 'smp-icon-social-reddit' => 'smp-icon-social-reddit' ),
		array( 'smp-icon-social-skype' => 'smp-icon-social-skype' ),
		array( 'smp-icon-social-dribbble' => 'smp-icon-social-dribbble' ),
		array( 'smp-icon-social-behance' => 'smp-icon-social-behance' ),
		array( 'smp-icon-social-foursqare' => 'smp-icon-social-foursqare' ),
		array( 'smp-icon-social-soundcloud' => 'smp-icon-social-soundcloud' ),
		array( 'smp-icon-social-spotify' => 'smp-icon-social-spotify' ),
		array( 'smp-icon-social-stumbleupon' => 'smp-icon-social-stumbleupon' ),
		array( 'smp-icon-social-youtube' => 'smp-icon-social-youtube' ),
		array( 'smp-icon-social-dropbox' => 'smp-icon-social-dropbox' ),
	);

	return array_merge( $icons, $simplelineicons_icons );
}

add_filter( 'vc_iconpicker-type-simplelineicons', 'grve_blade_vce_iconpicker_type_simplelineicons' );


function grve_blade_vce_icon_element_fonts_enqueue( $font ) {
	switch ( $font ) {
		case 'simplelineicons':
			wp_enqueue_style( 'grve-vc-simple-line-icons' );
		break;
		default:
		break;
	}
}
add_action( 'vc_enqueue_font_icon_element', 'grve_blade_vce_icon_element_fonts_enqueue' );

//Omit closing PHP tag to avoid accidental whitespace output errors.
