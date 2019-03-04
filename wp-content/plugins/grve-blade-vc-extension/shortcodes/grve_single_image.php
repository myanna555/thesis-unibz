<?php
/**
* Single Image Shortcode
*/

if( !function_exists( 'grve_blade_vce_single_image_shortcode' ) ) {

	function grve_blade_vce_single_image_shortcode( $attr, $content ) {

		$output = $data = $retina_data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'image' => '',
					'image_mode' => '',
					'retina_image' => '',
					'image_type' => 'image',
					'ids' => '',
					'image_size' => 'no',
					'align' => 'center',
					'custom_title' => '',
					'custom_caption' => '',
					'image_hover_style' => 'hover-style-1',
					'image_shape' => 'square',
					'zoom_effect' => 'in',
					'overlay_color' => 'dark',
					'overlay_opacity' => '60',
					'link' => '',
					'link_class' => '',
					'video_link' => '',
					'animation' => '',
					'animation_delay' => '200',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$attr
			)
		);

		if ( !empty( $animation ) ) {
			$animation = 'grve-' .$animation;
		}

		if ( !empty( $link ) ){
			$href = vc_build_link( $link );
			$url = $href['url'];
			if ( !empty( $href['target'] ) ){
				$target = $href['target'];
			} else {
				$target = "_self";
			}
		} else {
			$url = "#";
			$target = "_self";
		}
		$target = trim( $target );

		$single_image_classes = array( 'grve-element', 'grve-image' );

		if ( !empty( $animation ) ) {
			array_push( $single_image_classes, 'grve-animated-item' );
			array_push( $single_image_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $single_image_classes, $el_class);
		}

		if ( 'image-caption' == $image_type ) {
			array_push( $single_image_classes, 'grve-align-center');
		} else {
			array_push( $single_image_classes, 'grve-align-' . $align );
		}

		$single_image_classe_string = implode( ' ', $single_image_classes );
		$image_mode_size = grve_blade_vce_get_image_size( $image_mode );

		$image_classes = array();
		if ( 'yes' == $image_size ) {
			$image_classes[] =  'grve-full-image';
		}
		if ( 'square' != $image_shape ) {
			$image_classes[] =  'grve-' . $image_shape;
		}
		$image_classes[] = 'attachment-' . $image_mode_size;
		$image_classes[] = 'size-' . $image_mode_size;
		$image_class_string = implode( ' ', $image_classes );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $single_image_classe_string ) . '" style="' . $style . '"' . $data . '>';


		//Image Title & Caption Color
		$text_color = 'light';
		if( 'light' == $overlay_color ) {
			$text_color = 'dark';
		}

		if ( !empty( $image ) ) {
			$id = preg_replace('/[^\d]/', '', $image);
			$img_src = wp_get_attachment_image_src( $id, $image_mode_size );
			$img_url = $img_src[0];
			$full_src = wp_get_attachment_image_src( $id, 'blade-grve-fullscreen' );
			$full_url = $full_src[0];
			$image_srcset = '';
			if ( !empty( $retina_image ) && empty( $image_mode ) ) {
				$img_retina_id = preg_replace('/[^\d]/', '', $retina_image);
				$img_retina_src = wp_get_attachment_image_src( $img_retina_id, 'full' );
				$retina_url = $img_retina_src[0];
				$image_srcset = $img_url . ' 1x,' . $retina_url . ' 2x';
				$image_html = wp_get_attachment_image( $id, $image_mode_size , "", array( 'class' => $image_class_string, 'srcset'=> $image_srcset ) );
			} else {
				$image_html = wp_get_attachment_image( $id, $image_mode_size , "", array( 'class' => $image_class_string ) );
			}
		} else {
			$dummy_image_url = $full_url =  GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL .'assets/images/empty/blade-grve-small-rect-horizontal.jpg';
			$image_html = '<img alt="Dummy Image" src="' . esc_url( $dummy_image_url ) . '" width="800" height="600">';
		}

		if ( 'image-popup' == $image_type ) {
			$output .= '<a class="grve-image-popup" href="' . esc_url( $full_url ) . '">';
			$output .= $image_html;
			$output .= '</a>';
		}  else if ( 'gallery-popup' == $image_type ) {
			$output .= '<div class="grve-gallery-popup">';

			$attachments = explode( ",", $ids );
			if ( !empty( $ids ) && !empty( $attachments ) ) {
				$first_image_caption = "";
				$first_image_url = "#";
				$index = 0;

				$gallery_links = "";
				$gallery_links .= '<div class="grve-hidden">';
				foreach ( $attachments as $id ) {
					$full_src = wp_get_attachment_image_src( $id, 'blade-grve-fullscreen' );
					$full_url = $full_src[0];
					$image_title = get_post_field( 'post_title', $id );
					$image_caption = get_post_field( 'post_excerpt', $id );
					if ( 0 == $index ) {
						$first_image_caption = $image_caption;
						$first_image_url= $full_url;
					} else {
						$gallery_links .= '<a href="' . esc_url( $full_url ) . '" data-desc="' . esc_attr( $image_caption ) . '"></a>';
					}
					$index ++;
				}
				$gallery_links .= '</div>';

				$output .= '<a href="' . esc_url( $first_image_url ) . '" data-desc="' . esc_attr( $first_image_caption ) . '">';
				$output .= $image_html;
				$output .= '</a>';
				$output .= $gallery_links;
			} else {
				$output .= $image_html;
			}
			$output .= '</div>';
		} else if ( 'image-link' == $image_type ) {
			$output .= '<a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '" class=" ' . esc_attr( $link_class ) . '">';
			$output .= $image_html;
			$output .= '</a>';
		} else if ( 'image-video-popup' == $image_type ) {
			if ( !empty( $video_link ) ) {
				$output .= '<div class="grve-media">';
				$output .= '	<a class="grve-video-popup" href="' . esc_url( $video_link ) . '">';
				$output .= '		<svg version="1.1" class="grve-icon-video" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="62px" height="62px" viewBox="0 0 62 62" enable-background="new 0 0 62 62" xml:space="preserve"><g><path fill="#ffffff" d="M22.281,44.336V17.664L44.508,31L22.281,44.336z M24.219,21.086v19.828L40.742,31L24.219,21.086z"/></g><path fill="#ffffff" d="M31,1.938c16.025,0,29.062,13.037,29.062,29.062S47.025,60.062,31,60.062S1.938,47.025,1.938,31S14.975,1.938,31,1.938 M31,0C13.88,0,0,13.88,0,31c0,17.121,13.88,31,31,31c17.121,0,31-13.879,31-31C62,13.88,48.121,0,31,0L31,0z"/></svg>';
				$output .= $image_html;
				$output .= '	</a>';
				$output .= '</div>';
			} else {
				$output .= '<div class="grve-media">';
				$output .= $image_html;
				$output .= '</div>';
			}
		} else if ( 'image-caption' == $image_type || 'image-popup-caption' == $image_type ) {
			if ( 'image-caption' == $image_type && !empty( $url ) && '#' != $url ) {
			$output .= '<a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '" class=" ' . esc_attr( $link_class ) . '">';
			}
			if ( 'image-popup-caption' == $image_type ) {
			$output .= '<a class="grve-image-popup" href="' . esc_url( $full_url ) . '">';
			}
			$output .= '  <figure class="grve-' . esc_attr( $image_hover_style ) . ' grve-image-hover grve-zoom-' . esc_attr( $zoom_effect ) . '">';
			$output .= '    <div class="grve-media">';
			$output .= '      <div class="grve-hover-overlay grve-bg-' . esc_attr( $overlay_color ) . ' grve-opacity-' . esc_attr( $overlay_opacity )  . '"></div>';
			$output .= $image_html;
			$output .= '    </div>';
			$output .= '    <figcaption>';
			$output .= '      <div class="grve-image-content">';
				if ( !empty( $custom_title ) ) {
					if( 'hover-style-2' == $image_hover_style ) {
						$output .= '<h6 class="grve-title grve-text-hover-primary-1">' . $custom_title . '</h6>';
					} else {
						$output .= '<h6 class="grve-title grve-text-' . esc_attr( $text_color ) . '">' . $custom_title . '</h6>';
					}
				}
				if ( !empty( $custom_caption ) ) {
					if( 'hover-style-2' == $image_hover_style ) {
						$output .= '<span class="grve-caption grve-text-content">' . $custom_caption . '</span>';
					} else {
						$output .= '<span class="grve-caption grve-text-' . esc_attr( $text_color ) . '">' . $custom_caption . '</span>';
					}
				}
			$output .= '      </div>';
			$output .= '    </figcaption>';
			$output .= '  </figure>';
			if ( 'image-caption' == $image_type && !empty( $url ) && '#' != $url ) {
			$output .= '</a>';
			}
			if ( 'image-popup-caption' == $image_type ) {
			$output .= '</a>';
			}
		} else {
			$output .= $image_html;
		}

		$output .= '</div>';

		return $output;

	}
	add_shortcode( 'grve_single_image', 'grve_blade_vce_single_image_shortcode' );

}

