<?php
/**
 * Typed Text Shortcode
 */

if( !function_exists( 'grve_blade_vce_countdown_shortcode' ) ) {

	function grve_blade_vce_countdown_shortcode( $atts, $content ) {

		$output = $el_class = $data = '';

		extract(
			shortcode_atts(
				array(
					'final_date' => '',
					'countdown_format' => 'D|H|M|S',
					'countdown_style' => '1',
					'numbers_size' => 'h3',
					'text_size' => 'small-text',
					'numbers_color' => 'black',
					'text_color' => 'black',
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

		$countdown_classes = array( 'grve-element' , 'grve-countdown' );

		array_push( $countdown_classes, 'grve-style-' . $countdown_style );

		if ( !empty( $animation ) ) {
			array_push( $countdown_classes, 'grve-animated-item' );
			array_push( $countdown_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $countdown_classes, $el_class);
		}

		$countdown_class_string = implode( ' ', $countdown_classes );


		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );


		$output .= '<div class="' . esc_attr( $countdown_class_string ) . '" style="' . $style . '" data-countdown="' . esc_attr( $final_date ) . '" data-countdown-format="' . esc_attr( $countdown_format ) . '" data-numbers-size="' . esc_attr( $numbers_size ) . '" data-text-size="' . esc_attr( $text_size ) . '" data-numbers-color="' . esc_attr( $numbers_color ) . '" data-text-color="' . esc_attr( $text_color ) . '"' . $data . '></div>';


		return $output;
	}
	add_shortcode( 'grve_countdown', 'grve_blade_vce_countdown_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_countdown_shortcode_params' ) ) {
	function grve_blade_vce_countdown_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Countdown", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Add a countdown element", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-countdown",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Final Date", "grve-blade-vc-extension" ),
					"param_name" => "final_date",
					"value" => "",
					"description" => esc_html__( "Accepted formats: YYYY/MM/DD , MM/DD/YYYY , YYYY/MM/DD hh:mm:ss , MM/DD/YYYY hh:mm:ss ( e.g: 2016/05/12 )", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Countdown Display", "grve-blade-vc-extension" ),
					"param_name" => "countdown_format",
					"value" => array(
						esc_html__( "Days Hours Minutes Seconds", "grve-blade-vc-extension" ) => 'D|H|M|S',
						esc_html__( "Weeks Days Hours Minutes Seconds", "grve-blade-vc-extension" ) => 'w|d|H|M|S',
					),
					'std' => 'D|H|M|S',
					"description" => esc_html__( "Select the countdown display.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Countdown Style", "grve-blade-vc-extension" ),
					"param_name" => "countdown_style",
					"value" => array(
						esc_html__( "Style 1", "grve-blade-vc-extension" ) => '1',
						esc_html__( "Style 2", "grve-blade-vc-extension" ) => '2',
						esc_html__( "Style 3", "grve-blade-vc-extension" ) => '3',
					),
					'std' => '1',
					"description" => esc_html__( "Select the countdown style.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Numbers size", "grve-blade-vc-extension" ),
					"param_name" => "numbers_size",
					"value" => array(
						esc_html__( "h1", "grve-blade-vc-extension" ) => 'h1',
						esc_html__( "h2", "grve-blade-vc-extension" ) => 'h2',
						esc_html__( "h3", "grve-blade-vc-extension" ) => 'h3',
						esc_html__( "h4", "grve-blade-vc-extension" ) => 'h4',
						esc_html__( "h5", "grve-blade-vc-extension" ) => 'h5',
						esc_html__( "h6", "grve-blade-vc-extension" ) => 'h6',
						esc_html__( "Leader Text", "grve-blade-vc-extension" ) => 'leader-text',
						esc_html__( "Subtitle Text", "grve-blade-vc-extension" ) => 'subtitle-text',
						esc_html__( "Small Text", "grve-blade-vc-extension" ) => 'small-text',
						esc_html__( "Link Text", "grve-blade-vc-extension" ) => 'link-text',
					),
					"description" => esc_html__( "Numbers size and typography", "grve-blade-vc-extension" ),
					"std" => 'h3',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Text size", "grve-blade-vc-extension" ),
					"param_name" => "text_size",
					"value" => array(
						esc_html__( "h1", "grve-blade-vc-extension" ) => 'h1',
						esc_html__( "h2", "grve-blade-vc-extension" ) => 'h2',
						esc_html__( "h3", "grve-blade-vc-extension" ) => 'h3',
						esc_html__( "h4", "grve-blade-vc-extension" ) => 'h4',
						esc_html__( "h5", "grve-blade-vc-extension" ) => 'h5',
						esc_html__( "h6", "grve-blade-vc-extension" ) => 'h6',
						esc_html__( "Leader Text", "grve-blade-vc-extension" ) => 'leader-text',
						esc_html__( "Subtitle Text", "grve-blade-vc-extension" ) => 'subtitle-text',
						esc_html__( "Small Text", "grve-blade-vc-extension" ) => 'small-text',
						esc_html__( "Link Text", "grve-blade-vc-extension" ) => 'link-text',
					),
					"description" => esc_html__( "Text size and typography", "grve-blade-vc-extension" ),
					"std" => 'small-text',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Numbers Color", "grve-blade-vc-extension" ),
					"param_name" => "numbers_color",
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
					'std' => 'black',
					"description" => esc_html__( "Color of the numbers.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Text Color", "grve-blade-vc-extension" ),
					"param_name" => "text_color",
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
					'std' => 'black',
					"description" => esc_html__( "Color of the text.", "grve-blade-vc-extension" ),
				),
				grve_blade_vce_add_animation(),
				grve_blade_vce_add_animation_delay(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_countdown', 'grve_blade_vce_countdown_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_countdown_shortcode_params( 'grve_countdown' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
