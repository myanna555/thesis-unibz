<?php
/**
 * Button Shortcode
 */

if( !function_exists( 'grve_blade_vce_button_shortcode' ) ) {

	function grve_blade_vce_button_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'button_text' => 'Button',
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
					'btn_fluid' => '',
					'btn_fluid_height' => 'medium',
					'animation' => '',
					'animation_delay' => '200',
					'align' => 'left',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		if ( !empty( $animation ) ) {
			$animation = 'grve-' .$animation;
		}

		$button_classes = array( 'grve-element', 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $button_classes, 'grve-animated-item' );
			array_push( $button_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $button_classes, $el_class);
		}
		$button_class_string = implode( ' ', $button_classes );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

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
			'btn_fluid' => $btn_fluid,
			'btn_fluid_height' => $btn_fluid_height,
			'style' => $style,
		);
		$button = grve_blade_vce_get_button( $button_options );

		$output .= '<div class="' . $button_class_string . '"' . $data . '>';
		$output .= $button;
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_button', 'grve_blade_vce_button_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_button_shortcode_params' ) ) {
	function grve_blade_vce_button_shortcode_params( $tag ) {

		$grve_blade_vce_button_shortcode_btn_params = grve_blade_vce_get_button_params();
		$grve_blade_vce_button_shortcode_params = array_merge(
			array(
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Fluid Button", "grve-blade-vc-extension" ),
					"param_name" => "btn_fluid",
					"value" => array( esc_html__( "If selected, you will have this button Fluid (Full width).", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Button Height", "grve-blade-vc-extension" ),
					"param_name" => "btn_fluid_height",
					'value' => array(
						esc_html__( 'Short' , 'grve-blade-vc-extension' ) => 'short',
						esc_html__( 'Medium' , 'grve-blade-vc-extension' ) => 'medium',
						esc_html__( 'Tall' , 'grve-blade-vc-extension' ) => 'tall',
					),
					"std" => 'medium',
					"description" => esc_html__( "Select height for your fluid button.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "btn_fluid", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Alignment", "grve-blade-vc-extension" ),
					"param_name" => "align",
					"value" => array(
						esc_html__( "Left", "grve-blade-vc-extension" ) => 'left',
						esc_html__( "Right", "grve-blade-vc-extension" ) => 'right',
						esc_html__( "Center", "grve-blade-vc-extension" ) => 'center',
					),
					"description" => '',
					"admin_label" => true,
					"dependency" => array( 'element' => "btn_fluid", 'value_not_equal_to' => array( 'yes' ) ),
				),
				grve_blade_vce_add_animation(),
				grve_blade_vce_add_animation_delay(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
			$grve_blade_vce_button_shortcode_btn_params
		);

		return array(
			"name" => esc_html__( "Button", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Several styles, sizes and colors for your buttons", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-button",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => $grve_blade_vce_button_shortcode_params,
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_button', 'grve_blade_vce_button_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_button_shortcode_params( 'grve_button' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
