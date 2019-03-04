<?php
/**
 * Slider Shortcode
 */

if( !function_exists( 'grve_blade_vce_slider_shortcode' ) ) {

	function grve_blade_vce_slider_shortcode( $attr, $content ) {

		$output = $class_fullwidth = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'ids' => '',
					'image_mode' => 'resize',
					'image_link_mode' => 'none',
					'image_popup_size' => 'extra-extra-large',
					'custom_links' => '',
					'custom_links_target' => '_self',
					'slideshow_speed' => '3500',
					'navigation_type' => '1',
					'navigation_color' => 'dark',
					'pause_hover' => 'no',
					'auto_play' => 'yes',
					'auto_height' => 'no',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$attr
			)
		);

		$attachments = explode( ",", $ids );

		if ( empty( $attachments ) ) {
			return '';
		}

		$image_size = 'blade-grve-fullscreen';
		if ( 'autocrop' == $image_mode ) {
			$image_size = 'blade-grve-large-rect-horizontal';
		} elseif ( 'landscape-wide' == $image_mode ) {
			$image_size = 'blade-grve-small-rect-horizontal-wide';
		} elseif ( 'large' == $image_mode ) {
			$image_size = 'large';
		}

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$slider_data = '';
		$slider_data .= ' data-slider-speed="' . esc_attr( $slideshow_speed ) . '"';
		$slider_data .= ' data-slider-pause="' . esc_attr( $pause_hover ) . '"';
		$slider_data .= ' data-slider-autoplay="' . esc_attr( $auto_play ) . '"';
		$slider_data .= ' data-slider-autoheight="' . esc_attr( $auto_height ) . '"';

		$output .= '<div class="grve-element grve-carousel-wrapper"  style="' . $style . ' ">';

		//Slider Navigation
		$output .= grve_blade_vce_element_navigation( $navigation_type, $navigation_color );

		//Slider Classes
		$slider_classes = array( 'grve-slider' , 'grve-carousel-element' );
		if ( 'custom_link' == $image_link_mode ) {
			$custom_links = vc_value_from_safe( $custom_links );
			$custom_links = explode( ',', $custom_links );
		} elseif ( 'popup' == $image_link_mode ) {
			array_push( $slider_classes, 'grve-gallery-popup' );
		}
		if ( !empty( $el_class ) ) {
			array_push( $slider_classes, $el_class);
		}
		$slider_class_string = implode( ' ', $slider_classes );

		$image_popup_size_mode = grve_blade_vce_get_image_size( $image_popup_size );

		$output .= '<div class="' . esc_attr( $slider_class_string ) . '"' . $slider_data . '>';

		$i = -1;
		foreach ( $attachments as $id ) {

			$i++;
			$full_src = wp_get_attachment_image_src( $id, $image_popup_size_mode );

			$output .= '<div class="grve-slider-item">';
			if ( 'popup' == $image_link_mode ) {
				$output .= '<a href="' . esc_url( $full_src[0] ) . '">';
			} elseif ( 'custom_link' == $image_link_mode && isset( $custom_links[ $i ] ) && !empty(  $custom_links[ $i ] )  ) {
				$output .= '<a href="' . esc_url( $custom_links[ $i ] ) . '" target="' . esc_attr( $custom_links_target ) . '">';
			}
			$output .= '<figure>';
			$output .= '<div class="grve-media">';
			$output .= wp_get_attachment_image( $id, $image_size );
			$output .= '</div>';
			$output .= '</figure>';
			if ( 'popup' == $image_link_mode ) {
				$output .= '</a>';
			} elseif ( 'custom_link' == $image_link_mode && isset( $custom_links[ $i ] ) && !empty(  $custom_links[ $i ] )  ) {
				$output .= '</a>';
			}
			$output .= '</div>';
		}
		$output .= '</div>';
		$output .= '</div>';

		return $output;

	}
	add_shortcode( 'grve_slider', 'grve_blade_vce_slider_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_slider_shortcode_params' ) ) {
	function grve_blade_vce_slider_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Slider", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Create a simple slider", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-slider",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type"			=> "attach_images",
					"admin_label"	=> true,
					"class"			=> "",
					"heading"		=> esc_html__( "Attach Images", "grve-blade-vc-extension" ),
					"param_name"	=> "ids",
					"value" => '',
					"description"	=> esc_html__( "Select your slider images.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Mode", "grve-blade-vc-extension" ),
					"param_name" => "image_mode",
					'value' => array(
						esc_html__( 'Resize ( Fullscreen )', 'grve-blade-vc-extension' ) => 'resize',
						esc_html__( 'Resize ( Large )', 'grve-blade-vc-extension' ) => 'large',
						esc_html__( 'Landscape Wide Large', 'grve-blade-vc-extension' ) => 'autocrop',
						esc_html__( 'Landscape Wide', 'grve-blade-vc-extension' ) => 'landscape-wide',
					),
					"description" => esc_html__( "Select your slider image mode.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Image Link Mode", "grve-blade-vc-extension" ),
					"param_name" => "image_link_mode",
					"value" => array(
						esc_html__( "None", "grve-blade-vc-extension" ) => 'none',
						esc_html__( "Image Popup", "grve-blade-vc-extension" ) => 'popup',
						esc_html__( "Custom Link", "grve-blade-vc-extension" ) => 'custom_link',
					),
					"description" => esc_html__( "Choose the image link mode.", "grve-blade-vc-extension" ),
					'std' => 'none',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Popup Size", "grve-blade-vc-extension" ),
					"param_name" => "image_popup_size",
					'value' => array(
						esc_html__( 'Large' , 'grve-blade-vc-extension' ) => 'large',
						esc_html__( 'Extra Extra Large' , 'grve-blade-vc-extension' ) => 'extra-extra-large',
						esc_html__( 'Full' , 'grve-blade-vc-extension' ) => 'full',
					),
					"dependency" => array( 'element' => "image_link_mode", 'value' => array( 'popup' ) ),
					"description" => esc_html__( "Select size for your popup image.", "grve-blade-vc-extension" ),
					"std" => 'extra-extra-large',
				),
				array(
					'type' => 'exploded_textarea_safe',
					'heading' => __( 'Custom links', 'grve-blade-vc-extension' ),
					'param_name' => 'custom_links',
					'description' => __( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'grve-blade-vc-extension' ),
					'dependency' => array(
						'element' => 'image_link_mode',
						'value' => array( 'custom_link' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Custom link target', 'grve-blade-vc-extension' ),
					'param_name' => 'custom_links_target',
					'description' => __( 'Select where to open custom links.', 'grve-blade-vc-extension' ),
					'dependency' => array(
						'element' => 'image_link_mode',
						'value' => array( 'custom_link' ),
					),
					"value" => array(
						esc_html__( "Same Window", "grve-blade-vc-extension" ) => '_self',
						esc_html__( "New Window", "grve-blade-vc-extension" ) => '_blank',
					),
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
					"value" => array( esc_html__( "If selected, slider will be paused on hover", "grve-blade-vc-extension" ) => 'yes' ),
				),
				grve_blade_vce_add_auto_height(),
				grve_blade_vce_add_navigation_type(),
				grve_blade_vce_add_navigation_color(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_slider', 'grve_blade_vce_slider_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_slider_shortcode_params( 'grve_slider' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
