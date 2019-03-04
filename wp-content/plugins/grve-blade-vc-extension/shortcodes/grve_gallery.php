<?php
/**
 * Gallery Shortcode
 */

if( !function_exists( 'grve_blade_vce_gallery_shortcode' ) ) {

	function grve_blade_vce_gallery_shortcode( $attr, $content ) {

		$output = $start_block = $end_block = $item_class = $class_fullwidth = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'ids' => '',
					'gallery_type' => 'grid',
					'grid_image_mode' => 'square',
					'image_link_mode' => 'popup',
					'image_popup_size' => 'extra-extra-large',
					'carousel_image_mode' => 'landscape',
					'carousel_popup' => '',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'item_gutter' => 'yes',
					'gutter_size' => '40',
					'hide_image_title' => '',
					'hide_image_caption' => '',
					'image_hover_style' => 'hover-style-1',
					'zoom_effect' => 'none',
					'overlay_color' => 'light',
					'overlay_opacity' => '90',
					'items_per_page' => '4',
					'slideshow_speed' => '3000',
					'auto_play' => 'yes',
					'navigation_type' => '1',
					'navigation_color' => 'dark',
					'pause_hover' => 'no',
					'carousel_pagination' => 'no',
					'carousel_pagination_type' => '1',
					'carousel_pagination_speed' => '400',
					'animation' => 'zoomIn',
					'margin_bottom' => '',
					'el_class' => '',
					'custom_links' => '',
					'custom_links_target' => '_self',
				),
				$attr
			)
		);

		if ( !empty( $animation ) ) {
			$animation = 'grve-' .$animation;
		}

		$attachments = explode( ",", $ids );

		if ( empty( $attachments ) ) {
			return '';
		}

		//Gallery Classes
		$gallery_classes = array( 'grve-element', 'grve-gallery' , 'grve-isotope' );

		if ( 'custom_link' == $image_link_mode ) {
			$custom_links = vc_value_from_safe( $custom_links );
			$custom_links = explode( ',', $custom_links );
		} elseif ( 'popup' == $image_link_mode ) {
			array_push( $gallery_classes, 'grve-gallery-popup' );
		}

		//Gallery Carousel Classes
		$gallery_carousel_classes = array( 'grve-element', 'grve-carousel-wrapper' );

		if ( !empty( $el_class ) ) {
			array_push( $gallery_classes, $el_class);
		}

		//Gallery Title & Caption Color
		$text_color = 'light';
		if( 'light' == $overlay_color ) {
			$text_color = 'dark';
		}

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$data_string = '';

		switch( $gallery_type ) {
			case 'masonry':
				$data_string = ' data-columns="' . esc_attr( $columns ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="masonry"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $gallery_classes, 'grve-with-gap' );
				}
				break;
			case 'carousel':
				$data_string = ' data-items="' . esc_attr( $items_per_page ) . '" data-slider-autoplay="' . esc_attr( $auto_play ) . '" data-slider-speed="' . esc_attr( $slideshow_speed ) . '" data-slider-pause="' . esc_attr( $pause_hover ) . '"';
				$data_string .= ' data-pagination-speed="' . esc_attr( $carousel_pagination_speed ) . '"';
				$data_string .= ' data-pagination="' . esc_attr( $carousel_pagination ) . '"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $gallery_carousel_classes, 'grve-with-gap' );
				}
				if ( 'yes' == $carousel_pagination ) {
					array_push( $gallery_carousel_classes, 'grve-carousel-pagination-' . $carousel_pagination_type  );
				}
				break;
			case 'grid':
			default:
				$data_string = ' data-columns="' . esc_attr( $columns ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $gallery_classes, 'grve-with-gap' );
				}
				break;
		}
		$gallery_class_string = implode( ' ', $gallery_classes );
		$gallery_carousel_class_string = implode( ' ', $gallery_carousel_classes );


		$image_popup_size_mode = grve_blade_vce_get_image_size( $image_popup_size );

		if ( 'carousel' == $gallery_type ) {
			//Gallery Output ( carousel)

			if( 'square' == $carousel_image_mode ) {
				$image_size = 'blade-grve-small-square';
			} elseif( 'portrait' == $carousel_image_mode ) {
				$image_size = 'blade-grve-small-rect-vertical';
			} else {
				$image_size = 'blade-grve-small-rect-horizontal';
			}


			$output .= '<div class="' . esc_attr( $gallery_carousel_class_string ) . '" style="' . $style . '">';

			//Carousel Navigation
			$output .= grve_blade_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );

			$output .= '	<div class="grve-carousel grve-gallery-popup grve-carousel-element ' . esc_attr( $el_class ) . '"' . $data_string . '>

			';

				foreach ( $attachments as $id ) {
					$full_src = wp_get_attachment_image_src( $id, 'blade-grve-fullscreen' );
					$image_title = get_post_field( 'post_title', $id );
					$caption = get_post_field( 'post_excerpt', $id );
					$link_data = '';
					if ( !empty( $image_title ) && 'yes' != $hide_image_title  ) {
						$link_data .= ' data-title="' . esc_attr( $image_title ) . '"';
					}
					if ( !empty( $caption ) && 'yes' != $hide_image_caption ) {
						$link_data .= ' data-desc="' . esc_attr( $caption ) . '"';
					}

					$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );

					$output .= '<div class="grve-carousel-item">';
					if ( 'yes' == $carousel_popup ) {
					$output .= '  <a href="' . esc_url( $full_src[0] ) . '" ' . $link_data . '>';
					}
					$output .= '<figure class="grve-image-hover">';
					$output .= '<div class="grve-media">';
					$output .= wp_get_attachment_image( $id, $image_size );
					$output .= '</div>';
					$output .= '</figure>';

					if ( 'yes' == $carousel_popup ) {
					$output .= '  </a>';
					}
					$output .= '</div>';

				}
			$output .= '	</div>';
			$output .= '</div>';
		} else {
			//Gallery Output ( grid / masonry)
			$output .= '<div class="' . esc_attr( $gallery_class_string ) . '" style="' . $style . '"' . $data_string . '>';
			$output .= '  <div class="grve-isotope-container">';

			$gallery_index = 0;
			$i = -1;
			$image_size = 'blade-grve-small-square';
			$image_size_class = '';

			foreach ( $attachments as $id ) {
				$gallery_index++;
				$i++;

				if ( 'masonry' == $gallery_type ) {

					$grve_masonry_data = grve_blade_vce_get_masonry_data( $gallery_index, $columns );
					$image_size_class = ' ' . $grve_masonry_data['class'];
					$image_size = $grve_masonry_data['image_size'];

				} else {
					//Grid - Default
					if ( 'resize' == $grid_image_mode || 'large' == $grid_image_mode ) {
						$image_size = 'large';
					} elseif( 'medium_large' == $grid_image_mode ) {
						$image_size = 'medium_large';
					} elseif( 'medium' == $grid_image_mode ) {
						$image_size = 'medium';
					} elseif( 'square' == $grid_image_mode ) {
						$image_size = 'blade-grve-small-square';
					} elseif( 'portrait' == $grid_image_mode ) {
						$image_size = 'blade-grve-small-rect-vertical';
					} else {
						$image_size = 'blade-grve-small-rect-horizontal';
					}
				}

				$full_src = wp_get_attachment_image_src( $id, $image_popup_size_mode );
				$image_title = get_post_field( 'post_title', $id );
				$caption = get_post_field( 'post_excerpt', $id );

				$output .= '<div class="grve-isotope-item grve-gallery-item ' . $image_size_class . '">';
				if ( 'popup' == $image_link_mode ) {
					$output .= '  <a href="' . esc_url( $full_src[0] ) . '">';
				} elseif ( 'custom_link' == $image_link_mode && isset( $custom_links[ $i ] ) && !empty(  $custom_links[ $i ] )  ) {
					$output .= '<a href="' . esc_url( $custom_links[ $i ] ) . '" target="' . esc_attr( $custom_links_target ) . '">';
				}
				if ( !empty( $animation ) ) {
					$output .= '<div class="grve-isotope-item-inner ' . esc_attr( $animation ) . '">';
				}
				$output .= '    <figure class="grve-' . esc_attr( $image_hover_style ) . ' grve-image-hover grve-zoom-' . esc_attr( $zoom_effect ) . '">';
				$output .= '      <div class="grve-media">';
				$output .= '        <div class="grve-hover-overlay grve-bg-' . esc_attr( $overlay_color ) . ' grve-opacity-' . esc_attr( $overlay_opacity ) . '"></div>';
				$output .= wp_get_attachment_image( $id, $image_size );
				$output .= '      </div>';
				$output .= '      <figcaption>';
				$output .= '        <div class="grve-gallery-content">';

						if ( !empty( $image_title ) && 'yes' != $hide_image_title  ) {
							if( 'hover-style-2' == $image_hover_style ) {
								$output .= '<h6 class="grve-title grve-text-hover-primary-1">' . wptexturize( $image_title ) . '</h6>';
							} else {
								$output .= '<h6 class="grve-title grve-text-' . esc_attr( $text_color ) . '">' . wptexturize( $image_title ) . '</h6>';
							}
						}

						if ( !empty( $caption ) && 'yes' != $hide_image_caption ) {
							if( 'hover-style-2' == $image_hover_style ) {
								$output .= '<span class="grve-caption grve-text-content">' . wptexturize( $caption ) . '</span>';
							} else {
								$output .= '<span class="grve-caption grve-text-' . esc_attr( $text_color ) . '">' . wptexturize( $caption ) . '</span>';
							}
						}

				$output .= '        </div>';
				$output .= '      </figcaption>';
				$output .= '    </figure>';
				if ( !empty( $animation ) ) {
					$output .= '</div>';
				}
				if ( 'popup' == $image_link_mode ) {
					$output .= '  </a>';
				} elseif ( 'custom_link' == $image_link_mode && isset( $custom_links[ $i ] ) && !empty(  $custom_links[ $i ] )  ) {
					$output .= '  </a>';
				}
				$output .= '</div>';

			}

			$output .= '  </div>';
			$output .= '</div>';
		}


		return $output;

	}
	add_shortcode( 'grve_gallery', 'grve_blade_vce_gallery_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_gallery_shortcode_params' ) ) {
	function grve_blade_vce_gallery_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Gallery", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Numerous styles, multiple columns for galleries", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-gallery",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Gallery type", "grve-blade-vc-extension" ),
					"param_name" => "gallery_type",
					"value" => array(
						esc_html__( "Grid", "grve-blade-vc-extension" ) => 'grid',
						esc_html__( "Masonry", "grve-blade-vc-extension" ) => 'masonry',
						esc_html__( "Carousel", "grve-blade-vc-extension" ) => 'carousel',
					),
					"description" => esc_html__( "Select your gallery type.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Grid Image Mode", "grve-blade-vc-extension" ),
					"param_name" => "grid_image_mode",
					'value' => array(
						esc_html__( 'Square Crop', 'grve-blade-vc-extension' ) => 'square',
						esc_html__( 'Landscape Crop', 'grve-blade-vc-extension' ) => 'landscape',
						esc_html__( 'Portrait Crop', 'grve-blade-vc-extension' ) => 'portrait',
						esc_html__( 'Resize ( Large )', 'grve-blade-vc-extension' ) => 'resize',
						esc_html__( 'Resize ( Medium Large )', 'grve-blade-vc-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'grve-blade-vc-extension' ) => 'medium',
					),
					'std' => 'square',
					"description" => esc_html__( "Select your Grid Image Mode.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Image Mode", "grve-blade-vc-extension" ),
					"param_name" => "carousel_image_mode",
					'value' => array(
						esc_html__( 'Square Crop', 'grve-blade-vc-extension' ) => 'square',
						esc_html__( 'Landscape Crop', 'grve-blade-vc-extension' ) => 'landscape',
						esc_html__( 'Portrait Crop', 'grve-blade-vc-extension' ) => 'portrait',
					),
					'std' => 'landscape',
					"description" => esc_html__( "Select your Carousel Image Mode.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type"			=> "attach_images",
					"admin_label"	=> true,
					"class"			=> "",
					"heading"		=> esc_html__( "Attach Images", "grve-blade-vc-extension" ),
					"param_name"	=> "ids",
					"value" => '',
					"description"	=> esc_html__( "Select your gallery images.", "grve-blade-vc-extension" ),
				),
				//Gallery ( grid /masonry )
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select number of columns.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2', '3' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Gutter between images", "grve-blade-vc-extension" ),
					"param_name" => "item_gutter",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"description" => esc_html__( "Add gutter among images.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Gutter Size", "grve-blade-vc-extension" ),
					"param_name" => "gutter_size",
					"value" => '40',
					"dependency" => array( 'element' => "item_gutter", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Image Title", "grve-blade-vc-extension" ),
					"param_name" => "hide_image_title",
					"value" => array( esc_html__( "If selected, image title will be hidden", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Image Caption", "grve-blade-vc-extension" ),
					"param_name" => "hide_image_caption",
					"value" => array( esc_html__( "If selected, image caption will be hidden", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Image Link Mode", "grve-blade-vc-extension" ),
					"param_name" => "image_link_mode",
					"value" => array(
						esc_html__( "Image Popup", "grve-blade-vc-extension" ) => 'popup',
						esc_html__( "None", "grve-blade-vc-extension" ) => 'none',
						esc_html__( "Custom Link", "grve-blade-vc-extension" ) => 'custom_link',
					),
					"description" => esc_html__( "Choose the image link mode.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
					'std' => 'popup',
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
					"heading" => esc_html__( "Hover Style", "grve-blade-vc-extension" ),
					"param_name" => "image_hover_style",
					'value' => array(
						esc_html__( 'Style 1' , 'grve-blade-vc-extension' ) => 'hover-style-1',
						esc_html__( 'Style 2' , 'grve-blade-vc-extension' ) => 'hover-style-2',
						esc_html__( 'Style 3' , 'grve-blade-vc-extension' ) => 'hover-style-3',
					),
					"description" => esc_html__( "Select hover style for your image.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
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
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
					'std' => 'none',
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
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "grve-blade-vc-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				//Gallery ( carousel )
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items per page", "grve-blade-vc-extension" ),
					"param_name" => "items_per_page",
					"value" => array( '3', '4', '5', '6' ),
					"description" => esc_html__( "Number of images per page", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
					"std" => "4",
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Carousel Image Popup", "grve-blade-vc-extension" ),
					"param_name" => "carousel_popup",
					"value" => array( esc_html__( "Enable carousel image popup", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "grve-blade-vc-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "grve-blade-vc-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "grve-blade-vc-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, carousel will be paused on hover", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
				),
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
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Pagination", "grve-blade-vc-extension" ),
					"param_name" => "carousel_pagination",
					"value" => array(
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
					),
					"std" => "no",
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Pagination Type", "grve-blade-vc-extension" ),
					"param_name" => "carousel_pagination_type",
					'value' => array(
						esc_html__( 'Bullet' , 'grve-blade-vc-extension' ) => '1',
						esc_html__( 'Dashed' , 'grve-blade-vc-extension' ) => '2',
					),
					"description" => esc_html__( "Select your carousel pagination type.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "carousel_pagination", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Carousel Pagination Speed", "grve-blade-vc-extension" ),
					"param_name" => "carousel_pagination_speed",
					"value" => '400',
					"description" => esc_html__( "Pagination Speed in ms.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation", "grve-blade-vc-extension"),
					"param_name" => "animation",
					"admin_label" => true,
					"value" => array(
						esc_html__( "No", "grve-blade-vc-extension" ) => '',
						esc_html__( "Fade In", "grve-blade-vc-extension" ) => "fadeIn",
						esc_html__( "Fade In Up", "grve-blade-vc-extension" ) => "fadeInUp",
						esc_html__( "Fade In Down", "grve-blade-vc-extension" ) => "fadeInDown",
						esc_html__( "Fade In Left", "grve-blade-vc-extension" ) => "fadeInLeft",
						esc_html__( "Fade In Right", "grve-blade-vc-extension" ) => "fadeInRight",
						esc_html__( "Zoom In", "grve-blade-vc-extension" ) => "zoomIn",
					),
					"dependency" => array( 'element' => "gallery_type", 'value' => array( 'grid', 'masonry' ) ),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "grve-blade-vc-extension" ),
					"std" => "zoomIn",
				),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_gallery', 'grve_blade_vce_gallery_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_gallery_shortcode_params( 'grve_gallery' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
