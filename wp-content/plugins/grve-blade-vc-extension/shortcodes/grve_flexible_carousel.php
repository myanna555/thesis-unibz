<?php
/**
 * Flexible Carousel Shortcode
 */

if( !function_exists( 'grve_blade_vce_flexible_carousel_shortcode' ) ) {

	function grve_blade_vce_flexible_carousel_shortcode( $attr, $content ) {

		$portfolio_row_start = $allow_filter = $class_fullwidth = $slider_data = $output = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'items_per_page' => '4',
					'items_tablet_landscape' => '4',
					'items_tablet_portrait' => '2',
					'items_mobile' => '1',
					'margin_bottom' => '',
					'slideshow_speed' => '3000',
					'pagination' => 'no',
					'pagination_type' => '1',
					'pagination_speed' => '400',
					'auto_play' => 'yes',
					'pause_hover' => 'no',
					'auto_height' => 'no',
					'item_gutter' => 'yes',
					'navigation_type' => '1',
					'navigation_color' => 'dark',
					'el_class' => '',
				),
				$attr
			)
		);

		$data_string = '';
		$data_string .= ' data-items="' . esc_attr( $items_per_page ) . '" data-tablet-landscape-items="' . esc_attr( $items_tablet_landscape ) . '" data-tablet-portrait-items="' . esc_attr( $items_tablet_portrait ) . '" data-mobile-items="' . esc_attr( $items_mobile ) . '"';
		$data_string .= ' data-slider-speed="' . esc_attr( $slideshow_speed ) . '"';
		$data_string .= ' data-pagination-speed="' . esc_attr( $pagination_speed ) . '"';
		$data_string .= ' data-pagination="' . esc_attr( $pagination ) . '"';
		$data_string .= ' data-slider-autoheight="' . esc_attr( $auto_height ) . '"';
		$data_string .= ' data-slider-pause="' . esc_attr( $pause_hover ) . '"';
		$data_string .= ' data-slider-autoplay="' . esc_attr( $auto_play ) . '"';


		//Carousel Element
		$flexible_carousel_classes = array( 'grve-element', 'grve-carousel-wrapper' );
		if ( 'yes' == $item_gutter ) {
			array_push( $flexible_carousel_classes, 'grve-with-gap' );
		}
		if ( 'yes' == $pagination ) {
			array_push( $flexible_carousel_classes, 'grve-carousel-pagination-' . $pagination_type  );
		}
		$flexible_carousel_class_string = implode( ' ', $flexible_carousel_classes );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$output = "";

		$output .= '<div class="' . esc_attr( $flexible_carousel_class_string ) . '" style="' . $style . '">';
		$output .= grve_blade_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );
		$output .= '	<div class="grve-flexible-carousel grve-carousel-element ' . esc_attr( $el_class ) . '"' . $data_string . '>';
		if ( !empty( $content ) ) {
			$output .= do_shortcode( $content );
		}
		$output .= '	</div>';
		$output .= '</div>';

		return $output;

	}
	add_shortcode( 'grve_flexible_carousel', 'grve_blade_vce_flexible_carousel_shortcode' );

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_grve_flexible_carousel extends WPBakeryShortCodesContainer {
    }
}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_flexible_carousel_shortcode_params' ) ) {
	function grve_blade_vce_flexible_carousel_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Flexible Carousel", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Add a flexible carousel with elements", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon" => "icon-wpb-grve-flexible-carousel",
			"category" => esc_html__( "Content", "js_composer" ),
			"content_element" => true,
			"controls" => "full",
			"show_settings_on_create" => true,
			"as_parent" => array('only' => 'vc_row,vc_column,vc_row_inner,vc_column_inner,vc_column_text,vc_custom_heading,vc_empty_space,grve_single_image,grve_button,grve_image_text,grve_team,grve_divider,grve_icon,grve_icon_box,grve_social,grve_callout,grve_slogan,grve_title'),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items per page", "grve-blade-vc-extension" ),
					"param_name" => "items_per_page",
					"value" => array( '1', '2', '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of items per page", "grve-blade-vc-extension" ),
					"std" => "4",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Items per page", "grve-blade-vc-extension" ),
					"param_name" => "items_tablet_landscape",
					"value" => array( '1', '2', '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of items per page on tablet devices, landscape orientation.", "grve-blade-vc-extension" ),
					"std" => "4",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Items per page", "grve-blade-vc-extension" ),
					"param_name" => "items_tablet_portrait",
					"value" => array( '1', '2', '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of items per page on tablet devices, landscape portrait.", "grve-blade-vc-extension" ),
					"std" => "2",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Items per page", "grve-blade-vc-extension" ),
					"param_name" => "items_mobile",
					"value" => array( '1', '2' ),
					"description" => esc_html__( "Number of items per page on mobile devices.", "grve-blade-vc-extension" ),
					"std" => "1",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Gutter between items", "grve-blade-vc-extension" ),
					"param_name" => "item_gutter",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"description" => esc_html__( "Add gutter among items.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "grve-blade-vc-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
				),
				grve_blade_vce_add_slideshow_speed(),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "grve-blade-vc-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, carousel will be paused on hover", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Pagination", "grve-blade-vc-extension" ),
					"param_name" => "pagination",
					"value" => array(
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
					),
					"std" => "no",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Pagination Type", "grve-blade-vc-extension" ),
					"param_name" => "pagination_type",
					'value' => array(
						esc_html__( 'Bullet' , 'grve-blade-vc-extension' ) => '1',
						esc_html__( 'Dashed' , 'grve-blade-vc-extension' ) => '2',
					),
					"description" => esc_html__( "Select your pagination type.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "pagination", 'value' => array( 'yes' ) ),
				),
				grve_blade_vce_add_pagination_speed(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Navigation Type", "grve-blade-vc-extension" ),
					"param_name" => "navigation_type",
					'value' => array(
						esc_html__( 'Style 1' , 'grve-blade-vc-extension' ) => '1',
						esc_html__( 'Style 2' , 'grve-blade-vc-extension' ) => '2',
						esc_html__( 'Style 3' , 'grve-blade-vc-extension' ) => '3',
						esc_html__( 'Style 4' , 'grve-blade-vc-extension' ) => '4',
						esc_html__( 'No Navigation' , 'grve-blade-vc-extension' ) => '0',
					),
					"description" => esc_html__( "Select your Navigation type.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Navigation Color", "grve-blade-vc-extension" ),
					"param_name" => "navigation_color",
					'value' => array(
						esc_html__( 'Dark' , 'grve-blade-vc-extension' ) => 'dark',
						esc_html__( 'Light' , 'grve-blade-vc-extension' ) => 'light',
					),
					"description" => esc_html__( "Select the background Navigation color.", "grve-blade-vc-extension" ),
				),
				grve_blade_vce_add_auto_height(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
			"js_view" => 'VcColumnView',
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_flexible_carousel', 'grve_blade_vce_flexible_carousel_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_flexible_carousel_shortcode_params( 'grve_flexible_carousel' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
