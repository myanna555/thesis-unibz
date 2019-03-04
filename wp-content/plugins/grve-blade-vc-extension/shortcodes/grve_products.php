<?php
/**
 * Product Shortcode
 */

if( !function_exists( 'grve_blade_vce_products_shortcode' ) ) {

	function grve_blade_vce_products_shortcode( $attr, $content ) {

		$product_row_start = $allow_filter = $class_fullwidth = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'product_style' => 'grid',
					'heading_tag' => 'h2',
					'heading' => 'h5',
					'heading_auto_size' => 'no',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'grid_image_mode' => 'landscape',
					'carousel_image_mode' => 'landscape',
					'product_filter' => '',
					'product_filter_align' => 'left',
					'filter_order_by' => '',
					'filter_order' => 'ASC',
					'item_gutter' => 'yes',
					'gutter_size' => '40',
					'item_spinner' => 'no',
					'items_per_page' => '4',
					'items_to_show' => '12',
					'second_image_effect' => 'yes',
					'zoom_effect' => 'none',
					'overlay_color' => 'light',
					'overlay_opacity' => '90',
					'order_by' => 'date',
					'order' => 'DESC',
					'disable_pagination' => '',
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
				),
				$attr
			)
		);

		if ( !empty( $animation ) ) {
			$animation = 'grve-' .$animation;
		}

		$product_classes = array( 'grve-element', 'woocommerce' );
		$data_string = '';

		switch( $product_style ) {
			case 'carousel':
				$data_string = ' data-items="' . esc_attr( $items_per_page ) . '" data-slider-autoplay="' . esc_attr( $auto_play ) . '" data-slider-speed="' . esc_attr( $slideshow_speed ) . '" data-slider-pause="' . esc_attr( $pause_hover ) . '"';
				$data_string .= ' data-pagination-speed="' . esc_attr( $carousel_pagination_speed ) . '"';
				$data_string .= ' data-pagination="' . esc_attr( $carousel_pagination ) . '"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				array_push( $product_classes, 'grve-carousel-wrapper' );

				if ( 'yes' == $item_gutter ) {
					array_push( $product_classes, 'grve-with-gap' );
				}
				if ( 'yes' == $carousel_pagination ) {
					array_push( $product_classes, 'grve-carousel-pagination-' . $carousel_pagination_type  );
				}
				$disable_pagination = 'yes';
				break;
			case 'grid':
			default:
				$product_row_start = '<div class="grve-isotope-container">';
				$data_string = ' data-spinner="' . esc_attr( $item_spinner ) . '" data-columns="' . esc_attr( $columns ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $product_classes, 'grve-with-gap' );
				}
				array_push( $product_classes, 'grve-product' );
				array_push( $product_classes, 'grve-isotope' );
				$allow_filter = 'yes';
				break;
		}

		$isotope_inner_item_classes = array( 'grve-isotope-item-inner' );

		if ( !empty( $animation ) ) {
			array_push( $isotope_inner_item_classes, $animation);
		}
		$isotope_inner_item_class_string = implode( ' ', $isotope_inner_item_classes );


		if ( !empty ( $el_class ) ) {
			array_push( $product_classes, $el_class);
		}
		$product_class_string = implode( ' ', $product_classes );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$product_cat = "";
		$product_category_ids = array();

		if( ! empty( $categories ) ) {
			$product_category_ids = explode( ",", $categories );
			foreach ( $product_category_ids as $category_id ) {
				$category_term = get_term( $category_id, 'product_cat' );
				if ( isset( $category_term) ) {
					$product_cat = $product_cat.$category_term->slug . ', ';
				}
			}
		}

		$paged = 1;

		if ( 'yes' != $disable_pagination ) {
			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			}
		}

		$exclude_ids = array();
		if( !empty( $exclude_posts ) ){
			$exclude_ids = explode( ',', $exclude_posts );
		}

		$include_ids = array();
		if( !empty( $include_posts ) ){
			$include_ids = explode( ',', $include_posts );
			$args = array(
				'post_type' => 'product',
				'post_status'=>'publish',
				'paged' => $paged,
				'post__in' => $include_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
			$product_filter = 'no';
		} else {
			$args = array(
				'post_type' => 'product',
				'post_status'=>'publish',
				'paged' => $paged,
				'product_cat' => $product_cat,
				'post__not_in' => $exclude_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
		}

		$query = new WP_Query( $args );
		ob_start();
		if ( $query->have_posts() ) :
		?>
			<div class="<?php echo esc_attr( $product_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data_string; ?>>
		<?php

		if ( 'yes' == $product_filter && 'yes' == $allow_filter ) {

			$category_prefix = '.product_cat-';
			$category_filter_list = array();
			$category_filter_array = array();
			$all_string =  apply_filters( 'blade_grve_vce_product_string_all_categories', esc_html__( 'All', 'grve-blade-vc-extension' ) );
			$category_filter_string = '<li data-filter="*" class="selected"><span>' . esc_html( $all_string ) . '</span></li>';
			$category_filter_add = false;
			while ( $query->have_posts() ) : $query->the_post();

				if ( $product_categories = get_the_terms( get_the_ID(), 'product_cat' ) ) {

					foreach($product_categories as $category_term){
						$category_filter_add = false;
						if ( !in_array($category_term->term_id, $category_filter_list) ) {
							if( ! empty( $product_category_ids ) ) {
								if ( in_array($category_term->term_id, $product_category_ids) ) {
									$category_filter_add = true;
								}
							} else {
								$category_filter_add = true;
							}
							if ( $category_filter_add ) {
								$category_filter_list[] = $category_term->term_id;
								if ( 'title' == $filter_order_by ) {
									$category_filter_array[$category_term->name] = $category_term;
								} elseif ( 'slug' == $filter_order_by )  {
									$category_filter_array[$category_term->slug] = $category_term;
								} else {
									$category_filter_array[$category_term->term_id] = $category_term;
								}
							}
						}
					}
				}

			endwhile;


			if ( count( $category_filter_array ) > 1 ) {
				if ( '' != $filter_order_by ) {
					if ( 'ASC' == $filter_order ) {
						ksort( $category_filter_array );
					} else {
						krsort( $category_filter_array );
					}
				}
				foreach($category_filter_array as $category_filter){				
					$term_class = sanitize_html_class( $category_filter->slug, $category_filter->term_id );
					if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
						$term_class = $category_filter->term_id;
					}				
					$category_filter_string .= '<li data-filter="' . $category_prefix . $term_class . '"><span>' . $category_filter->name . '</span></li>';
				}
		?>
				<div class="grve-filter grve-link-text grve-list-divider grve-align-<?php echo esc_attr( $product_filter_align ); ?>">
					<ul>
						<?php echo $category_filter_string; ?>
					</ul>
				</div>
		<?php
			}
		}
		?>

			<?php echo $product_row_start; ?>

		<?php

		if ( 'carousel' == $product_style ) {

			//Carousel Navigation
			echo grve_blade_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );
?>
			<div class="grve-carousel grve-carousel-element grve-product"<?php echo $data_string; ?>>
<?php
		}

		$product_index = 0;

		while ( $query->have_posts() ) : $query->the_post();
			$image_size = 'blade-grve-small-rect-horizontal';
			$product_index++;
			$product_extra_class = '';


			if ( 'carousel' != $product_style ) {
				$image_size = 'blade-grve-small-square';
				$product_extra_class = 'grve-isotope-item grve-product-item ';
				//Grid - Default
				$image_size = grve_blade_vce_get_image_size ( $grid_image_mode );
			} else {
				$image_size = grve_blade_vce_get_image_size ( $carousel_image_mode );
				$product_extra_class = 'grve-product-item';
				echo '<div class="grve-carousel-item">';
			}

			//Second Image Classes
			$image_classes = array();
			$image_classes[] = 'attachment-' . $image_size;
			$image_classes[] = 'size-' . $image_size;
			$image_classes[] = 'grve-product-thumbnail-second';
			$image_class_string = implode( ' ', $image_classes );

			//Second Product Image
			global $product;

			if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
				$attachment_ids = $product->get_gallery_image_ids();
			} else {
				$attachment_ids = $product->get_gallery_attachment_ids();
			}
			$product_thumb_second_id = '';

			if ( $attachment_ids ) {
				$loop = 0;
				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id );
					if (!$image_link) {
						continue;
					}
					$loop++;
					$product_thumb_second_id = $attachment_id;
					if ($loop == 1) {
						break;
					}
				}
			}
