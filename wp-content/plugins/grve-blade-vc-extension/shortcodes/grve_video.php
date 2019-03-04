<?php
/**
 * Video Shortcode
 */

if( !function_exists( 'grve_blade_vce_video_shortcode' ) ) {

	function grve_blade_vce_video_shortcode( $atts, $content ) {
		global $wp_embed;
		$output = $class_fullwidth = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'video_link' => '',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		$video_classes = array( 'grve-element', 'grve-video' );

		if ( !empty( $el_class ) ) {
			array_push( $video_classes, $el_class);
		}
		$video_class_string = implode( ' ', $video_classes );


		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		if ( !empty( $video_link ) ) {
			$output .= '<div class="' . esc_attr( $video_class_string ) . '" style="' . $style . '">';
			$output .= $wp_embed->run_shortcode( '[embed]' . $video_link . '[/embed]' );
			$output .= '</div>';
		}

		return $output;
	}
	add_shortcode( 'grve_video', 'grve_blade_vce_video_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_video_shortcode_params' ) ) {
	function grve_blade_vce_video_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Video", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Embed YouTube/Vimeo player", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-video",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Video Link", "grve-blade-vc-extension" ),
					"param_name" => "video_link",
					"value" => "",
					"description" => esc_html__( "Type Vimeo/YouTube URL.", "grve-blade-vc-extension" ),
				),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_video', 'grve_blade_vce_video_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_video_shortcode_params( 'grve_video' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
