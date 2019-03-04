<?php
/**
 * Progress Bar Shortcode
 */

if( !function_exists( 'grve_blade_vce_progress_bar_shortcode' ) ) {

	function grve_blade_vce_progress_bar_shortcode( $atts, $content ) {

		$output = $style = $bar_height_style = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'bar_style' => 'style-1',
					'values' => '',
					'bar_line_style' => 'square',
					'bar_height' => '35',
					'color' => 'primary-1',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$bars_classes = array( 'grve-element', 'grve-progress-bars' );
		array_push( $bars_classes, 'grve-' . $bar_style );
		array_push( $bars_classes, 'grve-line-' . $bar_line_style );

		$bars_class_string = implode( ' ', $bars_classes );

		if( !empty( $bar_height ) && 'style-2' == $bar_style ) {
			$bar_height_style .= 'height: '.(preg_match('/(px|em|\%|pt|cm)$/', $bar_height) ? $bar_height : $bar_height.'px').';';
		}

		$style .= grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$graph_lines = explode(",", $values);

		$graph_lines_data = array();
		foreach ($graph_lines as $line) {
			$new_line = array();
			$data = explode("|", $line);
			$new_line['value'] = isset( $data[0] ) && !empty( $data[0] ) ? $data[0] : 0;
			$new_line['percentage_value'] = isset( $data[1] ) && !empty( $data[1] ) ? $data[1] : '';
			$new_line['color'] = isset( $data[2] ) && !empty( $data[2] ) ? $data[2] : $color;

			if( (float)$new_line['value'] < 0 ) {
				$new_line['value'] = 0;
			} else if ( (float)$new_line['value'] > 100 ) {
				$new_line['value'] = 100;
			}

			$new_line['label'] = $new_line['percentage_value'];

			$graph_lines_data[] = $new_line;
		}

		$output .= '<div class="' . esc_attr( $bars_class_string ) . '" style="' . $style . '">';

		foreach($graph_lines_data as $line) {

			$color_class = 'grve-primary';
			if ( 'primary' != $line['color'] ) {
				$color_class = 'grve-bg-' . $line['color'];
			}

			$output .= '<div class="grve-element grve-progress-bar grve-margin-10" data-value="' .  esc_attr( $line['value'] ) . '">';
			$output .= '  <div class="grve-small-text grve-bar-title">' .  $line['label'] . '</div>';
			$output .= '  <div class="grve-bar">';
			$output .= '    <div class="grve-bar-line ' .  esc_attr( $color_class ) . '" style="' . $bar_height_style . '"></div>';
			$output .= '  </div>';
			$output .= '</div>';

		}

		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_progress_bar', 'grve_blade_vce_progress_bar_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_progress_bar_shortcode_params' ) ) {
	function grve_blade_vce_progress_bar_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Progress Bar", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Create horizontal progress bar", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-progress-bar",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Progress Bar Style", "grve-blade-vc-extension" ),
					"param_name" => "bar_style",
					"value" => array(
						esc_html__( "Style 1", "grve-blade-vc-extension" ) => 'style-1',
						esc_html__( "Style 2", "grve-blade-vc-extension" ) => 'style-2',
					),
					"description" => esc_html__( "Style of the bar line.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "exploded_textarea",
					"heading" => __("Bar values", "grve-blade-vc-extension"),
					"param_name" => "values",
					"description" => esc_html__( "Input bar values here. Divide values with linebreaks (Enter). Example: 90|Development|black.", "grve-blade-vc-extension" ) . '<br/>' .
									esc_html__( "Available colors: primary-1, green, orange, red, blue, aqua, purple, black, white.", "grve-blade-vc-extension" ),
					"value" => "90|Development,80|Design,70|Marketing",
					"save_always" => true,
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Bars Color", "grve-blade-vc-extension" ),
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
					"description" => esc_html__( "Use single color for all bars ( If not specified in Bar values )", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Progress Bar Height", "grve-blade-vc-extension" ),
					"param_name" => "bar_height",
					"value" => "35",
					"description" => esc_html__( "Enter progress bar height.", "grve-blade-vc-extension" ),
					"admin_label" => true,
					"dependency" => array( 'element' => "bar_style", 'value' => array( 'style-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Bars Line Style", "grve-blade-vc-extension" ),
					"param_name" => "bar_line_style",
					"value" => array(
						esc_html__( "Square", "grve-blade-vc-extension" ) => 'square',
						esc_html__( "Round", "grve-blade-vc-extension" ) => 'round',
					),
					"description" => esc_html__( "Style of the bar line.", "grve-blade-vc-extension" ),
				),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_progress_bar', 'grve_blade_vce_progress_bar_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_progress_bar_shortcode_params( 'grve_progress_bar' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