?>
					<article id="product-<?php the_ID(); ?><?php echo uniqid('-'); ?>" <?php post_class( $product_extra_class ); ?>>
						<div class="grve-product-media grve-image-hover">
							<a href="<?php echo esc_url( get_permalink() ); ?>">

									<?php
										woocommerce_show_product_loop_sale_flash();
										if ( has_post_thumbnail() ) {
											the_post_thumbnail( $image_size );
										} elseif ( wc_placeholder_img_src() ) {
											echo wc_placeholder_img( $image_size );
										}
										if ( 'yes' == $second_image_effect && !empty( $product_thumb_second_id ) ) {
											echo wp_get_attachment_image( $product_thumb_second_id, $image_size , "", array( 'class' => $image_class_string ) );
										}
									?>
									<<?php echo tag_escape( $heading_tag ); ?> class="grve-title grve-<?php echo esc_attr( $heading ); ?>"><?php the_title(); ?></<?php echo tag_escape( $heading_tag ); ?>>
							</a>
							<?php woocommerce_template_loop_rating(); ?>
							<div class="grve-product-content">
								<div class="grve-product-switcher">
									<div class="grve-product-price grve-link-text">
										<?php woocommerce_template_loop_price(); ?>
									</div>
									<div class="grve-add-to-cart-btn grve-link-text">
										<?php woocommerce_template_loop_add_to_cart(); ?>
									</div>
								</div>
							</div>
						</div>
					</article>
