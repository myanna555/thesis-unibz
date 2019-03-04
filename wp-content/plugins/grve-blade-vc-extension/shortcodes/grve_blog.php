<?php
/**
 * Blog Shortcode
 */

if( !function_exists( 'grve_blade_vce_blog_shortcode' ) ) {

	function grve_blade_vce_blog_shortcode( $atts, $content ) {

		$output = $allow_filter = $el_class = $data_string = '';

		extract(
			shortcode_atts(
				array(
					'categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'blog_style' => 'blog-large',
					'blog_item_style' => '1',
					'heading_tag' => 'h2',
					'heading' => 'auto',
					'blog_media_area' => 'yes',
					'blog_mode' => 'no-shadow-mode',
					'blog_image_mode' => '',
					'blog_masonry_image_mode' => 'large',
					'carousel_image_mode' => 'landscape',
					'blog_image_prio' => '',
					'columns' => '4',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'item_gutter' => 'yes',
					'gutter_size' => '40',
					'auto_excerpt' => '',
					'excerpt_length' => '55',
					'excerpt_more' => '',
					'hide_author' => '',
					'hide_date' => '',
					'hide_comments' => '',
					'hide_like' => '',
					'hide_excerpt' => '',
					'posts_per_page' => '10',
					'order_by' => 'date',
					'order' => 'DESC',
					'disable_pagination' => '',
					'blog_filter' => '',
					'blog_filter_align' => 'left',
					'filter_order_by' => '',
					'filter_order' => 'ASC',
					'item_spinner' => 'no',
					'items_per_page' => '4',
					'slideshow_speed' => '3000',
					'navigation_type' => '1',
					'navigation_color' => 'dark',
					'pause_hover' => 'no',
					'auto_play' => 'yes',
					'carousel_pagination' => 'no',
					'carousel_pagination_type' => '1',
					'carousel_pagination_speed' => '400',
					'animation' => 'zoomIn',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$atts
			)
		);

		if ( !empty( $animation ) ) {
			$animation = 'grve-' .$animation;
		}

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$blog_classes = array( 'grve-element' );


		switch( $blog_style ) {

			case 'masonry':
				$data_string .= 'data-columns="' . esc_attr( $columns ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="masonry" data-spinner="' . esc_attr( $item_spinner ) . '"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				$blog_classes[] = 'grve-style-' . $blog_item_style;
				break;
			case 'grid':
				$data_string .= 'data-columns="' . esc_attr( $columns ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows" data-spinner="' . esc_attr( $item_spinner ) . '"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				$blog_classes[] = 'grve-style-' . $blog_item_style;
				break;
			case 'carousel':
				if ( 'yes' == $item_gutter ) {
					$blog_classes[] = 'grve-with-gap';
				}
				if ( 'yes' == $carousel_pagination ) {
					$blog_classes[] = 'grve-carousel-pagination-' . $carousel_pagination_type;
				}
				break;
			default:
				$data_string .= '';
				break;
		}

		array_push( $blog_classes, grve_blade_vce_get_blog_class( $blog_style ) );
		if ( !empty ( $el_class ) ) {
			array_push( $blog_classes, $el_class);
		}
		if ( 'shadow-mode' == $blog_mode && ( 'masonry' == $blog_style || 'grid' == $blog_style ) ) {
			array_push( $blog_classes, 'grve-with-shadow' );
		}
		$blog_class_string = implode( ' ', $blog_classes );

		$show_top_post_meta = $show_bottom_post_meta = false;
		if ( 'yes' != $hide_author || 'yes' != $hide_date || 'yes' != $hide_comments || 'yes' != $hide_like ) {
			if ( '1' == $blog_item_style || ( 'masonry' != $blog_style && 'grid' != $blog_style ) ) {
				$show_top_post_meta = true;
			} else {
				$show_bottom_post_meta = true;
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
				'post_type' => 'post',
				'post_status'=>'publish',
				'posts_per_page' => $posts_per_page,
				'post__in' => $include_ids,
				'paged' => $paged,
				'ignore_sticky_posts' => 1,
				'orderby' => $order_by,
				'order' => $order,
			);
			$blog_filter = 'no';
		} else {
			$args = array(
				'post_type' => 'post',
				'post_status'=>'publish',
				'posts_per_page' => $posts_per_page,
				'post__not_in' => $exclude_ids,
				'cat' => $categories,
				'paged' => $paged,
				'ignore_sticky_posts' => 1,
				'orderby' => $order_by,
				'order' => $order,
			);
		}

		$query = new WP_Query( $args );

		$blog_category_ids = array();

		if( ! empty( $categories ) ) {
			$blog_category_ids = explode( ",", $categories );
		}
		if ( 'carousel' != $blog_style ) {
			$allow_filter = 'yes';
		}

		if ( 'masonry' == $blog_style ) {
			$blog_image_mode = $blog_masonry_image_mode;
		}

		$category_prefix = '.category-';

		ob_start();

		if ( $query->have_posts() ) :

?>
		<div class="<?php echo esc_attr( $blog_class_string ); ?>" style="<?php echo $style; ?>" <?php echo $data_string; ?>>
<?php
		//Category Filter
		if ( 'yes' == $blog_filter && 'yes' == $allow_filter ) {

			$category_filter_list = array();
			$category_filter_array = array();
			$all_string =  apply_filters( 'blade_grve_vce_blog_string_all_categories', esc_html__( 'All', 'grve-blade-vc-extension' ) );
			$category_filter_string = '<li data-filter="*" class="selected"><span>' . $all_string . '</span></li>';
			$category_filter_add = false;
			while ( $query->have_posts() ) : $query->the_post();

				if ( $blog_categories = get_the_terms( get_the_ID(), 'category' ) ) {

					foreach($blog_categories as $category_term){
						$category_filter_add = false;
						if ( !in_array($category_term->term_id, $category_filter_list) ) {
							if( ! empty( $blog_category_ids ) ) {
								if ( in_array($category_term->term_id, $blog_category_ids) ) {
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
				<div class="grve-filter grve-link-text grve-list-divider grve-align-<?php echo esc_attr( $blog_filter_align ); ?>">
					<ul>
						<?php echo $category_filter_string; ?>
					</ul>
				</div>
		<?php
			}
		}
		if ( 'blog-large' == $blog_style || 'blog-small' == $blog_style ) {
?>
			<div class="grve-standard-container">
<?php
		} else if ( 'carousel' == $blog_style ) {
			$disable_pagination = 'yes';
			$data_string = ' data-items="' . esc_attr( $items_per_page ) . '" data-slider-speed="' . esc_attr( $slideshow_speed ) . '" data-slider-pause="' . esc_attr( $pause_hover ) . '"';
			$data_string .= ' data-pagination-speed="' . esc_attr( $carousel_pagination_speed ) . '"';
			$data_string .= ' data-pagination="' . esc_attr( $carousel_pagination ) . '"';
			$data_string .= ' data-slider-autoplay="' . esc_attr( $auto_play ) . '"';
			if ( 'yes' == $item_gutter ) {
				$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
			}
			//Carousel Navigation
			echo grve_blade_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );

			?>

			<div class="grve-carousel grve-blog-carousel grve-carousel-element"<?php echo $data_string; ?>>
<?php
		} else {
?>
			<div class="grve-isotope-container">
<?php
		}

		$grve_isotope_start = $grve_isotope_end = '';
		if ( 'blog-large' != $blog_style && 'blog-small' != $blog_style ) {
			if ( !empty( $animation ) ) {
				$grve_isotope_start = '<div class="grve-isotope-item-inner ' . esc_attr( $animation ) . '">';
			} else {
				$grve_isotope_start = '<div class="grve-isotope-item-inner">';
			}
			$grve_isotope_end = '</div>';
		} else {
			if ( !empty( $animation ) ) {
				$grve_isotope_start = '<div class="grve-animated-item ' . esc_attr( $animation ) . '" data-delay="200">';
				$grve_isotope_end = '</div>';
			}
		}

		while ( $query->have_posts() ) : $query->the_post();

			$post_format = get_post_format();
			if ( 'link' == $post_format || 'quote' == $post_format ) {
				$grve_post_class = grve_blade_vce_get_post_class( $blog_style, 'grve-label-post' );
			} else {
				$grve_post_class = grve_blade_vce_get_post_class( $blog_style );
			}

			if ( 'carousel' == $blog_style ) {

?>
				<div class="grve-carousel-item">
					<article <?php post_class( 'grve-post-item' ); ?> itemscope itemType="http://schema.org/BlogPosting">
						<?php
							if ( 'yes' == $blog_media_area ) {
								grve_blade_vce_print_carousel_media( $carousel_image_mode );
							}
						?>
						<div class="grve-post-content">
							<div class="grve-post-meta grve-border grve-small-text grve-text-content">
								<?php grve_blade_vce_print_post_date(); ?>
							</div>
							<?php grve_blade_vce_print_post_title( $blog_style, $post_format, $heading_tag, $heading ); ?>
							<?php blade_ext_vce_print_structured_data(); ?>
							<?php
								if ( 'yes' != $hide_excerpt ) {
									grve_blade_vce_print_post_excerpt( $blog_style, $post_format, $auto_excerpt, $excerpt_length, $excerpt_more );
								}
							?>
						</div>
					</article>
				</div>
<?php
			} else {
?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( $grve_post_class ); ?> itemscope itemType="http://schema.org/BlogPosting">
				<?php echo $grve_isotope_start; ?>

					<?php if ( 'link' != $post_format && 'quote' != $post_format ) { ?>
						<?php
							if ( 'yes' == $blog_media_area ) {
								grve_blade_vce_print_post_feature_media( $blog_style, $post_format, $blog_image_mode, $blog_image_prio );
							}
						?>
						<div class="grve-post-content">
							<?php if ( $show_top_post_meta ) { ?>
							<ul class="grve-post-meta grve-small-text grve-list-divider">
								<?php
									if ( 'yes' != $hide_author ) {
										grve_blade_vce_print_post_author_by( $blog_style );
									}
									if ( 'yes' != $hide_date ) {
										grve_blade_vce_print_post_date( 'list' );
									}
									if ( 'yes' != $hide_comments ) {
										grve_blade_vce_print_post_comments();
									}
									if( 'yes' != $hide_like && function_exists( 'blade_grve_print_like_counter' ) ) {
										blade_grve_print_like_counter();
									}
								?>
							</ul>
							<?php } ?>
							<?php grve_blade_vce_print_post_title( $blog_style, $post_format, $heading_tag, $heading ); ?>
							<?php blade_ext_vce_print_structured_data(); ?>
							<?php grve_blade_vce_print_post_excerpt( $blog_style, $post_format, $auto_excerpt, $excerpt_length, $excerpt_more ); ?>
							<?php if ( $show_bottom_post_meta ) { ?>
							<div class="grve-post-meta-wrapper grve-border-top grve-border ">
								<div class="grve-post-icon grve-bg-primary-1"></div>
								<ul class="grve-post-meta grve-small-text grve-list-divider grve-text-content">
								<?php
									if ( 'yes' != $hide_author ) {
										grve_blade_vce_print_post_author_by( $blog_style );
									}
									if ( 'yes' != $hide_date ) {
										grve_blade_vce_print_post_date( 'list' );
									}
									if ( 'yes' != $hide_comments ) {
										grve_blade_vce_print_post_comments();
									}
									if( 'yes' != $hide_like && function_exists( 'blade_grve_print_like_counter' ) ) {
										blade_grve_print_like_counter();
									}
								?>
								</ul>
							</div>
							<?php } ?>
						</div>
					<?php } else { ?>
						<?php grve_blade_vce_print_post_title( $blog_style, $post_format, $heading_tag, $heading ); ?>
						<?php blade_ext_vce_print_structured_data(); ?>
					<?php }?>

				<?php echo $grve_isotope_end; ?>
			</article>

<?php
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
	add_shortcode( 'grve_blog', 'grve_blade_vce_blog_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_blog_shortcode_params' ) ) {
	function grve_blade_vce_blog_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Blog", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Display a Blog element in multiple styles", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-blog",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Style", "grve-blade-vc-extension" ),
					"param_name" => "blog_style",
					"admin_label" => true,
					'value' => array(
						esc_html__( 'Large Media', 'grve-blade-vc-extension' ) => 'blog-large',
						esc_html__( 'Small Media', 'grve-blade-vc-extension' ) => 'blog-small',
						esc_html__( 'Masonry' , 'grve-blade-vc-extension' ) => 'masonry',
						esc_html__( 'Grid' , 'grve-blade-vc-extension' ) => 'grid',
						esc_html__( 'Carousel' , 'grve-blade-vc-extension' ) => 'carousel',
					),
					"description" => esc_html__( "Select your Blog Style.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Blog Item Style", "grve-blade-vc-extension" ),
					"param_name" => "blog_item_style",
					'value' => array(
						esc_html__( 'Style 1' , 'grve-blade-vc-extension' ) => '1',
						esc_html__( 'Style 2' , 'grve-blade-vc-extension' ) => '2',
					),
					"description" => esc_html__( "Select your Blog Item Style.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				grve_blade_vce_get_heading_tag( "h2" ),
				grve_blade_vce_get_heading_blog( "auto" ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mode", "grve-blade-vc-extension" ),
					"param_name" => "blog_mode",
					"admin_label" => true,
					'value' => array(
						esc_html__( 'Without Shadow', 'grve-blade-vc-extension' ) => 'no-shadow-mode',
						esc_html__( 'With Shadow', 'grve-blade-vc-extension' ) => 'shadow-mode',
					),
					"description" => esc_html__( "Select your Blog Mode.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Media Area Visibility", "grve-blade-vc-extension" ),
					"param_name" => "blog_media_area",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"std" => "yes",
					"description" => esc_html__( "Select if you want to enable/disable media area", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Image Mode", "grve-blade-vc-extension" ),
					"param_name" => "blog_image_mode",
					'value' => array(
						esc_html__( 'Auto Crop', 'grve-blade-vc-extension' ) => '',
						esc_html__( 'Resize', 'grve-blade-vc-extension' ) => 'resize',
						esc_html__( 'Resize ( Large )', 'grve-blade-vc-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'grve-blade-vc-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'grve-blade-vc-extension' ) => 'medium',
					),
					"description" => esc_html__( "Select your Blog Image Mode.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small', 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => __( "Masonry Image Mode", "grve-blade-vc-extension" ),
					"param_name" => "blog_masonry_image_mode",
					'value' => array(
						esc_html__( 'Resize ( Large )', 'grve-blade-vc-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'grve-blade-vc-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'grve-blade-vc-extension' ) => 'medium',
					),
					"description" => __( "Select your Blog Masonry Image Mode.", "grve-blade-vc-extension" ),
					"dependency" => Array( 'element' => "blog_style", 'value' => array( 'masonry' ) ),
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
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Featured Image Priority", "grve-blade-vc-extension" ),
					"param_name" => "blog_image_prio",
					"description" => esc_html__( "Featured image is displayed instead of media element", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Featured Image Priority", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 4,
					"description" => esc_html__( "Select your Blog Columns.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Auto excerpt", "grve-blade-vc-extension" ),
					"param_name" => "auto_excerpt",
					"description" => esc_html__( "Adds automatic excerpt to all posts in Large Media style. If auto excerpt is not selected, blog will show all content, a desired 'cut-off' point can be inserted in each post with more quicktag.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Activate auto excerpt.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large' ) ),
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
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel','grid', 'masonry' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Gutter Size", "grve-blade-vc-extension" ),
					"param_name" => "gutter_size",
					"value" => '40',
					"dependency" => array( 'element' => "item_gutter", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => 'textfield',
					"heading" => esc_html__( "Excerpt length", "grve-blade-vc-extension" ),
					"param_name" => "excerpt_length",
					"description" => esc_html__( "Type how many words you want to display in your post excerpts.", "grve-blade-vc-extension" ),
					"value" => '55',
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry', 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Excerpt", "grve-blade-vc-extension" ),
					"param_name" => "hide_excerpt",
					"description" => esc_html__( "If selected, blog overview will not show excerpt.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Hide Excerpt.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Read more", "grve-blade-vc-extension" ),
					"param_name" => "excerpt_more",
					"description" => esc_html__( "Adds a read more button after the excerpt or more quicktag", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Add more button", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Filter", "grve-blade-vc-extension" ),
					"param_name" => "blog_filter",
					"description" => esc_html__( "If selected, an isotope filter will be displayed.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Enable Blog Filter ( Only for All or Multiple Categories )", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
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
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order", "grve-blade-vc-extension" ),
					"param_name" => "filter_order",
					"value" => array(
						esc_html__( "Ascending", "grve-blade-vc-extension" ) => 'ASC',
						esc_html__( "Descending", "grve-blade-vc-extension" ) => 'DESC',
					),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
					"description" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Alignment", "grve-blade-vc-extension" ),
					"param_name" => "blog_filter_align",
					"value" => array(
						esc_html__( "Left", "grve-blade-vc-extension" ) => 'left',
						esc_html__( "Right", "grve-blade-vc-extension" ) => 'right',
						esc_html__( "Center", "grve-blade-vc-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Loader", "grve-blade-vc-extension" ),
					"param_name" => "item_spinner",
					"description" => esc_html__( "If selected, this will enable a graphic spinner before load.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Enable Loader.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Disable Pagination", "grve-blade-vc-extension" ),
					"param_name" => "disable_pagination",
					"description" => esc_html__( "If selected, pagination will not be shown.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Disable Pagination.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Author", "grve-blade-vc-extension" ),
					"param_name" => "hide_author",
					"description" => esc_html__( "If selected, blog overview will not show author.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Hide Author.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Date", "grve-blade-vc-extension" ),
					"param_name" => "hide_date",
					"description" => esc_html__( "If selected, blog overview will not show date.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Hide Date.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Comments", "grve-blade-vc-extension" ),
					"param_name" => "hide_comments",
					"description" => esc_html__( "If selected, blog overview will not show comments.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Hide Comments.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Like", "grve-blade-vc-extension" ),
					"param_name" => "hide_like",
					"description" => esc_html__( "If selected, blog overview will not show like.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Hide Like.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Posts per Page", "grve-blade-vc-extension" ),
					"param_name" => "posts_per_page",
					"value" => "10",
					"description" => esc_html__( "Enter how many posts per page you want to display.", "grve-blade-vc-extension" ),
					"admin_label" => true,
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
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'blog-large', 'blog-small','grid', 'masonry' ) ),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "grve-blade-vc-extension" ),
					"std" => "zoomIn",
				),
				//Gallery ( carousel )
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items per page", "grve-blade-vc-extension" ),
					"param_name" => "items_per_page",
					"value" => array( '3', '4', '5' ),
					"description" => esc_html__( "Number of items per page", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
					"std" => "4",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "grve-blade-vc-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "grve-blade-vc-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, carousel will be paused on hover", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "grve-blade-vc-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "blog_style", 'value' => array( 'carousel' ) ),
				),
				grve_blade_vce_add_order_by(),
				grve_blade_vce_add_order(),
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
					"heading" => __("Categories", "grve-blade-vc-extension" ),
					"param_name" => "categories",
					"value" => grve_blade_vce_get_post_categories(),
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
	vc_lean_map( 'grve_blog', 'grve_blade_vce_blog_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_blog_shortcode_params( 'grve_blog' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
