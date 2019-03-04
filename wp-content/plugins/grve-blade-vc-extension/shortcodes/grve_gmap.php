<?php
/**
 * Google Map Shortcode
 */

if( !function_exists( 'grve_blade_vce_gmap_shortcode' ) ) {

	function grve_blade_vce_gmap_shortcode( $atts, $content ) {
		$output = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'map_lat' => '51.516221',
					'map_lng' => '-0.136986',
					'map_height' => '280',
					'map_marker' => '',
					'map_zoom' => 14,
					'map_disable_style' => 'no',
					'margin_bottom' => '',
					'el_class' => '',
					'map_mode' => '',
					'map_points' => '',
				),
				$atts
			)
		);

		wp_enqueue_script( 'blade-grve-googleapi-script');
		wp_enqueue_script( 'blade-grve-maps-script');

		$gmap_classes = array( 'grve-element', 'grve-map' );

		if ( !empty ( $el_class ) ) {
			array_push( $gmap_classes, $el_class );
		}
		$gmap_class_string = implode( ' ', $gmap_classes );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );
		if ( empty( $map_marker ) ) {
			$map_marker = get_template_directory_uri() . '/images/markers/markers.png';
		} else {
			$id = preg_replace('/[^\d]/', '', $map_marker);
			$full_src = wp_get_attachment_image_src( $id, 'full' );
			$map_marker = $full_src[0];
		}

		$map_title = '';
		$values = (array) vc_param_group_parse_atts( $map_points );
		
		if ( !empty( $map_mode ) && !empty( $values )  ) {
			$map_lat = grve_blade_vce_array_value( $values[0], 'lat', '51.516221' );
			$map_lng = grve_blade_vce_array_value( $values[0], 'lng', '-0.136986' );
		}

		$data_map = 'data-lat="' . esc_attr( $map_lat ) . '" data-lng="' . esc_attr( $map_lng ) . '" data-zoom="' . esc_attr( $map_zoom ) . '" data-disable-style="' . esc_attr( $map_disable_style ) . '"';
		$output .= '<div class="grve-map-wrapper">';
		$output .= '  <div class="' . esc_attr( $gmap_class_string ) . '" ' . $data_map . ' style="' . $style . grve_blade_vce_build_dimension( 'height', $map_height ) . '"></div>';

		if ( empty( $map_mode ) ) {
			$output .= '  <div style="display:none" class="grve-map-point" data-point-lat="' . esc_attr( $map_lat ) . '" data-point-lng="' . esc_attr( $map_lng ) . '" data-point-marker="' . esc_attr( $map_marker ) . '" data-point-title="' . esc_attr( $map_title ) . '"></div>';
		} else {
			if( !empty( $values ) ) {
				foreach ( $values as $k => $v ) {

					$point_lat = isset( $v['lat'] ) ? $v['lat'] : '51.516221';
					$point_lng = isset( $v['lng'] ) ? $v['lng'] : '-0.136986';
					$point_marker = isset( $v['marker'] ) ? $v['marker'] : '';
					$point_title = isset( $v['title'] ) ? $v['title'] : '';
					$point_infotext = isset( $v['infotext'] ) ? $v['infotext'] : '';
					$point_infotext_open = isset( $v['infotext_open'] ) ? $v['infotext_open'] : 'no';
					$point_link_text = isset( $v['link_text'] ) ? $v['link_text'] : '';
					$point_link = isset( $v['link'] ) ? $v['link'] : '';
					$point_link_class = isset( $v['link_class'] ) ? 'grve-infotext-link ' . $v['link_class'] : 'grve-infotext-link';

					if ( empty( $point_marker ) ) {
						$point_marker = $map_marker;
					} else {
						$id = preg_replace('/[^\d]/', '', $point_marker);
						$full_src = wp_get_attachment_image_src( $id, 'full' );
						$point_marker = $full_src[0];
					}
					$output .= '<div style="display:none" class="grve-map-point" data-point-lat="' . esc_attr( $point_lat ) . '" data-point-lng="' . esc_attr( $point_lng ) . '" data-point-marker="' . esc_attr( $point_marker ) . '" data-point-title="' . esc_attr( $point_title ) . '" data-point-open="' . esc_attr( $point_infotext_open ) . '">';
					if ( !empty( $point_title ) || !empty( $point_infotext ) || !empty( $point_link_text ) ) {
						$output .= '<div class="grve-map-infotext">';
						if ( !empty( $point_title ) ) {
							$output .= '<h6 class="grve-infotext-title">' . esc_html( $point_title ) . '</h6>';
						}
						if ( !empty( $point_infotext ) ) {
							$output .= '<p class="grve-infotext-description">' . wp_kses_post( $point_infotext ) . '</p>';
						}
						if ( !empty( $point_link_text ) && grve_blade_vce_has_link ( $point_link ) ) {
							$link_attributes = grve_blade_vce_get_link_attributes( $point_link, $point_link_class );
							$output .= '<a ' . implode( ' ', $link_attributes ) . '>';
							$output .= esc_html( $point_link_text );
							$output .= '</a>';
						}
						$output .= '</div>';
					}
					$output .= '</div>';
				}
			}
		}
		$output .= '</div>';


		return $output;
	}
	add_shortcode( 'grve_gmap', 'grve_blade_vce_gmap_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_gmap_shortcode_params' ) ) {
	function grve_blade_vce_gmap_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Google Map", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Freely place your Google Map", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-gmap",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Map Zoom", "grve-blade-vc-extension" ),
					"param_name" => "map_zoom",
					"value" => array( 1, 2, 3 ,4, 5, 6, 7, 8 ,9 ,10 ,11 ,12, 13, 14, 15, 16, 17, 18, 19 ),
					"std" => 14,
					"description" => esc_html__( "Zoom of the map.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Height", "grve-blade-vc-extension" ),
					"param_name" => "map_height",
					"value" => "280",
					"description" => esc_html__( "Type map height.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Disable Custom Style", "grve-blade-vc-extension" ),
					"param_name" => "map_disable_style",
					"value" => array(
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
					),
					"description" => esc_html__( "Select if you want to disable custom map style.", "grve-blade-vc-extension" ),
				),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Map Mode", "grve-blade-vc-extension" ),
					"param_name" => "map_mode",
					"value" => array(
						esc_html__( "Single Marker", "grve-blade-vc-extension" ) => '',
						esc_html__( "Multiple Markers", "grve-blade-vc-extension" ) => 'multiple',
					),
					"description" => esc_html__( "Select if you want to disable custom map style.", "grve-blade-vc-extension" ),
					"group" => esc_html__( "Map Points", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Global Custom marker", "grve-blade-vc-extension" ),
					"param_name" => "map_marker",
					"value" => '',
					"description" => esc_html__( "Select an icon for the custom marker.", "grve-blade-vc-extension" ),
					"group" => esc_html__( "Map Points", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Latitude", "grve-blade-vc-extension" ),
					"param_name" => "map_lat",
					"value" => "51.516221",
					"description" => esc_html__( "Type map Latitude.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "map_mode", 'value' => array( '' ) ),
					"group" => esc_html__( "Map Points", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Longtitude", "grve-blade-vc-extension" ),
					"param_name" => "map_lng",
					"value" => "-0.136986",
					"description" => esc_html__( "Type map Longtitude.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "map_mode", 'value' => array( '' ) ),
					"group" => esc_html__( "Map Points", "grve-blade-vc-extension" ),
				),
				array(
					'type' => 'param_group',
					'param_name' => 'map_points',
					'heading' => esc_html__( "Map Points", "grve-blade-vc-extension" ),
					"description" => esc_html__( "Configure your map points.", "grve-blade-vc-extension" ),
					'value' => urlencode( json_encode( array(
						array(
							'title' => 'Point 1',
							'lat' => '51.516221',
							'lng' => '-0.136986',
						),
					) ) ),
					'params' => array(
						array(
							"type" => "textfield",
							"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
							"param_name" => "title",
							"value" => "",
							"description" => esc_html__( "Enter your point title.", "grve-blade-vc-extension" ),
							"admin_label" => true,
						),
						array(
							"type" => "attach_image",
							"heading" => esc_html__( "Marker", "grve-blade-vc-extension" ),
							"param_name" => "marker",
							"value" => '',
							"description" => esc_html__( "Select an icon for your point marker. Note: if empty global marker will be used instead.", "grve-blade-vc-extension" ),
						),
						array(
							'type' => 'textfield',
							'value' => '51.516221',
							'heading' => 'Latitude',
							'param_name' => 'lat',
						),
						array(
							'type' => 'textfield',
							'value' => '-0.136986',
							'heading' => 'Longitude',
							'param_name' => 'lng',
						),
						array(
							"type" => "textarea",
							"heading" => esc_html__( "Info Text", "grve-blade-vc-extension" ),
							"param_name" => "infotext",
							"value" => "",
							"description" => esc_html__( "Enter your info text.", "grve-blade-vc-extension" ),
						),
						array(
							"type" => "dropdown",
							"heading" => esc_html__( "Open Info Text Onload", "grve-blade-vc-extension" ),
							"param_name" => "infotext_open",
							"value" => array(
								esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
								esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
							),
							"description" => esc_html__( "Select if you want to open info text on load.", "grve-blade-vc-extension" ),
						),
						array(
							"type" => "textfield",
							"heading" => esc_html__( "Link Text", "grve-blade-vc-extension" ),
							"param_name" => "link_text",
							"value" => "",
							"description" => esc_html__( "Enter your link text.", "grve-blade-vc-extension" ),
						),
						array(
							"type" => "vc_link",
							"heading" => esc_html__( "Link", "grve-blade-vc-extension" ),
							"param_name" => "link",
							"value" => "",
							"description" => esc_html__( "Enter your link.", "grve-blade-vc-extension" ),
						),
						array(
							"type" => "textfield",
							"heading" => esc_html__( "Link Class", "grve-blade-vc-extension" ),
							"param_name" => "link_class",
							"value" => "",
							"description" => esc_html__( "Enter your link class.", "grve-blade-vc-extension" ),
						),
					),
					"dependency" => array( 'element' => "map_mode", 'value' => array( 'multiple' ) ),
					"group" => esc_html__( "Map Points", "grve-blade-vc-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_gmap', 'grve_blade_vce_gmap_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_gmap_shortcode_params( 'grve_gmap' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
