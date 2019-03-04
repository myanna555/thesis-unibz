<?php
/**
 * Dropcap Shortcode
 */

if( !function_exists( 'grve_blade_vce_dropcap_shortcode' ) ) {

	function grve_blade_vce_dropcap_shortcode( $atts, $content ) {

		$output = $style = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'dropcap_style' => '1',
					'color' => 'primary-1',
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

		$dropcap_classes = array( 'grve-element', 'grve-dropcap' );

		if ( !empty( $animation ) ) {
			array_push( $dropcap_classes, 'grve-animated-item' );
			array_push( $dropcap_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $dropcap_classes, $el_class);
		}
		$dropcap_class_string = implode( ' ', $dropcap_classes );

		if ( !empty( $content ) ) {

			$dropcap_char = mb_substr( $content, 0, 1, 'UTF8' );
			$dropcap_content = mb_substr( $content, 1, mb_strlen( $content ) , 'UTF8' );
			$output .= '<div class="' . esc_attr( $dropcap_class_string ) . '" style="' . $style . '"' . $data .'>';
			if ( '1' == $dropcap_style ) {
			$output .= '  <p><span class="grve-style-' . esc_attr( $dropcap_style ) . ' grve-text-' . esc_attr( $color ) . '">' . $dropcap_char . '</span>' . $dropcap_content . '</p>';
			} else {
			$output .= '  <p><span class="grve-style-' . esc_attr( $dropcap_style ) . ' grve-bg-' . esc_attr( $color ) . '">' . $dropcap_char . '</span>' . $dropcap_content . '</p>';
			}
			$output .= '</div>';

		}


		return $output;
	}
	add_shortcode( 'grve_dropcap', 'grve_blade_vce_dropcap_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_dropcap_shortcode_params' ) ) {
	function grve_blade_vce_dropcap_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Dropcap", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Two separate styles for your dropcaps", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-dropcap",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Style", "grve-blade-vc-extension" ),
					"param_name" => "dropcap_style",
					"value" => array(
						esc_html__( "Style 1", "grve-blade-vc-extension" ) => '1',
						esc_html__( "Style 2", "grve-blade-vc-extension" ) => '2',
					),
					"description" => esc_html__( "Style of the dropcap.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "grve-blade-vc-extension" ),
					"param_name" => "content",
					"value" => "Sample Text",
					"description" => esc_html__( "Type your dropcap text.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Dropcap Color", "grve-blade-vc-extension" ),
					"param_name" => "color",
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
					),
					"description" => esc_html__( "First character background color", "grve-blade-vc-extension" ),
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
	vc_lean_map( 'grve_dropcap', 'grve_blade_vce_dropcap_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_dropcap_shortcode_params( 'grve_dropcap' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
