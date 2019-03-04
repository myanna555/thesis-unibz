<?php
/**
 * Pricing Table Shortcode
 */

if( !function_exists( 'grve_blade_vce_pricing_table_shortcode' ) ) {

	function grve_blade_vce_pricing_table_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'description' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'price' => '',
					'interval' => '',
					'values' => '',
					'pricing_table_style' => 'style-1',
					'table_color' => 'grey',
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
					'bg_color' => '',
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

		//Pricing Table Classes
		$pricing_classes = array( 'grve-element', 'grve-pricing-table' );
		if ( !empty( $animation ) ) {
			array_push( $pricing_classes, 'grve-animated-item' );
			array_push( $pricing_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( !empty ( $el_class ) ) {
			array_push( $pricing_classes, $el_class);
		}

		array_push( $pricing_classes, 'grve-' . $pricing_table_style );

		$pricing_class_string = implode( ' ', $pricing_classes );

		//Pricing Lines
		$pricing_lines = explode(",", $values);

		$pricing_lines_data = array();
		foreach ($pricing_lines as $line) {
			$new_line = array();
			$data_line = explode("|", $line);
			$new_line['value1'] = isset( $data_line[0] ) && !empty( $data_line[0] ) ? $data_line[0] : '';
			$new_line['value2'] = isset( $data_line[1] ) && !empty( $data_line[1] ) ? $data_line[1] : '';
			$pricing_lines_data[] = $new_line;
		}

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . $pricing_class_string . '" style="' . $style . '"' . $data . '>';
		$output .= '  <div class="grve-pricing-header">';
		if ( 'style-1' == $pricing_table_style  ) {
			$output .= '    <div class="grve-subtitle grve-pricing-title grve-bg-' . esc_attr( $table_color ) . '">' . $title . '</div>';
			$output .= '    <' . tag_escape( $heading_tag ) . ' class="grve-price ' . esc_attr( $heading_class ) . ' grve-bg-' . esc_attr( $table_color ) . '">' . $price . ' <span>' . $interval . '</span></' . tag_escape( $heading_tag ) . '>';
		} else {
			$output .= '    <h5 class="grve-pricing-title">' . $title . '</h5>';
			$output .= '    <div class="grve-pricing-description">' . $description . '</div>';
			$output .= '    <div class="grve-pricing-content">';
			$output .= '      <' . tag_escape( $heading_tag ) . ' class="grve-price ' . esc_attr( $heading_class ) . ' grve-text-' . esc_attr( $table_color ) . '">' . $price . '<span>' . $interval . '</span></' . tag_escape( $heading_tag ) . '>';
			$output .= '    </div>';
		}
		$output .= '  </div>';
	    $output .= '  <ul>';
		foreach($pricing_lines_data as $line) {
			$output .= '<li><strong>' .  $line['value1'] . ' </strong>' .  $line['value2'] . '</li>';
		}
		$output .= '  </ul>';
		$output .= $button;
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_pricing_table', 'grve_blade_vce_pricing_table_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_pricing_table_shortcode_params' ) ) {
	function grve_blade_vce_pricing_table_shortcode_params( $tag ) {

		$grve_blade_vce_pricing_table_shortcode_btn_params = grve_blade_vce_get_button_params();
		$grve_blade_vce_pricing_table_shortcode_params = array_merge(
			array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Pricing Table Style", "grve-blade-vc-extension" ),
					"param_name" => "pricing_table_style",
					'value' => array(
						esc_html__( 'Style 1' , 'grve-blade-vc-extension' ) => 'style-1',
						esc_html__( 'Style 2' , 'grve-blade-vc-extension' ) => 'style-2',
					),
					"description" => esc_html__( "Select style for your pricing table.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
					"param_name" => "title",
					"value" => "Title",
					"save_always" => true,
					"description" => esc_html__( "Enter your title here.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Description", "grve-blade-vc-extension" ),
					"param_name" => "description",
					"value" => "Description",
					"save_always" => true,
					"description" => esc_html__( "Enter your description here.", "grve-blade-vc-extension" ),
					"admin_label" => true,
					"dependency" => array( 'element' => "pricing_table_style", 'value' => array( 'style-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Price Tag", "grve-blade-vc-extension" ),
					"param_name" => "heading_tag",
					"value" => array(
						esc_html__( "h1", "grve-blade-vc-extension" ) => 'h1',
						esc_html__( "h2", "grve-blade-vc-extension" ) => 'h2',
						esc_html__( "h3", "grve-blade-vc-extension" ) => 'h3',
						esc_html__( "h4", "grve-blade-vc-extension" ) => 'h4',
						esc_html__( "h5", "grve-blade-vc-extension" ) => 'h5',
						esc_html__( "h6", "grve-blade-vc-extension" ) => 'h6',
						esc_html__( "div", "grve-blade-vc-extension" ) => 'div',
					),
					"description" => esc_html__( "Price Tag for SEO", "grve-blade-vc-extension" ),
					"std" => "h3",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Price Size/Typography", "grve-blade-vc-extension" ),
					"param_name" => "heading",
					"admin_label" => true,
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
					"description" => esc_html__( "Price size and typography, defined in Theme Options - Typography Options", "grve-blade-vc-extension" ),
					"std" => "h3",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Price", "grve-blade-vc-extension" ),
					"param_name" => "price",
					"value" => "$0",
					"save_always" => true,
					"description" => esc_html__( "Enter your price here. eg $80.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Interval", "grve-blade-vc-extension" ),
					"param_name" => "interval",
					"value" => "/month",
					"save_always" => true,
					"description" => esc_html__( "Enter interval period here. e.g: /month, per month, per year.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "exploded_textarea",
					"heading" => __("Attributes", "grve-blade-vc-extension"),
					"param_name" => "values",
					"description" => esc_html__( "Input attribute values. Divide values with linebreaks (Enter). Example: 100|Users.", "grve-blade-vc-extension" ),
					"value" => "100|Users,8 Gig|Disc Space,Unlimited|Data Transfer",
					"save_always" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Pricing Table Color", "grve-blade-vc-extension" ),
					"param_name" => "table_color",
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
					'std' => 'grey',
				),
				grve_blade_vce_add_animation(),
				grve_blade_vce_add_animation_delay(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
			$grve_blade_vce_pricing_table_shortcode_btn_params
		);

		return array(
			"name" => esc_html__( "Pricing Table", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Stylish pricing tables", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-pricing-table",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => $grve_blade_vce_pricing_table_shortcode_params,
		);

	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_pricing_table', 'grve_blade_vce_pricing_table_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_pricing_table_shortcode_params( 'grve_pricing_table' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
