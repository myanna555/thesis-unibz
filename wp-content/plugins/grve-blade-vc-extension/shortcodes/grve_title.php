<?php
/**
 * Title Shortcode
 */

if( !function_exists( 'grve_blade_vce_title_shortcode' ) ) {

	function grve_blade_vce_title_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'increase_heading' => '100',
					'line_type' => 'no-line',
					'line_width' => '50',
					'line_height' => '2',
					'line_color' => 'primary-1',
					'align' => 'left',
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

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$title_classes = array( 'grve-element grve-title' );

		array_push( $title_classes, 'grve-align-' . $align );


		if ( !empty( $animation ) ) {
			array_push( $title_classes, 'grve-animated-item' );
			array_push( $title_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty( $heading ) ) {
			array_push( $title_classes, 'grve-' . $heading );
		}

		if ( !empty( $el_class ) ) {
			array_push( $title_classes, $el_class );
		}

		$title_class_string = implode( ' ', $title_classes );



		$output .= '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '" style="' . $style . '"' . $data . '>';

		if( '100' != $increase_heading ){
			$output .= '<span style="font-size: ' . $increase_heading . '%; line-height: 1.120em;">' . $title;
		} else {
			$output .= '<span>' . $title;
		}
		if( 'line' == $line_type ) {
			$line_style = '';
			$line_style .= 'width: '.(preg_match('/(px|em|\%|pt|cm)$/', $line_width) ? $line_width : $line_width.'px').';';
			$line_style .= 'height: '. $line_height. 'px;';
			$output .=   '<span class="grve-title-line grve-bg-' . esc_attr( $line_color ) . '" style="' . esc_attr( $line_style ) . '"></span>';
		}
		$output .= '</span>';
		$output .= '</' . tag_escape( $heading_tag ) . '>';

		return $output;
	}
	add_shortcode( 'grve_title', 'grve_blade_vce_title_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_title_shortcode_params' ) ) {
	function grve_blade_vce_title_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Title", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Add a title in many and diverse ways", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-title",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
					"param_name" => "title",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter your title here.", "grve-blade-vc-extension" ),
					"save_always" => true,
					"admin_label" => true,
				),
				grve_blade_vce_get_heading_tag( "h3" ),
				grve_blade_vce_get_heading( "h3" ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Increase Heading Size", "grve-blade-vc-extension" ),
					"param_name" => "increase_heading",
					"value" => array(
						esc_html__( "100%", "grve-blade-vc-extension" ) => '100',
						esc_html__( "120%", "grve-blade-vc-extension" ) => '120',
						esc_html__( "140%", "grve-blade-vc-extension" ) => '140',
						esc_html__( "160%", "grve-blade-vc-extension" ) => '160',
						esc_html__( "180%", "grve-blade-vc-extension" ) => '180',
						esc_html__( "200%", "grve-blade-vc-extension" ) => '200',
					),
					"description" => esc_html__( "Set the percentage you want to increase your Headings size.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line type", "grve-blade-vc-extension" ),
					"param_name" => "line_type",
					"value" => array(
						esc_html__( "No Line", "grve-blade-vc-extension" ) => 'no-line',
						esc_html__( "With Line", "grve-blade-vc-extension" ) => 'line',
					),
					"description" => '',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Line Width", "grve-blade-vc-extension" ),
					"param_name" => "line_width",
					"value" => "50",
					"description" => esc_html__( "Enter the width for your line (Note: CSS measurement units allowed).", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'line' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Line Height", "grve-blade-vc-extension" ),
					"param_name" => "line_height",
					"value" => "2",
					"std" => "2",
					"value" => array( '1', '2', '3', '4' , '5', '6', '7', '8', '9' , '10' ),
					"description" => esc_html__( "Enter the hight for your line in px.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "line_type", 'value' => array( 'line' ) ),
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
					"dependency" => array( 'element' => "line_type", 'value' => array( 'line' ) ),
				),
				grve_blade_vce_add_align(),
				grve_blade_vce_add_animation(),
				grve_blade_vce_add_animation_delay(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_title', 'grve_blade_vce_title_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_title_shortcode_params( 'grve_title' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
