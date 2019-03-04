<?php
/**
 * Media Box Shortcode
 */

if( !function_exists( 'grve_blade_vce_media_box_shortcode' ) ) {

	function grve_blade_vce_media_box_shortcode( $atts, $content ) {
		global $wp_embed;
		$output = $data = $retina_data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'media_type' => 'image',
					'image' => '',
					'retina_image' => '',
					'zoom_effect' => 'none',
					'overlay_color' => 'light',
					'overlay_opacity' => '90',
					'video_popup' => '',
					'video_link' => '',
					'map_lat' => '51.516221',
					'map_lng' => '-0.136986',
					'map_height' => '280',
					'map_marker' => '',
					'map_zoom' => 14,
					'map_disable_style' => 'no',
					'title_link' => '',
					'read_more_title' => '',
					'align' => 'left',
					'add_icon' => '',
					'icon_library' => 'fontawesome',
					'icon_fontawesome' => 'fa fa-info-circle',
					'icon_openiconic' => 'vc-oi vc-oi-dial',
					'icon_typicons' => 'typcn typcn-adjust-brightness',
					'icon_entypo' => 'entypo-icon entypo-icon-note',
					'icon_linecons' => 'vc_li vc_li-heart',
					'icon_simplelineicons' => 'smp-icon-user',
					'icon_bg_color' => 'green',
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

		if( 'yes' == $add_icon ) {
			$icon_class = isset( ${"icon_" . $icon_library} ) ? esc_attr( ${"icon_" . $icon_library} ) : 'fa fa-adjust';
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				vc_icon_element_fonts_enqueue( $icon_library );
			}
		}

		if ( !empty( $title_link ) ){
			$href = vc_build_link( $title_link );
			$url = $href['url'];
			if ( !empty( $href['target'] ) ){
				$target = $href['target'];
			} else {
				$target= "_self";
			}
		} else {
			$url = "";
			$target= "_self";
		}
		$target = trim( $target );

		if( empty( $url ) ) {
			$title_link = '';
		}

		$media_box_classes = array( 'grve-element', 'grve-box', 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $media_box_classes, 'grve-animated-item' );
			array_push( $media_box_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $media_box_classes, $el_class);
		}
		$media_box_classe_string = implode( ' ', $media_box_classes );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $media_box_classe_string ) . '" style="' . $style . '"' . $data . '>';


		switch( $media_type ) {
			case 'image':
			case 'image-video-popup':
				if ( !empty( $image ) ) {
					$img_id = preg_replace('/[^\d]/', '', $image);
					$img_src = wp_get_attachment_image_src( $img_id, 'full' );
					$img_url = $img_src[0];
					$image_srcset = '';
					$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
					if ( !empty( $retina_image ) ) {
						$img_retina_id = preg_replace('/[^\d]/', '', $retina_image);
						$img_retina_src = wp_get_attachment_image_src( $img_retina_id, 'full' );
						$retina_url = $img_retina_src[0];
						$image_srcset = $img_url . ' 1x,' . $retina_url . ' 2x';
						$image_html = wp_get_attachment_image( $img_id, 'full' , "", array( 'srcset'=> $image_srcset ) );
					} else {
						$image_html = wp_get_attachment_image( $img_id, 'full' );
					}

				} else {
					$dummy_image_url =  GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL .'assets/images/empty/blade-grve-small-rect-horizontal.jpg';
					$image_html = '<img alt="Dummy Image" src="' . esc_url( $dummy_image_url ) . '" width="800" height="600">';
				}

				if ( 'image-video-popup' == $media_type && !empty( $video_link ) ) {
					$output .= '<a class="grve-video-popup" href="' . esc_url( $video_link ) . '">';
					if( 'yes' == $add_icon ) {
						$output .= '<div class="grve-media-box-icon grve-bg-'. esc_attr( $icon_bg_color ) . '"><i class="'. esc_attr( $icon_class ) . '"></i></div>';
					}
					$output .= '	<figure class="grve-image-hover grve-zoom-' . esc_attr( $zoom_effect ) . '">';
					$output .= '		<div class="grve-media">';
					$output .= '			<svg version="1.1" class="grve-icon-video" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="62px" height="62px" viewBox="0 0 62 62" enable-background="new 0 0 62 62" xml:space="preserve"><g><path fill="#ffffff" d="M22.281,44.336V17.664L44.508,31L22.281,44.336z M24.219,21.086v19.828L40.742,31L24.219,21.086z"/></g><path fill="#ffffff" d="M31,1.938c16.025,0,29.062,13.037,29.062,29.062S47.025,60.062,31,60.062S1.938,47.025,1.938,31S14.975,1.938,31,1.938 M31,0C13.88,0,0,13.88,0,31c0,17.121,13.88,31,31,31c17.121,0,31-13.879,31-31C62,13.88,48.121,0,31,0L31,0z"/></svg>';
					$output .= '			<div class="grve-bg-' . esc_attr( $overlay_color ) . ' grve-hover-overlay grve-opacity-' . esc_attr( $overlay_opacity ) . '"></div>';
					$output .= $image_html;
					$output .= '		</div>';
					$output .= '	</figure>';
					$output .= '</a>';
				} else {
					if ( !empty( $title_link ) ) {
						$output .= '<a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '">';
					}
					if( 'yes' == $add_icon ) {
						$output .= '<div class="grve-media-box-icon grve-bg-'. esc_attr( $icon_bg_color ) . '"><i class="'. esc_attr( $icon_class ) . '"></i></div>';
					}
					$output .= '<figure class="grve-image-hover grve-zoom-' . esc_attr( $zoom_effect ) . '">';
					$output .= '	<div class="grve-media">';
					$output .= '		<div class="grve-bg-' . esc_attr( $overlay_color ) . ' grve-hover-overlay grve-opacity-' . esc_attr( $overlay_opacity ) . '"></div>';
					$output .= $image_html;
					$output .= '	</div>';
					$output .= '</figure>';
					if ( !empty( $title_link ) ) {
						$output .= '</a>';
					}
				}
				break;
			case 'video':
				if ( !empty( $video_link ) ) {
					$output .= '<div class="grve-media">';
					$output .= $wp_embed->run_shortcode( '[embed]' . $video_link . '[/embed]' );
					$output .= '</div>';
				}
				break;
			case 'map':
				wp_enqueue_script( 'blade-grve-googleapi-script');
				wp_enqueue_script( 'blade-grve-maps-script');
				if ( empty( $map_marker ) ) {
					$map_marker = get_template_directory_uri() . '/images/markers/markers.png';
				} else {
					$id = preg_replace('/[^\d]/', '', $map_marker);
					$full_src = wp_get_attachment_image_src( $id, 'full' );
					$map_marker = $full_src[0];
				}
				$map_title = '';

				$data_map = 'data-lat="' . esc_attr( $map_lat ) . '" data-lng="' . esc_attr( $map_lng ) . '" data-zoom="' . esc_attr( $map_zoom ) . '" data-disable-style="' . esc_attr( $map_disable_style ) . '"';
				$output .= '<div class="grve-media">';
				$output .= '  <div class="grve-map" ' . $data_map . ' style="' . $style . grve_blade_vce_build_dimension( 'height', $map_height ) . '"></div>';
				$output .= '  <div style="display:none" class="grve-map-point" data-point-lat="' . esc_attr( $map_lat ) . '" data-point-lng="' . esc_attr( $map_lng ) . '" data-point-marker="' . esc_attr( $map_marker ) . '" data-point-title="' . esc_attr( $map_title ) . '"></div>';
				$output .= '</div>';
				break;
			default :
				break;
		}


		$output .= '  <div class="grve-box-content">';
		if ( !empty( $title ) ) {
			if ( !empty( $title_link ) ) {
			$output .= '    <a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '">';
			}
			$output .= '<' . tag_escape( $heading_tag ) . ' class="grve-box-title ' . esc_attr( $heading_class ) . '">' . $title. '</' . tag_escape( $heading_tag ) . '>';
			if ( !empty( $title_link ) ) {
			$output .= '    </a>';
			}
		}

		$output .= '    <p>' . do_shortcode( $content ) . '</p>';
		if ( !empty( $read_more_title ) && !empty( $url ) ) {
		$output .= '    <a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '" class="grve-read-more grve-link-text">';
		$output .=  $read_more_title ;
		$output .= '</a>';
		}
		$output .= '  </div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_media_box', 'grve_blade_vce_media_box_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_media_box_shortcode_params' ) ) {
	function grve_blade_vce_media_box_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Media Box", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Image, Video or Map combined with text", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-media-box",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Media type", "grve-blade-vc-extension" ),
					"param_name" => "media_type",
					"value" => array(
						esc_html__( "Image", "grve-blade-vc-extension" ) => 'image',
						esc_html__( "Image - Video Popup", "grve-blade-vc-extension" ) => 'image-video-popup',
						esc_html__( "Video", "grve-blade-vc-extension" ) => 'video',
						esc_html__( "Map", "grve-blade-vc-extension" ) => 'map',
					),
					"description" => esc_html__( "Select your media type.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Image", "grve-blade-vc-extension" ),
					"param_name" => "image",
					"value" => '',
					"description" => esc_html__( "Select an image.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Retina Image", "grve-blade-vc-extension" ),
					"param_name" => "retina_image",
					"value" => '',
					"description" => esc_html__( "Select a 2x image.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
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
					'std' => 'none',
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Color", "grve-blade-vc-extension" ),
					"param_name" => "overlay_color",
					"value" => array(
						esc_html__( "Light", "grve-blade-vc-extension" ) => 'light',
						esc_html__( "Dark", "grve-blade-vc-extension" ) => 'dark',
						esc_html__( "Primary 1", "grve-blade-vc-extension" ) => 'primary-1',
						esc_html__( "Primary 2", "grve-blade-vc-extension" ) => 'primary-2',
						esc_html__( "Primary 3", "grve-blade-vc-extension" ) => 'primary-3',
						esc_html__( "Primary 4", "grve-blade-vc-extension" ) => 'primary-4',
						esc_html__( "Primary 5", "grve-blade-vc-extension" ) => 'primary-5',
					),
					"description" => esc_html__( "Choose the image color overlay.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "grve-blade-vc-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Video Link", "grve-blade-vc-extension" ),
					"param_name" => "video_link",
					"value" => "",
					"description" => esc_html__( "Type video URL e.g Vimeo/YouTube.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image-video-popup', 'video' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Latitude", "grve-blade-vc-extension" ),
					"param_name" => "map_lat",
					"value" => "51.516221",
					"description" => esc_html__( "Type map Latitude.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Longtitude", "grve-blade-vc-extension" ),
					"param_name" => "map_lng",
					"value" => "-0.136986",
					"description" => esc_html__( "Type map Longtitude.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Map Zoom", "grve-blade-vc-extension" ),
					"param_name" => "map_zoom",
					"value" => array( 1, 2, 3 ,4, 5, 6, 7, 8 ,9 ,10 ,11 ,12, 13, 14, 15, 16, 17, 18, 19 ),
					"std" => 14,
					"description" => esc_html__( "Zoom of the map.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Map Height", "grve-blade-vc-extension" ),
					"param_name" => "map_height",
					"value" => "280",
					"description" => esc_html__( "Type map height.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
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
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Custom marker", "grve-blade-vc-extension" ),
					"param_name" => "map_marker",
					"value" => '',
					"description" => esc_html__( "Select an icon for custom marker.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'map' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
					"param_name" => "title",
					"value" => "Sample Title",
					"description" => esc_html__( "Enter your title.", "grve-blade-vc-extension" ),
					"save_always" => true,
					"admin_label" => true,
				),
				grve_blade_vce_get_heading_tag( "h3" ),
				grve_blade_vce_get_heading( "h3" ),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "grve-blade-vc-extension" ),
					"param_name" => "content",
					"value" => "Sample Text",
					"description" => esc_html__( "Enter your text.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Title Link", "grve-blade-vc-extension" ),
					"param_name" => "title_link",
					"value" => "",
					"description" => esc_html__( "Enter title link.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Read More Title", "grve-blade-vc-extension" ),
					"param_name" => "read_more_title",
					"value" => "",
					"description" => esc_html__( "Enter your title for your link.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				grve_blade_vce_add_align(),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Add icon?", "grve-blade-vc-extension" ),
					"param_name" => "add_icon",
					"value" => array( esc_html__( "Select if you want to show an icon", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "media_type", 'value' => array( 'image', 'image-video-popup' ) ),
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
					"dependency" => array( 'element' => "add_icon", 'value' => array( 'yes' ) ),
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
					"heading" => esc_html__( "Background Color", "grve-blade-vc-extension" ),
					"param_name" => "icon_bg_color",
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
					"description" => esc_html__( "Background color of the box.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "add_icon", 'value' => array( 'yes' ) ),
					"admin_label" => true,
					'std' => 'green',
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
	vc_lean_map( 'grve_media_box', 'grve_blade_vce_media_box_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_media_box_shortcode_params( 'grve_media_box' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