<?php
			if ( 'carousel' == $product_style ) {
				echo '</div>';
			}

		endwhile;

		?>
				</div>
<?php
			if ( 'yes' != $disable_pagination ) {
				$total = $query->max_num_pages;
				$big = 999999999; // need an unlikely integer
				if( $total > 1 )  {
					 echo '<div class="grve-pagination grve-link-text">';

					 if( get_option('permalink_structure') ) {
						 $format = 'page/%#%/';
					 } else {
						 $format = '&paged=%#%';
					 }
					 echo paginate_links(array(
						'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'		=> $format,
						'current'		=> max( 1, $paged ),
						'total'			=> $total,
						'mid_size'		=> 2,
						'type'			=> 'list',
						'prev_text'	=> '<i class="grve-icon-arrow-left"></i>',
						'next_text'	=> '<i class="grve-icon-arrow-right"></i>',
						'add_args' => false,
					 ));
					 echo '</div>';
				}
			}
?>
			</div>

		<?php

		else :
		endif;
		wp_reset_postdata();

		return ob_get_clean();

	}
	add_shortcode( 'grve_products', 'grve_blade_vce_products_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_products_shortcode_params' ) ) {
	function grve_blade_vce_products_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Products", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Display Product element in multiple styles", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-product",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Style", "grve-blade-vc-extension" ),
					"param_name" => "product_style",
					"admin_label" => true,
					'value' => array(
						esc_html__( 'Grid' , 'grve-blade-vc-extension' ) => 'grid',
						esc_html__( 'Carousel' , 'grve-blade-vc-extension' ) => 'carousel',
					),
					"description" => esc_html__( "Select a style for your product", "grve-blade-vc-extension" ),
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
					'std' => 'landscape',
					"description" => esc_html__( "Select your Grid Image Mode.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
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
					"dependency" => array( 'element' => "product_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 4,
					"description" => esc_html__( "Select your Porfolio Columns.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Filter", "grve-blade-vc-extension" ),
					"param_name" => "product_filter",
					"description" => esc_html__( "If selected, an isotope filter will be displayed.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Enable Product Filter ( Only for All or Multiple Categories )", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order By", "grve-blade-vc-extension" ),
					"param_name" => "filter_order_by",
					"value" => array(
						esc_html__( "Default ( Unordered )", "grve-blade-vc-extension" ) => '',
						esc_html__( "ID", "grve-blade-vc-extension" ) => 'id',
						esc_html__( "Slug", "grve-blade-vc-extension" ) => 'slug',
						esc_html__( "Title", "grve-blade-vc-extension" ) => 'title',
					),
					"description" => '',
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order", "grve-blade-vc-extension" ),
					"param_name" => "filter_order",
					"value" => array(
						esc_html__( "Ascending", "grve-blade-vc-extension" ) => 'ASC',
						esc_html__( "Descending", "grve-blade-vc-extension" ) => 'DESC',
					),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
					"description" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Alignment", "grve-blade-vc-extension" ),
					"param_name" => "product_filter_align",
					"value" => array(
						esc_html__( "Left", "grve-blade-vc-extension" ) => 'left',
						esc_html__( "Right", "grve-blade-vc-extension" ) => 'right',
						esc_html__( "Center", "grve-blade-vc-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Loader", "grve-blade-vc-extension" ),
					"param_name" => "item_spinner",
					"description" => esc_html__( "If selected, this will enable a graphic spinner before load.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Enable Loader.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Disable Pagination", "grve-blade-vc-extension" ),
					"param_name" => "disable_pagination",
					"description" => esc_html__( "If selected, pagination will not be shown.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Disable Pagination.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items per page", "grve-blade-vc-extension" ),
					"param_name" => "items_per_page",
					"value" => array( '3', '4', '5' ),
					"description" => esc_html__( "Number of images per page", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'carousel' ) ),
					"std" => "4",
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
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid', 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Gutter Size", "grve-blade-vc-extension" ),
					"param_name" => "gutter_size",
					"value" => '40',
					"dependency" => array( 'element' => "item_gutter", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Items to show", "grve-blade-vc-extension" ),
					"param_name" => "items_to_show",
					"value" => '12',
					"description" => esc_html__( "Maximum Product Items to Show", "grve-blade-vc-extension" ),
				),
				grve_blade_vce_get_heading_tag( "h2" ),
				grve_blade_vce_get_heading( "h5" ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Second Image Effect", "grve-blade-vc-extension" ),
					"param_name" => "second_image_effect",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"description" => esc_html__( "Choose if you want second image effect.", "grve-blade-vc-extension" ),
					'std' => 'yes',
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
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid', 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "grve-blade-vc-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid', 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "grve-blade-vc-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "grve-blade-vc-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "grve-blade-vc-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, carousel will be paused on hover", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "product_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "product_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "product_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "product_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "product_style", 'value' => array( 'carousel' ) ),
				),
				grve_blade_vce_add_order_by(),
				grve_blade_vce_add_order(),
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
					"dependency" => array( 'element' => "product_style", 'value' => array( 'grid' ) ),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "grve-blade-vc-extension" ),
					"std" => "zoomIn",
				),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Exclude Posts", "grve-blade-vc-extension" ),
					"param_name" => "exclude_posts",
					"value" => '',
					"description" => esc_html__( "Type the post ids you want to exclude separated by comma ( , ).", "grve-blade-vc-extension" ),
					"group" => esc_html__( "Categories", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "grve_multi_checkbox",
					"heading" => __("Product Categories", "grve-blade-vc-extension" ),
					"param_name" => "categories",
					"value" => grve_blade_vce_get_product_categories(),
					"description" => esc_html__( "Select all or multiple categories.", "grve-blade-vc-extension" ),
					"admin_label" => true,
					"group" => esc_html__( "Categories", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Include Specific Posts", "grve-blade-vc-extension" ),
					"param_name" => "include_posts",
					"value" => '',
					"description" => esc_html__( "Type the specific post ids you want to include separated by comma ( , ). Note: If you define specific post ids, Exclude Posts and Categories will have no effect.", "grve-blade-vc-extension" ),
					"group" => esc_html__( "Categories", "grve-blade-vc-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_products', 'grve_blade_vce_products_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_products_shortcode_params( 'grve_products' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
