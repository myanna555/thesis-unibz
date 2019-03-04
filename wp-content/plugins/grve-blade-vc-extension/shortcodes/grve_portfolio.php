<?php
/**
 * Portfolio Shortcode
 */

if( !function_exists( 'grve_blade_vce_portfolio_shortcode' ) ) {

	function grve_blade_vce_portfolio_shortcode( $attr, $content ) {

		$portfolio_row_start = $allow_filter = $class_fullwidth = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'portfolio_style' => 'grid',
					'heading_tag' => 'h2',
					'heading' => 'h5',
					'heading_auto_size' => 'no',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'grid_image_mode' => 'landscape',
					'masonry_image_mode' => '',
					'carousel_image_mode' => 'landscape',
					'portfolio_link_type' => 'item',
					'portfolio_overview_type' => '',
					'portfolio_link_type_title' => 'More Details',
					'portfolio_filter' => '',
					'portfolio_filter_align' => 'left',
					'filter_order_by' => '',
					'filter_order' => 'ASC',
					'item_gutter' => 'yes',
					'gutter_size' => '40',
					'item_spinner' => 'no',
					'items_per_page' => '4',
					'items_to_show' => '12',
					'hide_portfolio_title' => '',
					'hide_portfolio_caption' => '',
					'hide_portfolio_like' => '',
					'portfolio_hover_style' => 'hover-style-1',
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

		$portfolio_classes = array( 'grve-element' );
		$data_string = '';

		switch( $portfolio_style ) {
			case 'carousel':
				$data_string = ' data-items="' . esc_attr( $items_per_page ) . '" data-slider-autoplay="' . esc_attr( $auto_play ) . '" data-slider-speed="' . esc_attr( $slideshow_speed ) . '" data-slider-pause="' . esc_attr( $pause_hover ) . '"';
				$data_string .= ' data-pagination-speed="' . esc_attr( $carousel_pagination_speed ) . '"';
				$data_string .= ' data-pagination="' . esc_attr( $carousel_pagination ) . '"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				array_push( $portfolio_classes, 'grve-carousel-wrapper' );
				if ( 'popup' == $portfolio_link_type ) {
					array_push( $portfolio_classes, 'grve-gallery-popup' );
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $portfolio_classes, 'grve-with-gap' );
				}
				if ( 'yes' == $carousel_pagination ) {
					array_push( $portfolio_classes, 'grve-carousel-pagination-' . $carousel_pagination_type  );
				}
				$disable_pagination = 'yes';
				break;
			case 'masonry':
				$portfolio_row_start = '<div class="grve-isotope-container">';
				if ( 'popup' == $portfolio_link_type ) {
					$portfolio_row_start = '<div class="grve-isotope-container grve-gallery-popup">';
				}
				$data_string = ' data-spinner="' . esc_attr( $item_spinner ) . '" data-columns="' . esc_attr( $columns ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="masonry"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $portfolio_classes, 'grve-with-gap' );
				}
				if ( 'yes' == $heading_auto_size ) {
					array_push( $portfolio_classes, 'grve-auto-headings' );
				}
				array_push( $portfolio_classes, 'grve-portfolio' );
				array_push( $portfolio_classes, 'grve-isotope' );
				$allow_filter = 'yes';
				break;
			case 'grid':
			default:
				$portfolio_row_start = '<div class="grve-isotope-container">';
				if ( 'popup' == $portfolio_link_type ) {
					$portfolio_row_start = '<div class="grve-isotope-container grve-gallery-popup">';
				}
				$data_string = ' data-spinner="' . esc_attr( $item_spinner ) . '" data-columns="' . esc_attr( $columns ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $portfolio_classes, 'grve-with-gap' );
				}
				array_push( $portfolio_classes, 'grve-portfolio' );
				array_push( $portfolio_classes, 'grve-isotope' );
				$allow_filter = 'yes';
				break;
		}

		$isotope_inner_item_classes = array( 'grve-isotope-item-inner' );

		if ( !empty( $animation ) ) {
			array_push( $isotope_inner_item_classes, $animation);
		}
		$isotope_inner_item_class_string = implode( ' ', $isotope_inner_item_classes );


		if ( !empty ( $el_class ) ) {
			array_push( $portfolio_classes, $el_class);
		}
		$portfolio_class_string = implode( ' ', $portfolio_classes );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$portfolio_cat = "";
		$portfolio_category_ids = array();

		if( ! empty( $categories ) ) {
			$portfolio_category_ids = explode( ",", $categories );
			foreach ( $portfolio_category_ids as $category_id ) {
				$category_term = get_term( $category_id, 'portfolio_category' );
				if ( isset( $category_term) ) {
					$portfolio_cat = $portfolio_cat.$category_term->slug . ', ';
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
				'post_type' => 'portfolio',
				'post_status'=>'publish',
				'paged' => $paged,
				'post__in' => $include_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
			$portfolio_filter = 'no';
		} else {
			$args = array(
				'post_type' => 'portfolio',
				'post_status'=>'publish',
				'paged' => $paged,
				'portfolio_category' => $portfolio_cat,
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
			<div class="<?php echo esc_attr( $portfolio_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data_string; ?>>
		<?php

		if ( 'yes' == $portfolio_filter && 'yes' == $allow_filter ) {

			$category_prefix = '.portfolio_category-';
			$category_filter_list = array();
			$category_filter_array = array();
			$all_string =  apply_filters( 'blade_grve_vce_portfolio_string_all_categories', esc_html__( 'All', 'grve-blade-vc-extension' ) );
			$category_filter_string = '<li data-filter="*" class="selected"><span>' . esc_html( $all_string ) . '</span></li>';
			$category_filter_add = false;
			while ( $query->have_posts() ) : $query->the_post();

				if ( $portfolio_categories = get_the_terms( get_the_ID(), 'portfolio_category' ) ) {

					foreach($portfolio_categories as $category_term){
						$category_filter_add = false;
						if ( !in_array($category_term->term_id, $category_filter_list) ) {
							if( ! empty( $portfolio_category_ids ) ) {
								if ( in_array($category_term->term_id, $portfolio_category_ids) ) {
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
				<div class="grve-filter grve-link-text grve-list-divider grve-align-<?php echo esc_attr( $portfolio_filter_align ); ?>">
					<ul>
						<?php echo $category_filter_string; ?>
					</ul>
				</div>
		<?php
			}
		}
		?>

			<?php echo $portfolio_row_start; ?>

		<?php

		if ( 'carousel' == $portfolio_style ) {

			//Carousel Navigation
			echo grve_blade_vce_element_navigation( $navigation_type, $navigation_color, 'carousel' );
?>
			<div class="grve-carousel grve-carousel-element grve-portfolio"<?php echo $data_string; ?>>
<?php
		}

		$portfolio_index = 0;

		while ( $query->have_posts() ) : $query->the_post();
			$image_size = 'blade-grve-small-rect-horizontal';
			$portfolio_index++;
			$portfolio_extra_class = '';

			$caption = get_post_meta( get_the_ID(), 'grve_description', true );
			$details = get_post_meta( get_the_ID(), 'grve_details', true );
			$link_mode = get_post_meta( get_the_ID(), 'grve_portfolio_link_mode', true );
			$link_url = get_post_meta( get_the_ID(), 'grve_portfolio_link_url', true );
			$new_window = get_post_meta( get_the_ID(), 'grve_portfolio_link_new_window', true );
			$link_class = get_post_meta( get_the_ID(), 'grve_portfolio_link_extra_class', true );


			if ( 'carousel' != $portfolio_style ) {
				$image_size = 'blade-grve-small-square';
				$portfolio_extra_class = 'grve-isotope-item grve-portfolio-item ';

				if ( 'masonry' == $portfolio_style ) {
					//Masonry
					if ( 'resize' == $masonry_image_mode || 'large' == $masonry_image_mode ) {
						$portfolio_extra_class .= 'grve-masonry-image';
						$image_size = 'large';
					} elseif( 'medium_large' == $masonry_image_mode ) {
						$portfolio_extra_class .= 'grve-masonry-image';
						$image_size = 'medium_large';
					} elseif( 'medium' == $masonry_image_mode ) {
						$portfolio_extra_class .= 'grve-masonry-image';
						$image_size = 'medium';
					} elseif( 'custom' == $masonry_image_mode ) {
						$masonry_size = get_post_meta( get_the_ID(), 'grve_portfolio_media_masonry_size', true );
						$grve_masonry_data = grve_blade_vce_get_custom_masonry_data( $masonry_size );
						$portfolio_extra_class .= $grve_masonry_data['class'];
						$image_size = $grve_masonry_data['image_size'];
					} else {
						$grve_masonry_data = grve_blade_vce_get_masonry_data( $portfolio_index, $columns );
						$portfolio_extra_class .= $grve_masonry_data['class'];
						$image_size = $grve_masonry_data['image_size'];
					}
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
			} else {

				if( 'square' == $carousel_image_mode ) {
					$image_size = 'blade-grve-small-square';
				} elseif( 'portrait' == $carousel_image_mode ) {
					$image_size = 'blade-grve-small-rect-vertical';
				} else {
					$image_size = 'blade-grve-small-rect-horizontal';
				}
				$portfolio_extra_class = 'grve-portfolio-item';
				echo '<div class="grve-carousel-item">';
			}

			//Portfolio Link

			$portfolio_link_exists = true;
			$grve_target = '_self';
			if( !empty( $new_window ) ) {
				$grve_target = '_blank';
			}

			ob_start();

			if ( 'popup' == $portfolio_link_type ) {
			?>
				<a href="<?php grve_blade_vce_print_portfolio_image( 'full', 'link' ); ?>">
			<?php
			}  else if ( 'custom-link' == $portfolio_link_type ) {
				if ( '' == $link_mode )	{
			?>
				<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
				} else if ( 'link' == $link_mode && !empty( $link_url ) ) {
			?>
				<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $grve_target ); ?>">
			<?php
				} else {
					$portfolio_link_exists = false;
				}
			} else {
			?>
				<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
			}

			$link_start = ob_get_clean();

			if ( $portfolio_link_exists ) {
				$link_end = '</a>';
			} else {
				$link_end = '';
			}

			//Portfolio Title & Caption Color
			$text_color = 'light';
			if( 'light' == $overlay_color ) {
				$text_color = 'dark';
			}

			//Portfolio Custom Overview
			if ( 'custom-overview' == $portfolio_overview_type ) {
				$overview_mode = get_post_meta( get_the_ID(), 'grve_portfolio_overview_mode', true );
				$overview_text = get_post_meta( get_the_ID(), 'grve_portfolio_overview_text', true );
				$overview_text_heading = get_post_meta( get_the_ID(), 'grve_portfolio_overview_text_heading', true );
				$overview_bg_color = 'none';
				if ( 'color' == $overview_mode ) {
					$overview_color = get_post_meta( get_the_ID(), 'grve_portfolio_overview_color', true );
					if ( empty( $overview_color ) ) {
						$overview_color = 'black';
					}
					$overview_bg_color = get_post_meta( get_the_ID(), 'grve_portfolio_overview_bg_color', true );
					if ( empty( $overview_bg_color ) ) {
						$overview_bg_color = 'primary-1';
					}
					if ( empty( $overview_text_heading ) ) {
						$overview_text_heading = 'h3';
					}
					$portfolio_extra_class .= ' grve-bg-overview';
					$text_color = $overview_color;
					$zoom_effect = 'none';
				}
			} else {
				$overview_bg_color = 'none';
				$overview_mode = '';
			}

?>
					<article id="portfolio-<?php the_ID(); ?><?php echo uniqid('-'); ?>" <?php post_class( $portfolio_extra_class ); ?>>
						<?php
						if ( 'carousel' == $portfolio_style ) {
						?>
							<figure class="grve-hover-style-1 grve-image-hover grve-zoom-<?php echo esc_attr( $zoom_effect ); ?>">

								<div class="grve-media grve-text-<?php echo esc_attr( $text_color ); ?> grve-bg-<?php echo esc_attr( $overview_bg_color ); ?>">
									<?php if ( 'color' != $overview_mode ) { ?>
									<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
									<?php } ?>
									<?php grve_blade_vce_print_portfolio_image( $image_size, $overview_mode ); ?>

									<?php
										if( function_exists( 'blade_grve_print_portfolio_like_counter' ) && 'yes' != $hide_portfolio_like ) {
											blade_grve_print_portfolio_like_counter();
										}
									?>
								</div>
								<figcaption>
									<div class="grve-portfolio-content">
										<?php if ( 'yes' != $hide_portfolio_title  ) { ?>
										<<?php echo tag_escape( $heading_tag ); ?> class="grve-title grve-text-<?php echo esc_attr( $text_color ); ?> grve-<?php echo esc_attr( $heading ); ?>"><?php the_title(); ?></<?php echo tag_escape( $heading_tag ); ?>>
										<?php } ?>

										<?php
											if ( 'popup' == $portfolio_link_type ) {
										?>
											<a title="<?php the_title(); ?>" class="grve-portfolio-btn grve-text-<?php echo esc_attr( $text_color ); ?>" href="<?php grve_blade_vce_print_portfolio_image( 'full', 'link' ); ?>"><?php echo $portfolio_link_type_title; ?></a>
										<?php
											} elseif ( $portfolio_link_exists ) {
												if ( 'custom-link' == $portfolio_link_type && 'link' == $link_mode) {
										?>
											<a class="grve-portfolio-btn grve-text-<?php echo esc_attr( $text_color ); ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $grve_target ); ?>"><?php echo $portfolio_link_type_title; ?></a>
										<?php
												} else {
										?>
											<a class="grve-portfolio-btn grve-text-<?php echo esc_attr( $text_color ); ?>" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo $portfolio_link_type_title; ?></a>
										<?php
												}
											}
										?>
									</div>
								</figcaption>
							</figure>
						<?php

						} else {

							if ( 'hover-style-2' == $portfolio_hover_style ) {
						?>
							<?php echo $link_start; ?>
							<div class="<?php echo esc_attr( $isotope_inner_item_class_string ); ?>">
								<figure class="grve-hover-style-2 grve-image-hover grve-zoom-<?php echo esc_attr( $zoom_effect ); ?>">
									<div class="grve-media grve-text-<?php echo esc_attr( $text_color ); ?> grve-bg-<?php echo esc_attr( $overview_bg_color ); ?>">
										<?php if ( 'color' != $overview_mode ) { ?>
										<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
										<?php } ?>
										<?php grve_blade_vce_print_portfolio_image( $image_size, $overview_mode ); ?>

										<?php
											if( function_exists( 'blade_grve_print_portfolio_like_counter' ) && 'yes' != $hide_portfolio_like ) {
												blade_grve_print_portfolio_like_counter();
											}
										?>
									</div>
									<figcaption>
										<div class="grve-portfolio-content">
											<?php if ( 'yes' != $hide_portfolio_title  ) { ?>
											<<?php echo tag_escape( $heading_tag ); ?> class="grve-title grve-text-hover-primary-1 grve-<?php echo esc_attr( $heading ); ?>"><?php the_title(); ?></<?php echo tag_escape( $heading_tag ); ?>>
											<?php } ?>
											<?php if ( !empty( $caption ) && 'yes' != $hide_portfolio_caption  ) { ?>
											<div class="grve-caption grve-text-content"><?php echo $caption; ?></div>
											<?php } ?>
										</div>
									</figcaption>
								</figure>
							</div>
							<?php echo $link_end; ?>
						<?php
							} else if ( 'hover-style-4' == $portfolio_hover_style || 'hover-style-5' == $portfolio_hover_style ) {
						?>
							<?php echo $link_start; ?>
							<div class="<?php echo esc_attr( $isotope_inner_item_class_string ); ?>">
								<figure class="grve-<?php echo esc_attr( $portfolio_hover_style ); ?> grve-image-hover grve-zoom-<?php echo esc_attr( $zoom_effect ); ?>">
									<div class="grve-media grve-bg-<?php echo esc_attr( $overview_bg_color ); ?>">
										<?php if ( 'color' != $overview_mode ) { ?>
										<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
										<?php } ?>
										<?php grve_blade_vce_print_portfolio_image( $image_size, $overview_mode ); ?>
									</div>
									<figcaption class="grve-text-<?php echo esc_attr( $text_color ); ?>">
										<?php if ( 'color' == $overview_mode && !empty( $overview_text) ) { ?>
											<div class="grve-portfolio-content grve-bg-overview-content">
												<<?php echo tag_escape( $heading_tag ); ?> class="grve-title grve-text-<?php echo esc_attr( $text_color ); ?> grve-<?php echo esc_attr( $overview_text_heading ); ?>"><?php echo wp_kses_post( $overview_text ); ?></<?php echo tag_escape( $heading_tag ); ?>>
											</div>
										<?php } else { ?>
											<div class="grve-portfolio-content">
												<?php
													if( function_exists( 'blade_grve_print_portfolio_like_counter' ) && 'yes' != $hide_portfolio_like ) {
														blade_grve_print_portfolio_like_counter();
													}
												?>
												<?php if ( 'yes' != $hide_portfolio_title  ) { ?>
												<<?php echo tag_escape( $heading_tag ); ?> class="grve-title grve-text-<?php echo esc_attr( $text_color ); ?> grve-<?php echo esc_attr( $heading ); ?>"><?php the_title(); ?></<?php echo tag_escape( $heading_tag ); ?>>
												<?php } ?>
												<?php if ( !empty( $caption ) && 'yes' != $hide_portfolio_caption  ) { ?>
												<div class="grve-caption grve-text-<?php echo esc_attr( $text_color ); ?>"><?php echo $caption; ?></div>
												<?php } ?>
											</div>
										<?php } ?>
									</figcaption>
								</figure>
							</div>
							<?php echo $link_end; ?>
						<?php
							} else {
							//Hover Style 1 and 3

						?>
							<?php echo $link_start; ?>
							<div class="<?php echo esc_attr( $isotope_inner_item_class_string ); ?>">
								<figure class="grve-<?php echo esc_attr( $portfolio_hover_style ); ?> grve-image-hover grve-zoom-<?php echo esc_attr( $zoom_effect ); ?>">
									<div class="grve-media grve-bg-<?php echo esc_attr( $overview_bg_color ); ?>">
										<?php if ( 'color' != $overview_mode ) { ?>
										<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
										<?php } ?>
										<?php grve_blade_vce_print_portfolio_image( $image_size, $overview_mode ); ?>
									</div>
									<figcaption class="grve-text-<?php echo esc_attr( $text_color ); ?>">
										<?php if ( 'color' == $overview_mode && !empty( $overview_text) ) { ?>
											<div class="grve-portfolio-content grve-bg-overview-content">
												<<?php echo tag_escape( $heading_tag ); ?> class="grve-title grve-text-<?php echo esc_attr( $text_color ); ?> grve-<?php echo esc_attr( $overview_text_heading ); ?>"><?php echo wp_kses_post( $overview_text ); ?></<?php echo tag_escape( $heading_tag ); ?>>
											</div>
										<?php } else { ?>
											<?php
												if( function_exists( 'blade_grve_print_portfolio_like_counter' ) && 'yes' != $hide_portfolio_like ) {
													blade_grve_print_portfolio_like_counter();
												}
											?>
											<div class="grve-portfolio-content">
												<?php if ( 'yes' != $hide_portfolio_title  ) { ?>
												<<?php echo tag_escape( $heading_tag ); ?> class="grve-title grve-text-<?php echo esc_attr( $text_color ); ?> grve-<?php echo esc_attr( $heading ); ?>"><?php the_title(); ?></<?php echo tag_escape( $heading_tag ); ?>>
												<?php } ?>
												<?php if ( !empty( $caption ) && 'yes' != $hide_portfolio_caption  ) { ?>
												<div class="grve-caption grve-text-<?php echo esc_attr( $text_color ); ?>"><?php echo $caption; ?></div>
												<?php } ?>
											</div>
										<?php } ?>
									</figcaption>
								</figure>
							</div>
							<?php echo $link_end; ?>
						<?php
							}
						}
						?>

					</article>
<?php
			if ( 'carousel' == $portfolio_style ) {
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
	add_shortcode( 'grve_portfolio', 'grve_blade_vce_portfolio_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_portfolio_shortcode_params' ) ) {
	function grve_blade_vce_portfolio_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Portfolio", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Display Portfolio element in multiple styles", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-portfolio",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Style", "grve-blade-vc-extension" ),
					"param_name" => "portfolio_style",
					"admin_label" => true,
					'value' => array(
						esc_html__( 'Grid' , 'grve-blade-vc-extension' ) => 'grid',
						esc_html__( 'Masonry' , 'grve-blade-vc-extension' ) => 'masonry',
						esc_html__( 'Carousel' , 'grve-blade-vc-extension' ) => 'carousel',
					),
					"description" => esc_html__( "Select a style for your portfolio", "grve-blade-vc-extension" ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Masonry Image Mode", "grve-blade-vc-extension" ),
					"param_name" => "masonry_image_mode",
					'value' => array(
						esc_html__( 'Auto Crop', 'grve-blade-vc-extension' ) => '',
						esc_html__( 'Resize ( Large )', 'grve-blade-vc-extension' ) => 'resize',
						esc_html__( 'Resize ( Medium Large )', 'grve-blade-vc-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'grve-blade-vc-extension' ) => 'medium',
						esc_html__( 'Custom', 'grve-blade-vc-extension' ) => 'custom',
					),
					"description" => esc_html__( "Select your Masonry Image Mode.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'masonry' ) ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 4,
					"description" => esc_html__( "Select your Porfolio Columns.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Link Type", "grve-blade-vc-extension" ),
					"param_name" => "portfolio_link_type",
					"admin_label" => true,
					'value' => array(
						esc_html__( 'Classic Portfolio' , 'grve-blade-vc-extension' ) => 'item',
						esc_html__( 'Gallery Usage' , 'grve-blade-vc-extension' ) => 'popup',
						esc_html__( 'Custom Link' , 'grve-blade-vc-extension' ) => 'custom-link',
					),
					"description" => esc_html__( "Select the link type of your portfolio items.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overview Type", "grve-blade-vc-extension" ),
					"param_name" => "portfolio_overview_type",
					"admin_label" => true,
					'value' => array(
						esc_html__( 'Default' , 'grve-blade-vc-extension' ) => '',
						esc_html__( 'Custom Overview' , 'grve-blade-vc-extension' ) => 'custom-overview',
					),
					"description" => esc_html__( "Select the overview type of your portfolio items.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Link Title", "grve-blade-vc-extension" ),
					"param_name" => "portfolio_link_type_title",
					"value" => "More Details",
					"description" => esc_html__( "Enter your title for your link.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Filter", "grve-blade-vc-extension" ),
					"param_name" => "portfolio_filter",
					"description" => esc_html__( "If selected, an isotope filter will be displayed.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Enable Portfolio Filter ( Only for All or Multiple Categories )", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order", "grve-blade-vc-extension" ),
					"param_name" => "filter_order",
					"value" => array(
						esc_html__( "Ascending", "grve-blade-vc-extension" ) => 'ASC',
						esc_html__( "Descending", "grve-blade-vc-extension" ) => 'DESC',
					),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
					"description" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Alignment", "grve-blade-vc-extension" ),
					"param_name" => "portfolio_filter_align",
					"value" => array(
						esc_html__( "Left", "grve-blade-vc-extension" ) => 'left',
						esc_html__( "Right", "grve-blade-vc-extension" ) => 'right',
						esc_html__( "Center", "grve-blade-vc-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Loader", "grve-blade-vc-extension" ),
					"param_name" => "item_spinner",
					"description" => esc_html__( "If selected, this will enable a graphic spinner before load.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Enable Loader.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Disable Pagination", "grve-blade-vc-extension" ),
					"param_name" => "disable_pagination",
					"description" => esc_html__( "If selected, pagination will not be shown.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Disable Pagination.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Items per page", "grve-blade-vc-extension" ),
					"param_name" => "items_per_page",
					"value" => array( '3', '4', '5' ),
					"description" => esc_html__( "Number of images per page", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry', 'carousel' ) ),
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
					"description" => esc_html__( "Maximum Portfolio Items to Show", "grve-blade-vc-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Portfolio Title", "grve-blade-vc-extension" ),
					"param_name" => "hide_portfolio_title",
					"value" => array( esc_html__( "If selected, portfolio title will be hidden", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Portfolio Description", "grve-blade-vc-extension" ),
					"param_name" => "hide_portfolio_caption",
					"value" => array( esc_html__( "If selected, portfolio description will be hidden", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Hide Portfolio Likes", "grve-blade-vc-extension" ),
					"param_name" => "hide_portfolio_like",
					"value" => array( esc_html__( "If selected, portfolio likes will be hidden", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry', 'carousel' ) ),
				),
				grve_blade_vce_get_heading_tag( "h2" ),
				grve_blade_vce_get_heading( "h5" ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Title/Description Auto Resize", "grve-blade-vc-extension" ),
					"param_name" => "heading_auto_size",
					"value" => array(
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
					),
					"description" => esc_html__( "If selected title/description will be automatically resized according to media width", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Hover Style", "grve-blade-vc-extension" ),
					"param_name" => "portfolio_hover_style",
					'value' => array(
						esc_html__( 'Style 1' , 'grve-blade-vc-extension' ) => 'hover-style-1',
						esc_html__( 'Style 2' , 'grve-blade-vc-extension' ) => 'hover-style-2',
						esc_html__( 'Style 3' , 'grve-blade-vc-extension' ) => 'hover-style-3',
						esc_html__( 'Style 4' , 'grve-blade-vc-extension' ) => 'hover-style-4',
						esc_html__( 'Style 5' , 'grve-blade-vc-extension' ) => 'hover-style-5',
					),
					"description" => esc_html__( "Select hover style for portfolio items.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry', 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "grve-blade-vc-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry', 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "grve-blade-vc-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "grve-blade-vc-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "grve-blade-vc-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, carousel will be paused on hover", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'carousel' ) ),
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
					"dependency" => array( 'element' => "portfolio_style", 'value' => array( 'grid', 'masonry' ) ),
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
					"heading" => __("Portfolio Categories", "grve-blade-vc-extension" ),
					"param_name" => "categories",
					"value" => grve_blade_vce_get_portfolio_categories(),
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
	vc_lean_map( 'grve_portfolio', 'grve_blade_vce_portfolio_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_portfolio_shortcode_params( 'grve_portfolio' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
