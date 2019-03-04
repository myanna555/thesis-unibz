<?php
/**
 * Callout Shortcode
 */

if( !function_exists( 'grve_blade_vce_callout_shortcode' ) ) {

	function grve_blade_vce_callout_shortcode( $atts, $content ) {

		$output = $button = $data = $class_leader = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'btn_position' => 'btn-right',
					'button_text' => '',
					'button_link' => '',
					'button_type' => 'simple',
					'button_size' => 'medium',
					'button_color' => 'primary-1',
					'button_hover_color' => 'black',
					'button_shape' => 'square',
					'button_class' => '',
					'btn_add_icon' => '',
					'btn_icon_library' => 'fontawesome',
					'btn_icon_fontawesome' => 'fa fa-adjust',
					'btn_icon_openiconic' => 'vc-oi vc-oi-dial',
					'btn_icon_typicons' => 'typcn typcn-adjust-brightness',
					'btn_icon_entypo' => 'entypo-icon entypo-icon-note',
					'btn_icon_linecons' => 'vc_li vc_li-heart',
					'btn_icon_simplelineicons' => 'smp-icon-user',
					'btn_aria_label' => '',
					'leader_text' => '',
					'animation' => '',
					'animation_delay' => '200',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		if ( !empty( $animation ) ) {
			$animation = 'grve-' .$animation;
		}

		$heading_class = 'grve-' . $heading;

		if ( 'yes' == $leader_text ) {
			$class_leader = 'grve-leader-text';
		}

		//Button
		$button_options = array(
			'button_text'  => $button_text,
			'button_link'  => $button_link,
			'button_type'  => $button_type,
			'button_size'  => $button_size,
			'button_color' => $button_color,
			'button_hover_color' => $button_hover_color,
			'button_shape' => $button_shape,
			'button_class' => $button_class,
			'btn_add_icon' => $btn_add_icon,
			'btn_icon_library' => $btn_icon_library,
			'btn_icon_fontawesome' => $btn_icon_fontawesome,
			'btn_icon_openiconic' => $btn_icon_openiconic,
			'btn_icon_typicons' => $btn_icon_typicons,
			'btn_icon_entypo' => $btn_icon_entypo,
			'btn_icon_linecons' => $btn_icon_linecons,
			'btn_icon_simplelineicons' => $btn_icon_simplelineicons,
			'btn_aria_label' => $btn_aria_label,
		);
		$button = grve_blade_vce_get_button( $button_options );

		$callout_classes = array( 'grve-element', 'grve-callout' );

		if ( !empty( $animation ) ) {
			array_push( $callout_classes, 'grve-animated-item' );
			array_push( $callout_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $callout_classes, $el_class);
		}

		array_push( $callout_classes, 'grve-' . $btn_position );

		$callout_class_string = implode( ' ', $callout_classes );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $callout_class_string ) . '" style="' . $style . '">';
		$output .= '  <div class="grve-callout-wrapper">';
		if ( !empty( $title ) ) {
			$output .= '<' . tag_escape( $heading_tag ) . ' class="grve-callout-content ' . esc_attr( $heading_class ) . '">' . $title . '</' . tag_escape( $heading_tag ) . '>';
		}
		if ( !empty( $content ) ) {
		$output .= '    <p class="'. esc_attr( $class_leader ) . '">' . grve_blade_vce_unautop( $content ) . '</p>';
		}
		$output .= '  </div>';
		$output .= '  <div class="grve-button-wrapper">';
		$output .= $button;
		$output .= '  </div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_callout', 'grve_blade_vce_callout_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_callout_shortcode_params' ) ) {
	function grve_blade_vce_callout_shortcode_params( $tag ) {
		$grve_blade_vce_callout_shortcode_btn_params = grve_blade_vce_get_button_params();
		$grve_blade_vce_callout_shortcode_params = array_merge(
			array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__( "Enter your title.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				grve_blade_vce_get_heading_tag( "h3" ),
				grve_blade_vce_get_heading( "h3" ),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "grve-blade-vc-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Enter your text.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "callout_style", 'value' => array( '1' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Leader Text", "grve-blade-vc-extension" ),
					"param_name" => "leader_text",
					"description" => esc_html__( "If selected, text will be shown as leader", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Make text leader", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Button Position", "grve-blade-vc-extension" ),
					"param_name" => "btn_position",
					"value" => array(
						esc_html__( "Right", "grve-blade-vc-extension" ) => 'btn-right',
						esc_html__( "Bottom", "grve-blade-vc-extension" ) => 'btn-bottom',
					),
					"description" => esc_html__( "Select the position of the button.", "grve-blade-vc-extension" ),
					"group" => esc_html__( "Button", "grve-blade-vc-extension" ),
				),
				grve_blade_vce_add_animation(),
				grve_blade_vce_add_animation_delay(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
			$grve_blade_vce_callout_shortcode_btn_params
		);

		return array(
			"name" => esc_html__( "Callout", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Two different styles for interesting callouts", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-callout",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => $grve_blade_vce_callout_shortcode_params,
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_callout', 'grve_blade_vce_callout_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_callout_shortcode_params( 'grve_callout' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
