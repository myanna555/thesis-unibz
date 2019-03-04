<?php
/**
 * Image Text Shortcode
 */

if( !function_exists( 'grve_blade_vce_image_text_shortcode' ) ) {

	function grve_blade_vce_image_text_shortcode( $atts, $content ) {

		$output = $output_image = $data = $retina_data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'image' => '',
					'retina_image' => '',
					'image_size' => 'no',
					'image_shape' => 'square',
					'image_text_align' => 'left',
					'video_popup' => '',
					'video_link' => '',
					'read_more_title' => '',
					'read_more_link' => '',
					'read_more_class' => '',
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

		if ( !empty( $read_more_link ) ){
			$href = vc_build_link( $read_more_link );
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

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$image_text_classes = array( 'grve-element', 'grve-image-text' );

		if ( !empty( $animation ) ) {
			array_push( $image_text_classes, 'grve-animated-item' );
			array_push( $image_text_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $image_text_classes, $el_class);
		}
		$image_text_class_string = implode( ' ', $image_text_classes );

		$image_align = 'left';
		$content_align = 'right';
		if( 'right' == $image_text_align ) {
			$image_align = 'right';
			$content_align = 'left';
		}

		$image_classes = array();

		if ( 'yes' == $image_size ) {
			$image_classes[] = 'grve-full-image';
		}
		if ( 'square' != $image_shape ) {
			$image_classes[] = 'grve-' . $image_shape;
		}
		$image_classes[] = 'attachment-full';
		$image_classes[] = 'size-full';
		$image_class_string = implode( ' ', $image_classes );


		$output .= '<div class="' . esc_attr( $image_text_class_string ) . '" style="' . $style . '"' . $data . '>';
		if ( !empty( $image ) ) {
			$img_id = preg_replace('/[^\d]/', '', $image);
			$img_src = wp_get_attachment_image_src( $img_id, 'full' );
			$img_url = $img_src[0];
			$full_src = wp_get_attachment_image_src( $img_id, 'blade-grve-fullscreen' );
			$full_url = $full_src[0];
			$image_srcset = '';
			if ( !empty( $retina_image ) ) {
				$img_retina_id = preg_replace('/[^\d]/', '', $retina_image);
				$img_retina_src = wp_get_attachment_image_src( $img_retina_id, 'full' );
				$retina_url = $img_retina_src[0];
				$image_srcset = $img_url . ' 1x,' . $retina_url . ' 2x';
			}


			if ( 'yes' == $video_popup && !empty( $video_link ) ) {
				$output_image .= '<div class="grve-image grve-position-' . esc_attr( $image_align ) . '">';
				$output_image .= '	<a class="grve-video-popup" href="' . esc_url( $video_link ) . '">';
				$output_image .= '		<svg version="1.1" class="grve-icon-video" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="62px" height="62px" viewBox="0 0 62 62" enable-background="new 0 0 62 62" xml:space="preserve"><g><path fill="#ffffff" d="M22.281,44.336V17.664L44.508,31L22.281,44.336z M24.219,21.086v19.828L40.742,31L24.219,21.086z"/></g><path fill="#ffffff" d="M31,1.938c16.025,0,29.062,13.037,29.062,29.062S47.025,60.062,31,60.062S1.938,47.025,1.938,31S14.975,1.938,31,1.938 M31,0C13.88,0,0,13.88,0,31c0,17.121,13.88,31,31,31c17.121,0,31-13.879,31-31C62,13.88,48.121,0,31,0L31,0z"/></svg>';
				$output_image .= wp_get_attachment_image( $img_id, 'full' , "", array( 'class' => $image_class_string, 'srcset'=> $image_srcset ) );
				$output_image .= '	</a>';
				$output_image .= '</div>';
			} else if ( 'image' == $video_popup ) {
				$output_image .= '<div class="grve-image grve-position-' . esc_attr( $image_align ) . '">';
				$output_image .= '	<a class="grve-image-popup" href="' . esc_url( $full_url ) . '">';
				$output_image .= wp_get_attachment_image( $img_id, 'full' , "", array( 'class' => $image_class_string, 'srcset'=> $image_srcset ) );
				$output_image .= '	</a>';
				$output_image .= '</div>';
			} else {
				$output_image .= '<div class="grve-image grve-position-' . esc_attr( $image_align ) . '">';
				$output_image .= wp_get_attachment_image( $img_id, 'full' , "", array( 'class' => $image_class_string, 'srcset'=> $image_srcset ) );
				$output_image .= '</div>';
			}

			$output .= $output_image;
			$output .= '  <div class="grve-content grve-position-' . esc_attr( $content_align ) . ' grve-align-' . esc_attr( $image_text_align ) . '">';
			if ( !empty( $title ) ) {
			$output .= '<' . tag_escape( $heading_tag ) . ' class="' . esc_attr( $heading_class ) . '">' . $title. '</' . tag_escape( $heading_tag ) . '>';
			}
			if ( !empty( $content ) ) {
			$output .= '  <p>' . do_shortcode( $content ) . '</p>';
			}
			if ( !empty( $read_more_title ) && !empty( $url ) ) {
				$output .= '    <a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '" class="grve-link-text grve-read-more ' . esc_attr( $read_more_class ) . '">';
				$output .=  $read_more_title ;
				$output .= '</a>';
			}
			$output .= '  </div>';
		}
		$output .= '</div>';


		return $output;
	}
	add_shortcode( 'grve_image_text', 'grve_blade_vce_image_text_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_image_text_shortcode_params' ) ) {
	function grve_blade_vce_image_text_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Image Text", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Combine image or video with text and button", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-image-text",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Image", "grve-blade-vc-extension" ),
					"param_name" => "image",
					"value" => '',
					"description" => esc_html__( "Select an image.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Retina Image", "grve-blade-vc-extension" ),
					"param_name" => "retina_image",
					"value" => '',
					"description" => esc_html__( "Select a 2x image.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Image Size", "grve-blade-vc-extension" ),
					"param_name" => "image_size",
					"value" => array( esc_html__( "If selected, image will fill the column space", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Image align", "grve-blade-vc-extension" ),
					"param_name" => "image_text_align",
					"description" => esc_html__( "Set the alignment of your image", "grve-blade-vc-extension" ),
					"value" => array(
						esc_html__( "Left", "grve-blade-vc-extension" ) => 'left',
						esc_html__( "Right", "grve-blade-vc-extension" ) => 'right',
					),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image shape", "grve-blade-vc-extension" ),
					"param_name" => "image_shape",
					"value" => array(
						esc_html__( "Square", "grve-blade-vc-extension" ) => 'square',
						esc_html__( "Round", "grve-blade-vc-extension" ) => 'extra-round',
						esc_html__( "Circle", "grve-blade-vc-extension" ) => 'circle',
					),
					"description" => '',
					"admin_label" => true,
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Popup", "grve-blade-vc-extension" ),
					"param_name" => "video_popup",
					"description" => esc_html__( "If selected, a popup will appear on click.", "grve-blade-vc-extension" ),
					"value" => array(
						esc_html__( "No", "grve-blade-vc-extension" ) => '',
						esc_html__( "Video", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "Image", "grve-blade-vc-extension" ) => 'image',
					),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Video Link", "grve-blade-vc-extension" ),
					"param_name" => "video_link",
					"value" => "",
					"description" => esc_html__( "Type video URL e.g Vimeo/YouTube.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "video_popup", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__( "Enter your title.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				grve_blade_vce_get_heading_tag( "h3" ),
				grve_blade_vce_get_heading( "h3" ),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "grve-blade-vc-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Enter your text.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Read More Title", "grve-blade-vc-extension" ),
					"param_name" => "read_more_title",
					"value" => "",
					"description" => esc_html__( "Enter your title for your link.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Read More Link Class", "grve-blade-vc-extension" ),
					"param_name" => "read_more_class",
					"value" => "",
					"description" => esc_html__( "Enter extra class name for your link.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Read More Link", "grve-blade-vc-extension" ),
					"param_name" => "read_more_link",
					"value" => "",
					"description" => esc_html__( "Enter read more link.", "grve-blade-vc-extension" ),
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
	vc_lean_map( 'grve_image_text', 'grve_blade_vce_image_text_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_image_text_shortcode_params( 'grve_image_text' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