/**
* Add shortcode to Visual Composer
*/

if( !function_exists( 'grve_blade_vce_single_image_shortcode_params' ) ) {
	function grve_blade_vce_single_image_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Single Image", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Image or Video popup in various uses", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-single-image",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Type", "grve-blade-vc-extension" ),
					"param_name" => "image_type",
					"value" => array(
						esc_html__( "Image", "grve-blade-vc-extension" ) => 'image',
						esc_html__( "Image Link", "grve-blade-vc-extension" ) => 'image-link',
						esc_html__( "Image Popup", "grve-blade-vc-extension" ) => 'image-popup',
						esc_html__( "Image Video Popup", "grve-blade-vc-extension" ) => 'image-video-popup',
						esc_html__( "Image With Caption", "grve-blade-vc-extension" ) => 'image-caption',
						esc_html__( "Image Popup With Caption", "grve-blade-vc-extension" ) => 'image-popup-caption',
						esc_html__( "Gallery Popup", "grve-blade-vc-extension" ) => 'gallery-popup',
					),
					"description" => esc_html__( "Select your image type.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Mode", "grve-blade-vc-extension" ),
					"param_name" => "image_mode",
					'value' => array(
						esc_html__( 'Full ( Custom )', 'grve-blade-vc-extension' ) => '',
						esc_html__( 'Thumbnail', 'grve-blade-vc-extension' ) => 'thumbnail',
						esc_html__( 'Medium ( Resize )', 'grve-blade-vc-extension' ) => 'medium',
						esc_html__( 'Large ( Resize )', 'grve-blade-vc-extension' ) => 'large',
						esc_html__( 'Square ( Crop )', 'grve-blade-vc-extension' ) => 'square',
						esc_html__( 'Landscape ( Crop )', 'grve-blade-vc-extension' ) => 'landscape',
						esc_html__( 'Landscape Wide ( Crop )', 'grve-blade-vc-extension' ) => 'landscape-wide',
						esc_html__( 'Portrait ( Crop )', 'grve-blade-vc-extension' ) => 'portrait',
					),
					'std' => '',
					"description" => esc_html__( "Select your Image Mode.", "grve-blade-vc-extension" ),
				),
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
					"dependency" => array( 'element' => "image_mode", 'value' => array( '' ) ),
				),
				array(
					"type"			=> "attach_images",
					"class"			=> "",
					"heading"		=> esc_html__( "Attach Images", "grve-blade-vc-extension" ),
					"param_name"	=> "ids",
					"value" => '',
					"description"	=> esc_html__( "Select your gallery images.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'gallery-popup' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Image Size", "grve-blade-vc-extension" ),
					"param_name" => "image_size",
					"value" => array( esc_html__( "If selected, image will fill the column space", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image', 'image-link', 'image-popup', 'image-video-popup', 'gallery-popup' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Alignment", "grve-blade-vc-extension" ),
					"param_name" => "align",
					"value" => array(
						esc_html__( "Left", "grve-blade-vc-extension" ) => 'left',
						esc_html__( "Right", "grve-blade-vc-extension" ) => 'right',
						esc_html__( "Center", "grve-blade-vc-extension" ) => 'center',
					),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image', 'image-link', 'image-popup', 'image-video-popup', 'gallery-popup' ) ),
					"std" => 'center',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
					"param_name" => "custom_title",
					"value" => "",
					"description" => esc_html__( "Enter your title.", "grve-blade-vc-extension" ),
					"admin_label" => true,
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Caption", "grve-blade-vc-extension" ),
					"param_name" => "custom_caption",
					"value" => "",
					"description" => esc_html__( "Enter your caption.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Hover Style", "grve-blade-vc-extension" ),
					"param_name" => "image_hover_style",
					'value' => array(
						esc_html__( 'Style 1' , 'grve-blade-vc-extension' ) => 'hover-style-1',
						esc_html__( 'Style 2' , 'grve-blade-vc-extension' ) => 'hover-style-2',
						esc_html__( 'Style 3' , 'grve-blade-vc-extension' ) => 'hover-style-3',
					),
					"description" => esc_html__( "Select hover style for your image.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Zoom Effect", "grve-blade-vc-extension" ),
					"param_name" => "zoom_effect",
					"value" => array(
						esc_html__( "Zoom In", "grve-blade-vc-extension" ) => 'in',
						esc_html__( "Zoom Out", "grve-blade-vc-extension" ) => 'out',
						esc_html__( "None", "grve-blade-vc-extension" ) => 'none',
					),
					"description" => esc_html__( "Choose the image zoom effect.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Color", "grve-blade-vc-extension" ),
					"param_name" => "overlay_color",
					"value" => array(
						esc_html__( "Dark", "grve-blade-vc-extension" ) => 'dark',
						esc_html__( "Light", "grve-blade-vc-extension" ) => 'light',
						esc_html__( "Primary 1", "grve-blade-vc-extension" ) => 'primary-1',
						esc_html__( "Primary 2", "grve-blade-vc-extension" ) => 'primary-2',
						esc_html__( "Primary 3", "grve-blade-vc-extension" ) => 'primary-3',
						esc_html__( "Primary 4", "grve-blade-vc-extension" ) => 'primary-4',
						esc_html__( "Primary 5", "grve-blade-vc-extension" ) => 'primary-5',
					),
					"description" => esc_html__( "Choose the image color overlay.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "grve-blade-vc-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 80,
					"description" => esc_html__( "Choose the opacity for the overlay.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-caption', 'image-popup-caption' ) ),
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
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image', 'image-link', 'image-popup', 'image-video-popup', 'gallery-popup' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Video Link", "grve-blade-vc-extension" ),
					"param_name" => "video_link",
					"value" => "",
					"description" => esc_html__( "Type video URL e.g Vimeo/YouTube.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-video-popup') ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Link", "grve-blade-vc-extension" ),
					"param_name" => "link",
					"value" => "",
					"description" => esc_html__( "Enter link.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-link', 'image-caption' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Link Class", "grve-blade-vc-extension" ),
					"param_name" => "link_class",
					"value" => "",
					"description" => esc_html__( "Enter extra class name for your link.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "image_type", 'value' => array( 'image-link', 'image-caption' ) ),
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
	vc_lean_map( 'grve_single_image', 'grve_blade_vce_single_image_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_single_image_shortcode_params( 'grve_single_image' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
