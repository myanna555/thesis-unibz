<?php
/**
 * Divider Shortcode
 */

if( !function_exists( 'grve_blade_vce_divider_shortcode' ) ) {

	function grve_blade_vce_divider_shortcode( $atts, $content ) {

		$output = $class_fullwidth = $style = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'line_type' => 'line',
					'line_width' => '50',
					'line_height' => '2',
					'line_color' => 'primary-1',
					'backtotop_title' => 'Back to top',
					'padding_top' => '',
					'padding_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$style .= grve_blade_vce_build_padding_top_style( $padding_top );
		$style .= grve_blade_vce_build_padding_bottom_style( $padding_bottom );

		$output .= '<div class="grve-element grve-hr ' . $el_class.'" style="' . $style . '">';
		
		if( 'custom-line' == $line_type ) {
			$line_style = '';
			$line_style .= 'width: '.(preg_match('/(px|em|\%|pt|cm)$/', $line_width) ? $line_width : $line_width.'px').';';
			$line_style .= 'height: '. $line_height. 'px;';
			$output .=   '<span class="grve-title-line grve-bg-' . esc_attr( $line_color ) . '" style="' . esc_attr( $line_style ) . '"></span>';
		} else {	
			$output .= '<div class="grve-' . $line_type . '-divider">';
			if ( !empty( $backtotop_title ) && 'top-line' == $line_type ) {
				$output .= '    <span class="grve-divider-backtotop grve-small-text grve-text-hover-primary-1">' . $backtotop_title. '</span>';
			}
			$output .= '</div>';
		}
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_divider', 'grve_blade_vce_divider_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_divider_shortcode_params' ) ) {
	function grve_blade_vce_divider_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Divider", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Insert dividers, just spaces or different lines", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-divider",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line type", "grve-blade-vc-extension" ),
					"param_name" => "line_type",
					"value" => array(
						esc_html__( "Line", "grve-blade-vc-extension" ) => 'line',
						esc_html__( "Double Line", "grve-blade-vc-extension" ) => 'double-line',
						esc_html__( "Dashed Line", "grve-blade-vc-extension" ) => 'dashed-line',
						esc_html__( "Back to Top", "grve-blade-vc-extension" ) => 'top-line',
						esc_html__( "Custom Line", "grve-blade-vc-extension" ) => 'custom-line',
					),
					"description" => '',
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Line Width", "grve-blade-vc-extension" ),
					"param_name" => "line_width",
					"value" => "50",
					"description" => esc_html__( "Enter the width for your line (Note: CSS measurement units allowed).", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'custom-line' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line Height", "grve-blade-vc-extension" ),
					"param_name" => "line_height",
					"value" => "2",
					"std" => "2",
					"value" => array( '1', '2', '3', '4' , '5', '6', '7', '8', '9' , '10' ),
					"description" => esc_html__( "Enter the hight for your line in px.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'custom-line' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line Color", "grve-blade-vc-extension" ),
					"param_name" => "line_color",
					"value" => array(
						esc_html__( "Primary 1", "grve-blade-vc-extension" ) => 'primary-1',
						esc_html__( "Primary 2", "grve-blade-vc-extension" ) => 'primary-2',
						esc_html__( "Primary 3", "grve-blade-vc-extension" ) => 'primary-3',
						esc_html__( "Primary 4", "grve-blade-vc-extension" ) => 'primary-4',
						esc_html__( "Primary 5", "grve-blade-vc-extension" ) => 'primary-5',
						esc_html__( "Green", "grve-blade-vc-extension" ) => 'green',
						esc_html__( "Orange", "grve-blade-vc-extension" ) => 'orange',
						esc_html__( "Red", "grve-blade-vc-extension" ) => 'red',
						esc_html__( "Blue", "grve-blade-vc-extension" ) => 'blue',
						esc_html__( "Aqua", "grve-blade-vc-extension" ) => 'aqua',
						esc_html__( "Purple", "grve-blade-vc-extension" ) => 'purple',
						esc_html__( "Black", "grve-blade-vc-extension" ) => 'black',
						esc_html__( "Grey", "grve-blade-vc-extension" ) => 'grey',
						esc_html__( "White", "grve-blade-vc-extension" ) => 'white',
					),
					"description" => esc_html__( "Color for the line.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'custom-line' ) ),
				),				
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Back to Top Title", "grve-blade-vc-extension" ),
					"param_name" => "backtotop_title",
					"value" => "Back to top",
					"description" => esc_html__( "Set Back to top title.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'top-line' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Top padding", "grve-blade-vc-extension" ),
					"param_name" => "padding_top",
					"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Bottom padding", "grve-blade-vc-extension" ),
					"param_name" => "padding_bottom",
					"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", "grve-blade-vc-extension" ),
				),
				grve_blade_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_divider', 'grve_blade_vce_divider_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_divider_shortcode_params( 'grve_divider' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.