<?php
/**
 * Testimonial Shortcode
 */

if( !function_exists( 'grve_blade_vce_testimonial_shortcode' ) ) {

	function grve_blade_vce_testimonial_shortcode( $attr, $content ) {

		$portfolio_row_start = $allow_filter = $class_fullwidth = $slider_data = $output = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'testimonial_type' => 'carousel',
					'testimonial_mode' => 'no-shadow-mode',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'item_gutter' => 'yes',
					'gutter_size' => '40',
					'items_to_show' => '20',
					'order_by' => 'date',
					'order' => 'DESC',
					'disable_pagination' => '',
					'show_image' => 'no',
					'margin_bottom' => '',
					'slideshow_speed' => '3000',
					'pagination_speed' => '400',
					'carousel_pagination' => 'yes',
					'carousel_pagination_type' => '1',
					'transition' => 'slide',
					'auto_play' => 'yes',
					'pause_hover' => 'no',
					'auto_height' => 'no',
					'animation' => 'zoomIn',
					'align' => 'left',
					'text_style' => 'none',
					'el_class' => '',
				),
				$attr
			)
		);

		if ( !empty( $animation ) ) {
			$animation = 'grve-' .$animation;
		}

		$testimonial_classes = array( 'grve-element' );

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$data_string = '';

		switch( $testimonial_type ) {
			case 'masonry':
				$data_string = ' data-columns="' . esc_attr( $columns ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="masonry"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $testimonial_classes, 'grve-with-gap' );
				}
				if ( 'shadow-mode' == $testimonial_mode ) {
					array_push( $testimonial_classes, 'grve-with-shadow' );
				}
				array_push( $testimonial_classes, 'grve-testimonial-grid' );
				array_push( $testimonial_classes, 'grve-isotope' );
				break;
			case 'grid':
				$data_string = ' data-columns="' . esc_attr( $columns ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows"';
				if ( 'yes' == $item_gutter ) {
					$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
				}
				if ( 'yes' == $item_gutter ) {
					array_push( $testimonial_classes, 'grve-with-gap' );
				}
				if ( 'shadow-mode' == $testimonial_mode ) {
					array_push( $testimonial_classes, 'grve-with-shadow' );
				}
				array_push( $testimonial_classes, 'grve-testimonial-grid' );
				array_push( $testimonial_classes, 'grve-isotope' );
				break;
			case 'carousel':
			default:
				$data_string = ' data-slider-transition="' . esc_attr( $transition ) . '" data-slider-autoplay="' . esc_attr( $auto_play ) . '" data-slider-speed="' . esc_attr( $slideshow_speed ) . '" data-slider-pause="' . esc_attr( $pause_hover ) . '" data-pagination-speed="' . esc_attr( $pagination_speed ) . '"';
				$data_string .= ' data-pagination="' . esc_attr( $carousel_pagination ) . '"';
				$data_string .= ' data-slider-autoheight="' . esc_attr( $auto_height ) . '"';
				array_push( $testimonial_classes, 'grve-testimonial' );
				array_push( $testimonial_classes, 'grve-carousel-element' );
				array_push( $testimonial_classes, 'grve-align-' . $align );
				if ( 'none' != $text_style ) {
					array_push( $testimonial_classes, 'grve-' . $text_style );
				}
				if ( 'yes' == $carousel_pagination ) {
					array_push( $testimonial_classes, 'grve-carousel-pagination-' . $carousel_pagination_type  );
				}
				$disable_pagination = 'yes';
				break;

		}

		if ( !empty ( $el_class ) ) {
			array_push( $testimonial_classes, $el_class);
		}

		$testimonial_class_string = implode( ' ', $testimonial_classes );

		$testimonial_cat = "";

		if ( !empty( $categories ) ) {
			$testimonial_category_list = explode( ",", $categories );
			foreach ( $testimonial_category_list as $testimonial_list ) {
				$testimonial_term = get_term( $testimonial_list, 'testimonial_category' );
				$testimonial_cat = $testimonial_cat.$testimonial_term->slug . ', ';
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
				'post_type' => 'testimonial',
				'post_status'=>'publish',
				'paged' => $paged,
				'post__in' => $include_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
		} else {
			$args = array(
				'post_type' => 'testimonial',
				'post_status'=>'publish',
				'paged' => $paged,
				'testimonial_category' => $testimonial_cat,
				'post__not_in' => $exclude_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
		}

		$image_size = 'thumbnail';

		$query = new WP_Query( $args );

		ob_start();

		if ( $query->have_posts() ) :

		?>
			<div class="<?php echo esc_attr( $testimonial_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data_string; ?>>

				<?php if ( 'carousel' != $testimonial_type ) { ?>
				<div class="grve-isotope-container">
				<?php } ?>

		<?php
		while ( $query->have_posts() ) : $query->the_post();


		$name =  grve_blade_vce_post_meta( 'grve_testimonial_name' );
		$identity =  grve_blade_vce_post_meta( 'grve_testimonial_identity' );

		if ( !empty( $name ) && !empty( $identity ) ) {
			$identity = ', ' . $identity;
		}

			if ( 'carousel' == $testimonial_type ) {
		?>
				<div class="grve-testimonial-element">
					<?php if ( 'yes' == $show_image && has_post_thumbnail() ) { ?>
							<div class="grve-testimonial-thumb"><?php the_post_thumbnail( $image_size ); ?></div>
					<?php } ?>
					<?php the_content(); ?>
					<?php if ( !empty( $name ) || !empty( $identity ) ) { ?>
					<div class="grve-small-text grve-heading-color grve-testimonial-name"><?php echo esc_html( $name . $identity ); ?></div>
					<?php } ?>
				</div>
		<?php
			} else {

		?>
				<div class="grve-isotope-item grve-testimonial-item">
					<div class="grve-isotope-item-inner <?php echo esc_attr( $animation ); ?>">
						<div class="grve-testimonial-element grve-style-2 grve-with-shadow">
							<div class="grve-container">
								<?php the_content(); ?>
							</div>
							<div class="grve-testimonial-author grve-border grve-border-top">
								<?php if ( 'yes' == $show_image && has_post_thumbnail() ) { ?>
										<div class="grve-testimonial-thumb"><?php the_post_thumbnail( $image_size ); ?></div>
								<?php } ?>
								<?php if ( !empty( $name ) || !empty( $identity ) ) { ?>
								<div class="grve-small-text grve-heading-color grve-testimonial-name"><?php echo esc_html( $name . $identity ); ?></div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>

		<?php
			}
		endwhile;

		?>
				<?php if ( 'carousel' != $testimonial_type ) { ?>
				</div>
				<?php } ?>
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
	add_shortcode( 'grve_testimonial', 'grve_blade_vce_testimonial_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_testimonial_shortcode_params' ) ) {
	function grve_blade_vce_testimonial_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Testimonial", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Add a captivating testimonial slider", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-testimonial",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Testimonial type", "grve-blade-vc-extension" ),
					"param_name" => "testimonial_type",
					"value" => array(
						esc_html__( "Carousel", "grve-blade-vc-extension" ) => 'carousel',
						esc_html__( "Grid", "grve-blade-vc-extension" ) => 'grid',
						esc_html__( "Masonry", "grve-blade-vc-extension" ) => 'masonry',
					),
					"description" => esc_html__( "Select your testimonial type.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mode", "grve-blade-vc-extension" ),
					"param_name" => "testimonial_mode",
					"admin_label" => true,
					'value' => array(
						esc_html__( 'Without Shadow', 'grve-blade-vc-extension' ) => 'no-shadow-mode',
						esc_html__( 'With Shadow', 'grve-blade-vc-extension' ) => 'shadow-mode',
					),
					"description" => esc_html__( "Select your testimonial Mode.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select number of columns.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "grve-blade-vc-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2', '3' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'grid', 'masonry' ) ),
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
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Gutter Size", "grve-blade-vc-extension" ),
					"param_name" => "gutter_size",
					"value" => '40',
					"dependency" => array( 'element' => "item_gutter", 'value' => array( 'yes' ) ),
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
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'grid', 'masonry' ) ),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "grve-blade-vc-extension" ),
					"std" => "zoomIn",
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Items to show", "grve-blade-vc-extension" ),
					"param_name" => "items_to_show",
					"value" => '20',
					"description" => esc_html__( "Maximum Testimonial Items to Show", "grve-blade-vc-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Disable Pagination", "grve-blade-vc-extension" ),
					"param_name" => "disable_pagination",
					"description" => esc_html__( "If selected, pagination will not be shown.", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Disable Pagination.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'grid', 'masonry' ) ),
				),
				grve_blade_vce_add_order_by(),
				grve_blade_vce_add_order(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Show Featured Image", "grve-blade-vc-extension" ),
					"param_name" => "show_image",
					"value" => array(
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
					),
					"std" => 'no',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Autoplay", "grve-blade-vc-extension" ),
					"param_name" => "auto_play",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Transition", "grve-blade-vc-extension" ),
					"param_name" => "transition",
					"value" => array(
						esc_html__( "Slide", "grve-blade-vc-extension" ) => 'slide',
						esc_html__( "Fade", "grve-blade-vc-extension" ) => 'fade',
					),
					"description" => esc_html__( "Transition Effect.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Slideshow Speed", "grve-blade-vc-extension" ),
					"param_name" => "slideshow_speed",
					"value" => '3000',
					"description" => esc_html__( "Slideshow Speed in ms.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pause on Hover", "grve-blade-vc-extension" ),
					"param_name" => "pause_hover",
					"value" => array( esc_html__( "If selected, testimonial will be paused on hover", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Auto Height", "grve-blade-vc-extension" ),
					"param_name" => "auto_height",
					"value" => array( esc_html__( "Select if you want smooth auto height", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'carousel' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Carousel Pagination", "grve-blade-vc-extension" ),
					"param_name" => "carousel_pagination",
					"value" => array(
						esc_html__( "Yes", "grve-blade-vc-extension" ) => 'yes',
						esc_html__( "No", "grve-blade-vc-extension" ) => 'no',
					),
					"std" => "yes",
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'carousel' ) ),
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
					"type" => "dropdown",
					"heading" => esc_html__( "Text Style", "grve-blade-vc-extension" ),
					"param_name" => "text_style",
					"value" => array(
						esc_html__( "None", "grve-blade-vc-extension" ) => '',
						esc_html__( "Leader", "grve-blade-vc-extension" ) => 'leader-text',
						esc_html__( "Subtitle", "grve-blade-vc-extension" ) => 'subtitle',
					),
					"description" => 'Select your text style',
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'carousel' ) ),
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
					"description" => '',
					"dependency" => array( 'element' => "testimonial_type", 'value' => array( 'carousel' ) ),
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
					"heading" => __("Testimonial Categories", "grve-blade-vc-extension" ),
					"param_name" => "categories",
					"value" => grve_blade_vce_get_testimonial_categories(),
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
	vc_lean_map( 'grve_testimonial', 'grve_blade_vce_testimonial_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_testimonial_shortcode_params( 'grve_testimonial' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
