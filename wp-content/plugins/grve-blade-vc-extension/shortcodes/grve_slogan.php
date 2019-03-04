<?php
/**
 * Slogan Shortcode
 */

if( !function_exists( 'grve_blade_vce_slogan_shortcode' ) ) {

	function grve_blade_vce_slogan_shortcode( $atts, $content ) {

		$output = $data = $el_class = $text_style_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h2',
					'heading' => 'h2',
					'increase_heading' => '100',
					'line_type' => 'no-line',
					'line_width' => '50',
					'line_height' => '2',
					'line_color' => 'primary-1',
					'subtitle' => '',
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
					'button2_text' => '',
					'button2_link' => '',
					'button2_type' => 'simple',
					'button2_size' => 'medium',
					'button2_color' => 'primary-1',
					'button2_hover_color' => 'black',
					'button2_shape' => 'square',
					'button2_class' => '',
					'btn2_add_icon' => '',
					'btn2_icon_library' => 'fontawesome',
					'btn2_icon_fontawesome' => 'fa fa-adjust',
					'btn2_icon_openiconic' => 'vc-oi vc-oi-dial',
					'btn2_icon_typicons' => 'typcn typcn-adjust-brightness',
					'btn2_icon_entypo' => 'entypo-icon entypo-icon-note',
					'btn2_icon_linecons' => 'vc_li vc_li-heart',
					'btn2_icon_simplelineicons' => 'smp-icon-user',
					'btn2_aria_label' => '',
					'text_style' => 'none',
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

		//Title
		if ( !empty( $title ) ) {
			//Title Classes
			$title_classes = array( 'grve-slogan-title' );

			array_push( $title_classes, 'grve-align-' . $align );
			array_push( $title_classes, 'grve-' . $heading );

			$title_class_string = implode( ' ', $title_classes );
		}

		//Slogan
		$slogan_classes = array( 'grve-element', 'grve-slogan', 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $slogan_classes, 'grve-animated-item' );
			array_push( $slogan_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $slogan_classes, $el_class);
		}
		$slogan_class_string = implode( ' ', $slogan_classes );

		// Paragraph
		if ( 'none' != $text_style ) {
			$text_style_class = 'grve-' .$text_style;
		}

		//First Button
		$button1_options = array(
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
		);
		$button1 = grve_blade_vce_get_button( $button1_options );
		//Second Button
		$button2_options = array(
			'button_text'  => $button2_text,
			'button_link'  => $button2_link,
			'button_type'  => $button2_type,
			'button_size'  => $button2_size,
			'button_color' => $button2_color,
			'button_hover_color' => $button2_hover_color,
			'button_shape' => $button2_shape,
			'button_class' => $button2_class,
			'btn_add_icon' => $btn2_add_icon,
			'btn_icon_library' => $btn2_icon_library,
			'btn_icon_fontawesome' => $btn2_icon_fontawesome,
			'btn_icon_openiconic' => $btn2_icon_openiconic,
			'btn_icon_typicons' => $btn2_icon_typicons,
			'btn_icon_entypo' => $btn2_icon_entypo,
			'btn_icon_linecons' => $btn2_icon_linecons,
			'btn_icon_simplelineicons' => $btn2_icon_simplelineicons,
			'btn_aria_label' => $btn_aria_label,
		);
		$button2 = grve_blade_vce_get_button( $button2_options );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $slogan_class_string ) . '" style="' . $style. '"' . $data . '>';
		if ( !empty( $subtitle ) ) {
			$output .= '<div class="grve-subtitle">' . $subtitle . '</div>';
		}
		if ( !empty( $title ) ) {
			$output .= '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $title_class_string ) . '">';
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
		}
		if ( !empty( $content ) ) {
			$output .= '  <p class="' . esc_attr( $text_style_class ) . '">' . grve_blade_vce_unautop( $content ) . '</p>';
		}

		if ( !empty( $button1 ) || !empty( $button2 ) ) {
			$output .= '<div class="grve-btn-wrapper">';
			$output .= $button1;
			$output .= $button2;
			$output .= '</div>';
		}
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_slogan', 'grve_blade_vce_slogan_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_slogan_shortcode_params' ) ) {
	function grve_blade_vce_slogan_shortcode_params( $tag ) {

		$grve_blade_vce_slogan_shortcode_btn1_params = grve_blade_vce_get_button_params('first');
		$grve_blade_vce_slogan_shortcode_btn2_params = grve_blade_vce_get_button_params('second', '2');
		$grve_blade_vce_slogan_shortcode_params = array_merge(
			array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
					"param_name" => "title",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter your title here.", "grve-blade-vc-extension" ),
					"save_always" => true,
					"admin_label" => true,
				),
				grve_blade_vce_get_heading_tag( "h2" ),
				grve_blade_vce_get_heading( "h2" ),
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
					"description" => esc_html__( "Line Type of the title.", "grve-blade-vc-extension" ),
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
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Sub-Title", "grve-blade-vc-extension" ),
					"param_name" => "subtitle",
					"value" => "",
					"description" => esc_html__( "Enter your sub-title here.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "grve-blade-vc-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Type your text.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Text Style", "grve-blade-vc-extension" ),
					"param_name" => "text_style",
					"value" => array(
						esc_html__( "None", "grve-blade-vc-extension" ) => '',
						esc_html__( "Leader", "grve-blade-vc-extension" ) => 'leader-text',
						esc_html__( "Subtitle", "grve-blade-vc-extension" ) => 'subtitle',
					),
					"description" => 'Select your text style',
				),
				grve_blade_vce_add_align(),
				grve_blade_vce_add_animation(),
				grve_blade_vce_add_animation_delay(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
			$grve_blade_vce_slogan_shortcode_btn1_params,
			$grve_blade_vce_slogan_shortcode_btn2_params
		);

		return array(
			"name" => esc_html__( "Slogan", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Create easily appealing slogans", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-slogan",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => $grve_blade_vce_slogan_shortcode_params,
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_slogan', 'grve_blade_vce_slogan_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_slogan_shortcode_params( 'grve_slogan' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
