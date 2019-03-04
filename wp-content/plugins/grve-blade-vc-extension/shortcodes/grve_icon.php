<?php
/**
 * Icon Shortcode
 */

if( !function_exists( 'grve_blade_vce_icon_shortcode' ) ) {

	function grve_blade_vce_icon_shortcode( $atts, $content ) {

		$output = $link_start = $link_end = $retina_data = $text_style_class = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'icon_library' => 'fontawesome',
					'icon_fontawesome' => 'fa fa-adjust',
					'icon_openiconic' => 'vc-oi vc-oi-dial',
					'icon_typicons' => 'typcn typcn-adjust-brightness',
					'icon_entypo' => 'entypo-icon entypo-icon-note',
					'icon_linecons' => 'vc_li vc_li-heart',
					'icon_simplelineicons' => 'smp-icon-user',
					'icon_size' => 'medium',
					'icon_shape' => 'no-shape',
					'shape_type' => 'simple',
					'icon_color' => 'primary-1',
					'icon_shape_color' => 'grey',
					'icon_animation' => 'no',
					'align' => 'left',
					'icon_hover_effect' => 'no',
					'link' => '',
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

		$icon_element_classes = array( 'grve-element' );

		array_push( $icon_element_classes, 'grve-single-icon' );
		array_push( $icon_element_classes, 'grve-align-' . $align );
		array_push( $icon_element_classes, 'grve-' . $icon_size );

		if ( !empty( $animation ) ) {
			array_push( $icon_element_classes, 'grve-animated-item' );
			array_push( $icon_element_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $icon_element_classes, $el_class);
		}

		if( 'yes' == $icon_hover_effect && 'no-shape' != $icon_shape ) {
			array_push( $icon_element_classes, 'grve-hover-effect' );
		}

		$icon_wrapper_classes = array( 'grve-wrapper-icon' );
		$icon_classes = array();

		if ( 'no-shape' != $icon_shape ) {
			array_push( $icon_wrapper_classes, 'grve-' . $shape_type );
			array_push( $icon_element_classes, 'grve-with-shape' );
		}
		array_push( $icon_wrapper_classes, 'grve-' . $icon_shape );

		if ( 'no-shape' != $icon_shape && 'outline' != $shape_type ) {
			array_push( $icon_wrapper_classes, 'grve-bg-' . $icon_shape_color );
		} else {
			array_push( $icon_wrapper_classes, 'grve-text-' . $icon_shape_color );
		}

		$icon_class = isset( ${"icon_" . $icon_library} ) ? esc_attr( ${"icon_" . $icon_library} ) : 'fa fa-adjust';
		if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
			vc_icon_element_fonts_enqueue( $icon_library );
		}
		array_push( $icon_classes, $icon_class );
		array_push( $icon_classes, 'grve-text-' . $icon_color );

		$icon_element_class_string = implode( ' ', $icon_element_classes );
		$icon_wrapper_class_string = implode( ' ', $icon_wrapper_classes );
		$icon_class_string = implode( ' ', $icon_classes );


		if ( !empty( $link ) ){
			$href = vc_build_link( $link );
			$url = $href['url'];
			if ( !empty( $href['target'] ) ){
				$target = $href['target'];
			} else {
				$target= "_self";
			}
		} else {
			$url = "#";
			$target= "_self";
		}
		$target = trim( $target );
		
		if ( !empty( $url ) && '#' != $url ) {
			$link_start = '<a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '">';
			$link_end = '</a>';
		}

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $icon_element_class_string ) . '" style="' . $style . '"' . $data . '>';
		$output .= $link_start;
		$output .= '  <div class="' . esc_attr( $icon_wrapper_class_string ) . '"><i class="'. esc_attr( $icon_class_string ) . '"></i></div>';
		$output .= $link_end;
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_icon', 'grve_blade_vce_icon_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_icon_shortcode_params' ) ) {
	function grve_blade_vce_icon_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Icon", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Add an icon", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-icon",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
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
				),
				grve_blade_vce_add_align(),
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
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon shape", "grve-blade-vc-extension" ),
					"param_name" => "icon_shape",
					"value" => array(
						esc_html__( "None", "grve-blade-vc-extension" ) => 'no-shape',
						esc_html__( "Square", "grve-blade-vc-extension" ) => 'square',
						esc_html__( "Round", "grve-blade-vc-extension" ) => 'round',
						esc_html__( "Circle", "grve-blade-vc-extension" ) => 'circle',
					),
					"description" => '',
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Shape type", "grve-blade-vc-extension" ),
					"param_name" => "shape_type",
					"value" => array(
						esc_html__( "Simple", "grve-blade-vc-extension" ) => 'simple',
						esc_html__( "Outline", "grve-blade-vc-extension" ) => 'outline',
					),
					"description" => esc_html__( "Select shape type.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon Shape Color", "grve-blade-vc-extension" ),
					"param_name" => "icon_shape_color",
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
					'std' => 'grey',
					"description" => esc_html__( "This affects to the Background of the simple shape type. Alternatively, affects to the line shape type.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Hover Effect", "grve-blade-vc-extension" ),
					"param_name" => "icon_hover_effect",
					"value" => array( esc_html__( "If selected, you will have hover effect.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Link", "grve-blade-vc-extension" ),
					"param_name" => "link",
					"value" => "",
					"description" => esc_html__( "Enter link.", "grve-blade-vc-extension" ),
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
	vc_lean_map( 'grve_icon', 'grve_blade_vce_icon_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_icon_shortcode_params( 'grve_icon' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
