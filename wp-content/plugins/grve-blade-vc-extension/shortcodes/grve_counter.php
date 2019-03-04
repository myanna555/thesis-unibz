<?php
/**
 * Counter Shortcode
 */

if( !function_exists( 'grve_blade_vce_counter_shortcode' ) ) {

	function grve_blade_vce_counter_shortcode( $atts, $content ) {

		$output = $link_start = $link_end = $retina_data = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'counter_start_val' => '0',
					'counter_end_val' => '100',
					'counter_prefix' => '',
					'counter_suffix' => '',
					'counter_decimal_points' => '0',
					'counter_decimal_separator' => '.',
					'counter_color' => 'primary-1',
					'counter_size' => 'small',
					'counter_thousands_separator_vis' => '',
					'counter_thousands_separator' => ',',
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'icon_library' => 'fontawesome',
					'icon_fontawesome' => 'fa fa-adjust',
					'icon_openiconic' => 'vc-oi vc-oi-dial',
					'icon_typicons' => 'typcn typcn-adjust-brightness',
					'icon_entypo' => 'entypo-icon entypo-icon-note',
					'icon_linecons' => 'vc_li vc_li-heart',
					'icon_simplelineicons' => 'smp-icon-user',
					'icon_type' => '',
					'icon_size' => 'medium',
					'icon_color' => 'primary-1',
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
		$counter_classes = array( 'grve-element' );

		array_push( $counter_classes, 'grve-counter' );
		array_push( $counter_classes, 'grve-align-center' );

		if ( !empty( $animation ) ) {
			array_push( $counter_classes, 'grve-animated-item' );
			array_push( $counter_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $counter_classes, $el_class);
		}

		$counter_class_string = implode( ' ', $counter_classes );


		$icon_classes = array();

		if ( 'icon' == $icon_type ) {

			$icon_class = isset( ${"icon_" . $icon_library} ) ? esc_attr( ${"icon_" . $icon_library} ) : 'fa fa-adjust';
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				vc_icon_element_fonts_enqueue( $icon_library );
			}
			array_push( $icon_classes, $icon_class );
			array_push( $icon_classes, 'grve-text-' . $icon_color );
			array_push( $icon_classes, 'grve-' . $icon_size );
		}

		$icon_class_string = implode( ' ', $icon_classes );


		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );


		$output .= '<div class="' . esc_attr( $counter_class_string ) . '" style="' . $style . '"' . $data . '>';

		if ( 'icon' == $icon_type ) {
			$output .= '  <div class="grve-counter-icon">';
			$output .= '  <i class="' . esc_attr( $icon_class_string ) . '"></i>';
			$output .= '  </div>';
		}

		$output .= '  <div class="grve-counter-content">';
		$output .= '    <div class="grve-counter-item grve-text-' . esc_attr( $counter_color ) . ' grve-' . esc_attr( $counter_size ) . '">';
		$output .= '      <span data-thousands-separator-vis="' . esc_attr( $counter_thousands_separator_vis ) . '" data-thousands-separator="' . esc_attr( $counter_thousands_separator ) . '" data-prefix="' . esc_attr( $counter_prefix ) . '" data-suffix="' . esc_attr( $counter_suffix ) . '" data-start-val="' . esc_attr( $counter_start_val ) . '" data-end-val="' . esc_attr( $counter_end_val ) . '" data-decimal-points="' . esc_attr( $counter_decimal_points ) . '" data-decimal-separator="' . esc_attr( $counter_decimal_separator ) . '">' . $counter_start_val. '</span>';
		$output .= '    </div>';
		$output .= '	<' . tag_escape( $heading_tag ) . ' class="grve-counter-title ' . esc_attr( $heading_class ) . '">' . $title. '</' . tag_escape( $heading_tag ) . '>';
		$output .= '  </div>';

		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_counter', 'grve_blade_vce_counter_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_counter_shortcode_params' ) ) {
	function grve_blade_vce_counter_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Counter", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Add a counter with icon and title", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-counter",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Start Number", "grve-blade-vc-extension" ),
					"param_name" => "counter_start_val",
					"value" => "0",
					"description" => esc_html__( "Enter counter start number.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter End Number", "grve-blade-vc-extension" ),
					"param_name" => "counter_end_val",
					"value" => "100",
					"description" => esc_html__( "Enter counter end number.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Counter Thousands Separator Visiblility", "grve-blade-vc-extension" ),
					"param_name" => "counter_thousands_separator_vis",
					"description" => esc_html__( "If selected, thousands separator will not be shown.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Disable Thousands Separator.", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Thousands Separator", "grve-blade-vc-extension" ),
					"param_name" => "counter_thousands_separator",
					"value" => ",",
					"description" => esc_html__( "Enter thousands separator.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Decimal Points", "grve-blade-vc-extension" ),
					"param_name" => "counter_decimal_points",
					"value" => "0",
					"description" => esc_html__( "Number of decimal points.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Decimal Separator", "grve-blade-vc-extension" ),
					"param_name" => "counter_decimal_separator",
					"value" => ".",
					"description" => esc_html__( "Enter decimal separator.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Prefix", "grve-blade-vc-extension" ),
					"param_name" => "counter_prefix",
					"value" => "",
					"description" => esc_html__( "Enter counter prefix.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Counter Suffix", "grve-blade-vc-extension" ),
					"param_name" => "counter_suffix",
					"value" => "",
					"description" => esc_html__( "Enter counter suffix.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Counter Color", "grve-blade-vc-extension" ),
					"param_name" => "counter_color",
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
					"description" => esc_html__( "Color of the counter.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Counter Text Size", "grve-blade-vc-extension" ),
					"param_name" => "counter_size",
					"value" => array(
						esc_html__( "Small", "grve-blade-vc-extension" ) => 'small',
						esc_html__( "Medium", "grve-blade-vc-extension" ) => 'medium',
						esc_html__( "Large", "grve-blade-vc-extension" ) => 'large',
					),
					"description" => esc_html__( "Select counter text size.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon type", "grve-blade-vc-extension" ),
					"param_name" => "icon_type",
					"value" => array(
						esc_html__( "No Icon", "grve-blade-vc-extension" ) => '',
						esc_html__( "Icon", "grve-blade-vc-extension" ) => 'icon',
					),
					"description" => '',
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon size", "grve-blade-vc-extension" ),
					"param_name" => "icon_size",
					"value" => array(
						esc_html__( "Large", "grve-blade-vc-extension" ) => 'large',
						esc_html__( "Medium", "grve-blade-vc-extension" ) => 'medium',
						esc_html__( "Small", "grve-blade-vc-extension" ) => 'small',
					),
					"std" => 'medium',
					"description" => '',
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon' ) ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon library', 'grve-blade-vc-extension' ),
					'value' => array(
						esc_html__( 'Font Awesome', 'grve-blade-vc-extension' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'grve-blade-vc-extension' ) => 'openiconic',
						esc_html__( 'Typicons', 'grve-blade-vc-extension' ) => 'typicons',
						esc_html__( 'Entypo', 'grve-blade-vc-extension' ) => 'entypo',
						esc_html__( 'Linecons', 'grve-blade-vc-extension' ) => 'linecons',
						esc_html__( 'Simple Line Icons', 'grve-blade-vc-extension' ) => 'simplelineicons',
					),
					'param_name' => 'icon_library',
					'description' => esc_html__( 'Select icon library.', 'grve-blade-vc-extension' ),
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon' ) ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
					'param_name' => 'icon_fontawesome',
					'value' => 'fa fa-info-circle',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'fontawesome',
					),
					'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
					'param_name' => 'icon_openiconic',
					'value' => 'vc-oi vc-oi-dial',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'openiconic',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'openiconic',
					),
					'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
					'param_name' => 'icon_typicons',
					'value' => 'typcn typcn-adjust-brightness',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'typicons',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'typicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
					'param_name' => 'icon_entypo',
					'value' => 'entypo-icon entypo-icon-note',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'entypo',
						'iconsPerPage' => 300, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'entypo',
					),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
					'param_name' => 'icon_linecons',
					'value' => 'vc_li vc_li-heart',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'linecons',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'linecons',
					),
					'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
					'param_name' => 'icon_simplelineicons',
					'value' => 'smp-icon-user',
					'settings' => array(
						'emptyIcon' => false, // default true, display an "EMPTY" icon?
						'type' => 'simplelineicons',
						'iconsPerPage' => 200, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value' => 'simplelineicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon Color", "grve-blade-vc-extension" ),
					"param_name" => "icon_color",
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
					"description" => esc_html__( "Color of the icon.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
					"param_name" => "title",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter counter title.", "grve-blade-vc-extension" ),
					"save_always" => true,
					"admin_label" => true,
				),
				grve_blade_vce_get_heading_tag( "h3" ),
				grve_blade_vce_get_heading( "h3" ),
				grve_blade_vce_add_animation(),
				grve_blade_vce_add_animation_delay(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_counter', 'grve_blade_vce_counter_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_counter_shortcode_params( 'grve_counter' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
