<?php

/*
 *	Helper functions
 *
 * 	@version	1.0
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */

 /**
 * Helper function to get array value with fallback
 */
if ( !function_exists( 'grve_blade_vce_array_value' ) ) {
	function grve_blade_vce_array_value( $input_array, $id, $fallback = false, $param = false ) {

		if ( $fallback == false ) $fallback = '';
		$output = ( isset($input_array[$id]) && $input_array[$id] !== '' ) ? $input_array[$id] : $fallback;
		if ( !empty($input_array[$id]) && $param ) {
			$output = ( isset($input_array[$id][$param]) && $input_array[$id][$param] !== '' ) ? $input_array[$id][$param] : $fallback;
		}
		return $output;
	}
}

/**
 * Helper function to get custom fields with fallback
 */
if ( !function_exists( 'grve_blade_vce_post_meta' ) ) {
	function grve_blade_vce_post_meta( $id, $fallback = false ) {
		global $post;
		$post_id = $post->ID;
		if ( $fallback == false ) $fallback = '';
		$post_meta = get_post_meta( $post_id, $id, true );
		$output = ( $post_meta !== '' ) ? $post_meta : $fallback;
		return $output;
	}
}


function grve_blade_vce_starts_with( $haystack, $needle ) {
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}


 /**
 * Generates a button
 * Used in shortcodes to display a button
 */
function grve_blade_vce_get_button( $button_options ) {

	$button_text = grve_blade_vce_array_value( $button_options, 'button_text' );
	$button_link = grve_blade_vce_array_value( $button_options, 'button_link' );
	$button_type = grve_blade_vce_array_value( $button_options, 'button_type' );
	$button_size = grve_blade_vce_array_value( $button_options, 'button_size' );
	$button_color = grve_blade_vce_array_value( $button_options, 'button_color' );
	$button_hover_color = grve_blade_vce_array_value( $button_options, 'button_hover_color' );
	$button_shape = grve_blade_vce_array_value( $button_options, 'button_shape' );
	$button_extra_class = grve_blade_vce_array_value( $button_options, 'button_class' );
	$style = grve_blade_vce_array_value( $button_options, 'style' );

	$btn_add_icon = grve_blade_vce_array_value( $button_options, 'btn_add_icon' );
	$btn_icon_library = grve_blade_vce_array_value( $button_options, 'btn_icon_library' );
	$btn_icon_fontawesome = grve_blade_vce_array_value( $button_options, 'btn_icon_fontawesome', 'fa fa-adjust' );
	$btn_icon_openiconic = grve_blade_vce_array_value( $button_options, 'btn_icon_openiconic', 'vc-oi vc-oi-dial' );
	$btn_icon_typicons = grve_blade_vce_array_value( $button_options, 'btn_icon_typicons', 'typcn typcn-adjust-brightness' );
	$btn_icon_entypo = grve_blade_vce_array_value( $button_options, 'btn_icon_entypo', 'entypo-icon entypo-icon-note' );
	$btn_icon_linecons = grve_blade_vce_array_value( $button_options, 'btn_icon_linecons', 'vc_li vc_li-heart' );
	$btn_icon_simplelineicons = grve_blade_vce_array_value( $button_options, 'btn_icon_simplelineicons', 'smp-icon-user' );

	$button_fluid = grve_blade_vce_array_value( $button_options, 'btn_fluid' );
	$button_fluid_height = grve_blade_vce_array_value( $button_options, 'btn_fluid_height' );
	$btn_aria_label = grve_blade_vce_array_value( $button_options, 'btn_aria_label' );

	$button = "";

	if ( !empty( $button_text) || 'yes' == $btn_add_icon ) {
		$button_classes = array( 'grve-btn' );

		array_push( $button_classes, 'grve-btn-' . $button_size );
		array_push( $button_classes, 'grve-' . $button_shape );

		array_push( $button_classes, 'grve-bg-' . $button_color );
		array_push( $button_classes, 'grve-bg-hover-' . $button_hover_color );

		if ( 'outline' == $button_type ) {
			array_push( $button_classes, 'grve-btn-line' );
		}

		if ( 'yes' == $button_fluid ) {
			array_push( $button_classes, 'grve-fullwidth-btn' );
			array_push( $button_classes, 'grve-fluid-btn-' . $button_fluid_height );
		}

		if ( !empty( $button_extra_class ) ) {
			array_push( $button_classes, $button_extra_class );
		}

		$button_class_string = implode( ' ', $button_classes );

		if( 'yes' == $btn_add_icon ) {
			$icon_class = isset( ${"btn_icon_" . $btn_icon_library} ) ? esc_attr( ${"btn_icon_" . $btn_icon_library} ) : 'fa fa-adjust';
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				vc_icon_element_fonts_enqueue( $btn_icon_library );
			}
		}
		$link_attributes = grve_blade_vce_get_link_attributes( $button_link, $button_class_string, $style );
		if ( !empty( $btn_aria_label ) ) {
			$link_attributes[] = 'aria-label="' . esc_attr( $btn_aria_label ) . '"';
		}

		$button .= '<a ' . implode( ' ', $link_attributes ) . '>';
		$button .= '<span>';
		if( 'yes' == $btn_add_icon ) {
			$button .= '<i class="' . esc_attr( $icon_class ) . '"></i>';
		}
		$button .= $button_text;
		$button .= '</span>';
		$button .= '</a>';
	}

	return $button;

}

function grve_blade_vce_has_link( $link = '' ) {

	$has_link = false;

	if ( !empty( $link ) ){
		$link = vc_build_link( $link );
		if ( strlen( $link['url'] ) > 0 ) {
			$has_link = true;
		}
	}
	return $has_link;

}

function grve_blade_vce_get_link_attributes( $link = '', $class = '', $style = ''  ) {
	$attributes = array();
	$a_href = $a_title = $a_target = $a_rel = '';
	$use_link = false;

	if ( !empty( $link ) ){
		$link = vc_build_link( $link );
		if ( strlen( $link['url'] ) > 0 ) {
			$use_link = true;
			$a_href = $link['url'];
			$a_title = $link['title'];
			$a_target = $link['target'];
			$a_rel = $link['rel'];
		}
	}

	if ( $use_link ) {
		$attributes[] = 'href="' . esc_url( $a_href ) . '"';
		if ( ! empty( $a_title ) ) {
			$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
		}
		if ( ! empty( $a_target ) ) {
			$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
		}
		if ( ! empty( $a_rel ) ) {
			$attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
		}
	} else {
		$attributes[] = 'href="#"';
	}


	if ( ! empty( $class ) ) {
		$attributes[] = 'class="' . esc_attr( $class ) . '"';
	}
	if ( ! empty( $style ) ) {
		$attributes[] = 'style="' . esc_attr( $style ) . '"';
	}

	return $attributes;
}

 /**
 * Fetch Product Categories
 * Used in shortcodes to generate the list of used categories ( back end )
 */
function grve_blade_vce_get_product_categories() {

	$product_category = array( esc_html__( "All Categories", "grve-blade-vc-extension" ) => "" );

	$product_cats = get_terms( 'product_cat' );
	if ( is_array( $product_cats ) ) {
	  foreach ( $product_cats as $product_cat ) {
		$product_category[$product_cat->name] = $product_cat->term_id;

	  }
	}
	return $product_category;

}

 /**
 * Fetch Product Categories
 * Used in product filter to generate the list of used categories ( front end )
 */
function grve_blade_vce_get_product_list() {

	$all_string =  apply_filters( 'blade_grve_vce_product_string_all_categories', esc_html__( 'All', 'grve-blade-vc-extension' ) );

	$get_product_category = get_categories( array( 'taxonomy' => 'product_cat') );
	$product_category_list = array( '0' => $all_string );

	foreach ( $get_product_category as $product_category ) {
		$product_category_list[] = $product_category->cat_name;
	}
	return $product_category_list;

}

 /**
 * Fetch Portfolio Categories
 * Used in shortcodes to generate the list of used categories ( back end )
 */
function grve_blade_vce_get_portfolio_categories() {

	$portfolio_category = array( esc_html__( "All Categories", "grve-blade-vc-extension" ) => "" );

	$portfolio_cats = get_terms( 'portfolio_category' );
	if ( is_array( $portfolio_cats ) ) {
	  foreach ( $portfolio_cats as $portfolio_cat ) {
		$portfolio_category[$portfolio_cat->name] = $portfolio_cat->term_id;

	  }
	}
	return $portfolio_category;

}

 /**
 * Fetch Portfolio Categories
 * Used in portfolio filter to generate the list of used categories ( front end )
 */
function grve_blade_vce_get_portfolio_list() {

	$all_string =  apply_filters( 'blade_grve_vce_portfolio_string_all_categories', esc_html__( 'All', 'grve-blade-vc-extension' ) );

	$get_portfolio_category = get_categories( array( 'taxonomy' => 'portfolio_category') );
	$portfolio_category_list = array( '0' => $all_string );

	foreach ( $get_portfolio_category as $portfolio_category ) {
		$portfolio_category_list[] = $portfolio_category->cat_name;
	}
	return $portfolio_category_list;

}


 /**
 * Print Portfolio Image
 * Used in portfolio to fetch feature image or link
 */
function grve_blade_vce_print_portfolio_image( $image_size , $link = '' ) {
	if( function_exists( 'blade_grve_print_portfolio_image' ) ) {
		blade_grve_print_portfolio_image( $image_size , $link );
	}
}

 /**
 * Fetch Testimonial Categories
 * Used in shortcodes to generate the list of used categories ( back end )
 */
function grve_blade_vce_get_testimonial_categories() {
	$testimonial_category = array( esc_html__( "All Categories", "grve-blade-vc-extension" ) => "" );

	$testimonial_cats = get_terms( 'testimonial_category' );
	if ( is_array( $testimonial_cats ) ) {
	  foreach ( $testimonial_cats as $testimonial_cat ) {
		$testimonial_category[$testimonial_cat->name] = $testimonial_cat->term_id;

	  }
	}
	return $testimonial_category;
}

 /**
 * Fetch Post Categories
 * Used in shortcodes to generate the list of used categories ( back end )
 */
function grve_blade_vce_get_post_categories() {
	$category = array( esc_html__( "All Categories", "grve-blade-vc-extension" ) => "" );

	$cats = get_terms( 'category' );
	if ( is_array( $cats ) ) {
	  foreach ( $cats as $cat ) {
		$category[$cat->name] = $cat->term_id;

	  }
	}
	return $category;
}


 /**
 * Generates dimension string to concat in attribute style
 */
function grve_blade_vce_build_dimension( $dimension, $value ) {
	$fixed_dimension = '';

	if( ! empty( $dimension ) &&  ! empty( $value )  ) {
		$fixed_dimension .= $dimension . ': '.(preg_match('/(px|em|\%|pt|cm)$/', $value) ? $value : $value.'px').';';
	}
	return $fixed_dimension;
}

 /**
 * Generates margin-bottom string to concat in attribute style
 */
function grve_blade_vce_build_margin_bottom_style( $margin_bottom ) {
	$style = '';
	if( $margin_bottom != '' ) {
		$style .= 'margin-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $margin_bottom) ? $margin_bottom : $margin_bottom .'px').';';
		$style = esc_attr( $style );
	}
	return $style;
}

 /**
 * Generates padding-top string to concat in attribute style
 */
function grve_blade_vce_build_padding_top_style( $padding_top ) {
	$style = '';
	if( $padding_top != '' ) {
		$style .= 'padding-top: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_top) ? $padding_top : $padding_top.'px').';';
		$style = esc_attr( $style );
	}
	return $style;
}

 /**
 * Generates padding-bottom string to concat in attribute style
 */
function grve_blade_vce_build_padding_bottom_style( $padding_bottom ) {
	$style = '';
	if( $padding_bottom != '' ) {
		$style .= 'padding-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_bottom) ? $padding_bottom : $padding_bottom.'px').';';
		$style = esc_attr( $style );
	}
	return $style;
}

 /**
 * Prints blog class depending on the blog style
 */
function grve_blade_vce_get_blog_class( $grve_blog_style = 'blog-large'  ) {

	switch( $grve_blog_style ) {

		case 'blog-small':
			$grve_blog_style_class = 'grve-blog grve-blog-small grve-non-isotope';
			break;
		case 'masonry':
			$grve_blog_style_class = 'grve-blog grve-blog-columns grve-blog-masonry grve-isotope grve-with-gap';
			break;
		case 'grid':
			$grve_blog_style_class = 'grve-blog grve-blog-columns grve-blog-grid grve-isotope grve-with-gap';
			break;
		case 'carousel':
			$grve_blog_style_class = 'grve-carousel-wrapper';
			break;
		case 'blog-large':
		default:
			$grve_blog_style_class = 'grve-blog grve-blog-large grve-non-isotope';
			break;

	}

	return $grve_blog_style_class;

}


 /**
 * Prints excerpt depending on the blog style and post format
 */
function grve_blade_vce_print_post_title( $blog_style, $post_format, $heading_tag, $heading ) {
	global $allowedposttags;
	$mytags = $allowedposttags;

	$title_tag = $heading_tag;

	if( 'auto' == $heading ) {
		$heading = 'h3';
		if( 'blog-large' == $blog_style || 'blog-small' == $blog_style  ) {
			$heading = 'h2';
		}
		if( 'carousel' == $blog_style ) {
			$heading = 'h6';
		}
	}

	switch( $post_format ) {
		case 'link':
			if( 'carousel' == $blog_style ) {
				the_title( '<a ' . grve_blade_vce_print_post_link( 'link' ) . ' rel="bookmark"><' . tag_escape( $title_tag ) . ' class="grve-post-title grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '></a>' );
			} else {
				if( 'auto' == $heading ) {
					$heading = 'h4';
				}
				unset($mytags['a']);
				unset($mytags['img']);
				unset($mytags['p']);
				$content = wp_kses(get_the_content(), $mytags);

				$bg_color = grve_blade_vce_post_meta( 'grve_post_link_bg_color', 'primary-1' );
				$bg_hover_color = grve_blade_vce_post_meta( 'grve_post_link_bg_hover_color', 'black' );

				$link_classes = array();
				$link_classes[] = 'grve-bg-' . $bg_color;
				$link_classes[] = 'grve-bg-hover-' . $bg_hover_color;
				$link_class_string = implode( ' ', $link_classes );

				$title_color = 'white';
				$title_hover_color = 'white';
				$title_classes = array( 'grve-post-title' );
				if( 'white' == $bg_color ){
					$title_color = 'black';
				}
				if( 'white' == $bg_hover_color ){
					$title_hover_color = 'black';
				}
				$title_classes[] = 'grve-text-' . $title_color;
				$title_classes[] = 'grve-text-hover-' . $title_hover_color;
				$title_classes[] = 'grve-' . $heading;
				$title_class_string = implode( ' ', $title_classes );

				echo '<a ' . grve_blade_vce_print_post_link( 'link' ) . ' class="' . esc_attr( $link_class_string ) . '" rel="bookmark">';
				the_title( '<' . tag_escape( $title_tag ) . ' class="' . esc_attr( $title_class_string ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '>' );
				echo '<p itemprop="articleBody">' . $content . '</p>';
				echo '<div class="grve-subtitle">' . grve_blade_vce_print_post_link( 'link', 'url' ) . '</div>';
				echo '</a>';
			}
			break;
		case 'quote':
			if( 'carousel' == $blog_style ) {
				the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><' . tag_escape( $title_tag ) . ' class="grve-post-title grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '></a>' );
			} else {

				if( 'auto' == $heading ) {
					$heading = 'h4';
				}
				the_title( '<' . tag_escape( $title_tag ) . ' class="grve-hidden grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '>' );
				unset($mytags['a']);
				unset($mytags['img']);
				unset($mytags['p']);
				unset($mytags['blockquote']);

				$bg_color = grve_blade_vce_post_meta( 'grve_post_quote_bg_color', 'primary-1' );
				$bg_hover_color = grve_blade_vce_post_meta( 'grve_post_quote_bg_hover_color', 'black' );

				$quote_classes = array();
				$quote_classes[] = 'grve-bg-' . $bg_color;
				$quote_classes[] = 'grve-bg-hover-' . $bg_hover_color;
				$quote_class_string = implode( ' ', $quote_classes );

				echo '<a href="' . esc_url( get_permalink() ) . '" class="' . esc_attr( $quote_class_string ) . '" rel="bookmark">';
				echo '<p class="grve-blog-quote-text" itemprop="articleBody">' . wp_kses(get_the_content(), $mytags) . '</p>';
				grve_blade_vce_print_post_date();
				echo '</a>';
			}
			break;
		default:
			 the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><' . tag_escape( $title_tag ) . ' class="grve-post-title grve-text-hover-primary-1 grve-' . esc_attr( $heading ) . '" itemprop="name headline">', '</' . tag_escape( $title_tag ) . '></a>' );
			break;
	}

}

 /**
 * Prints post link
 */
function grve_blade_vce_print_post_link( $post_format = 'standard', $mode = '' ) {
	global $post;
	$post_id = $post->ID;

	$grve_link = get_permalink();
	$grve_target = '_self';

	if ( 'link' == $post_format ) {
		$grve_link = get_post_meta( $post_id, 'grve_post_link_url', true );
		$new_window = get_post_meta( $post_id, 'grve_post_link_new_window', true );

		if( empty( $grve_link ) ) {
			$grve_link = get_permalink();
		}

		if( !empty( $new_window ) ) {
			$grve_target = '_blank';
		}

		if ( 'url' == $mode ) {
			return $grve_link;
		}
	}

	return 'href="' . esc_url( $grve_link ) . '" target="' . esc_attr( $grve_target ) . '"';

}

/**
 * Prints excerpt depending on the blog style and post format
 */
function grve_blade_vce_print_post_excerpt( $blog_style, $post_format, $autoexcerpt = '', $excerpt_length = '55', $excerpt_more = '' ) {

	if ( 'link' == $post_format || 'quote' == $post_format ) {
		return;
	}

	echo '<div itemprop="articleBody">';
	switch( $blog_style ) {
		case 'blog-large':
			if ( empty( $autoexcerpt ) ) {
				if ( empty( $excerpt_more ) ) {
					the_content( '' );
				} else {
					global $more;
					$more = 0;
					the_content( grve_blade_vce_read_more_string() );
				}
			} else {
				echo grve_blade_vce_excerpt( $excerpt_length, $excerpt_more );
			}
			break;
		default:
			echo grve_blade_vce_excerpt( $excerpt_length, $excerpt_more );
			break;
	}
	echo '</div>';

}

/**
 * Returns read more link
 */
if ( !function_exists( 'grve_blade_vce_read_more' ) ) {
	function grve_blade_vce_read_more( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$read_more_string =  apply_filters( 'blade_grve_vce_string_read_more', esc_html__( 'read more', 'grve-blade-vc-extension' ) );
		return '<a class="grve-read-more grve-link-text" href="' . esc_url( get_permalink( $post_id ) ) . '"><span>' . $read_more_string . '</span></a>';
	}
}

/**
 * Returns read more string
 */
if ( !function_exists( 'grve_blade_vce_read_more_string' ) ) {
	function grve_blade_vce_read_more_string() {
		$read_more_string =  apply_filters( 'blade_grve_vce_string_read_more', esc_html__( 'read more', 'grve-blade-vc-extension' ) );
		return $read_more_string;
	}
}

/**
 * Returns excerpt
 */
if ( !function_exists( 'grve_blade_vce_excerpt' ) ) {
	function grve_blade_vce_excerpt( $limit, $more = "" ) {
		global $post;
		$post_id = $post->ID;
		$excerpt = "";

		if ( has_excerpt( $post_id ) ) {
			if ( 0 != $limit ) {
				$excerpt = apply_filters( 'the_excerpt', $post->post_excerpt );
			}
			if ( 'yes' == $more ) {
				$excerpt .= grve_blade_vce_read_more( $post_id );
			}
		} else {
			$content = get_the_content('');
			$content = apply_filters('blade_ext_the_content', $content);
			$content = str_replace(']]>', ']]>', $content);
			if ( 0 != $limit ) {
				$excerpt = '<p>' . wp_trim_words( $content, $limit ) . '</p>';
			}
			if ( 'yes' == $more ) {
				$excerpt .= grve_blade_vce_read_more( $post_id );
			}
		}
		return	$excerpt;
	}
}

/**
 * Prints feature media depending on the blog style and post format
 */
function grve_blade_vce_print_carousel_media( $carousel_image_mode = '' ) {
	global $post;
	$post_id = $post->ID;
	$image_href = get_permalink();

	if( 'square' == $carousel_image_mode ) {
		$image_size = 'blade-grve-small-square';
	} elseif( 'portrait' == $carousel_image_mode ) {
		$image_size = 'blade-grve-small-rect-vertical';
	} else {
		$image_size = 'blade-grve-small-rect-horizontal';
	}

	$image_src = GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL .'assets/images/empty/' . $image_size . '.jpg';
?>
		<div class="grve-media grve-image-hover">
			<?php if ( has_post_thumbnail( $post_id ) ) { ?>
			<a href="<?php echo esc_url( $image_href ); ?>"><?php the_post_thumbnail( $image_size ); ?></a>
			<?php } else { ?>
			<a class="grve-no-image" href="<?php echo esc_url( $image_href ); ?>"><img src="<?php echo esc_url( $image_src ); ?>" alt="no image"></a>
			<?php } ?>

		</div>
<?php
}

/**
 * Prints feature media depending on the blog style and post format
 */
function grve_blade_vce_print_post_feature_media( $grve_blog_style = 'blog-large', $post_format, $blog_image_mode, $blog_image_prio ) {
	global $post, $wp_embed;

	$post_id = $post->ID;

	if ( 'resize' == $blog_image_mode ) {
		switch( $grve_blog_style ) {
			case 'blog-large':
				$image_size = 'blade-grve-fullscreen';
			break;
			default:
				$image_size = 'large';
			break;
		}
	} elseif ( 'large' == $blog_image_mode  ) {
		$image_size = 'large';
	} elseif( 'medium_large' == $blog_image_mode ) {
		$image_size = 'medium_large';
	} elseif( 'medium' == $blog_image_mode ) {
		$image_size = 'medium';
	} else {
		switch( $grve_blog_style ) {
			case 'blog-large':
				$image_size = 'blade-grve-large-rect-horizontal';
			break;
			case 'masonry' :
				$image_size = 'blade-grve-small-rect-horizontal';
			break;
			default:
				$image_size = 'blade-grve-small-rect-horizontal-wide';
			break;
		}
	}

	$image_href = get_permalink();

	if ( ( '' == $post_format || 'image' == $post_format || 'yes' == $blog_image_prio ) &&  has_post_thumbnail( $post_id ) ) {
?>
		<div class="grve-media grve-image-hover">
			<a href="<?php echo esc_url( $image_href ); ?>"><?php the_post_thumbnail( $image_size ); ?></a>
		</div>
<?php

	} else if ( 'audio' == $post_format ) {

		$audio_mode = get_post_meta( $post_id, 'grve_post_type_audio_mode', true );
		$audio_mp3 = get_post_meta( $post_id, 'grve_post_audio_mp3', true );
		$audio_ogg = get_post_meta( $post_id, 'grve_post_audio_ogg', true );
		$audio_wav = get_post_meta( $post_id, 'grve_post_audio_wav', true );
		$audio_embed = get_post_meta( $post_id, 'grve_post_audio_embed', true );

		if( empty( $audio_mode ) && !empty( $audio_embed ) ) {
			$audio_output = '';
			$audio_output .= '<div class="grve-media">';
			$audio_output .= $audio_embed;
			$audio_output .= '</div>';
			echo $audio_output;
		} else {

			if ( !empty( $audio_mp3 ) || !empty( $audio_ogg ) || !empty( $audio_wav ) ) {

				$audio_output = '[audio ';

				if ( !empty( $audio_mp3 ) ) {
					$audio_output .= 'mp3="'. esc_url( $audio_mp3 ) .'" ';
				}
				if ( !empty( $audio_ogg ) ) {
					$audio_output .= 'ogg="'. esc_url( $audio_ogg ) .'" ';
				}
				if ( !empty( $audio_wav ) ) {
					$audio_output .= 'wav="'. esc_url ( $audio_wav ) .'" ';
				}

				$audio_output .= ']';

				echo '<div class="grve-media">';
				echo  do_shortcode( $audio_output );
				echo '</div>';

			}
		}
	} else if ( 'video' == $post_format ) {

		$video_mode = get_post_meta( $post_id, 'grve_post_type_video_mode', true );
		$video_embed = get_post_meta( $post_id, 'grve_post_video_embed', true );

		$video_output = '';

		if( empty( $video_mode ) && !empty( $video_embed ) ) {
			$video_output .= '<div class="grve-media">';
			$video_output .= $wp_embed->run_shortcode( '[embed]' . $video_embed . '[/embed]' );
			$video_output .= '</div>';
		} else {
			$video_webm = get_post_meta( $post_id, 'grve_post_video_webm', true );
			$video_mp4 = get_post_meta( $post_id, 'grve_post_video_mp4', true );
			$video_ogv = get_post_meta( $post_id, 'grve_post_video_ogv', true );
			$video_poster = get_post_meta( $post_id, 'grve_post_video_poster', true );

			$video_attr = '';
			$video_settings = array(
				'controls' => 'yes',
				'poster' => $video_poster,
			);
			$video_settings = apply_filters( 'grve_blade_vce_media_video_settings', $video_settings );

			if ( function_exists( 'blade_grve_print_media_video_settings' ) ) {
				$video_attr = blade_grve_print_media_video_settings( $video_settings );
			} else {
				$video_attr = ' controls';
			}
			if ( !empty( $video_webm ) || !empty( $video_mp4 ) || !empty( $video_ogv ) ) {
				$video_output .= '<div class="grve-media">';
				$video_output .= '  <video ' . $video_attr . '>';

				if ( !empty( $video_webm ) ) {
					$video_output .= '<source src="' . esc_url( $video_webm ) . '" type="video/webm">';
				}
				if ( !empty( $video_mp4 ) ) {
					$video_output .= '<source src="' . esc_url( $video_mp4 ) . '" type="video/mp4">';
				}
				if ( !empty( $video_ogv ) ) {
					$video_output .= '<source src="' . esc_url( $video_ogv ) . '" type="video/ogg">';
				}
				$video_output .='  </video>';
				$video_output .= '</div>';

			}
		}
		echo  $video_output;
	} else if ( 'gallery' == $post_format ) {

		$slider_items = get_post_meta( $post_id, 'grve_post_slider_items', true );
		$gallery_mode = 'slider';
		if ( !empty( $slider_items ) ) {
			switch( $grve_blog_style ) {
				case 'blog-large':
					$image_size = 'blade-grve-large-rect-horizontal';
				break;
				case 'masonry' :
					$image_size = 'blade-grve-small-rect-horizontal';
				break;
				default:
					$image_size = 'blade-grve-small-rect-horizontal-wide';
				break;
			}
			grve_blade_vce_print_gallery_slider( $gallery_mode, $slider_items, $image_size  );
		}

	}

}

function grve_blade_vce_element_navigation( $navigation_type = 0, $navigation_color = 'dark', $navigation_element = 'default' ) {

		$output = '';

		if ( 0 != $navigation_type ) {

			switch( $navigation_type ) {

				case '2':
					$icon_nav_prev = 'grve-icon-arrow-left-alt';
					$icon_nav_next = 'grve-icon-arrow-right-alt';
					break;
				case '3':
					$icon_nav_prev = 'grve-icon-arrow-left';
					$icon_nav_next = 'grve-icon-arrow-right';
					break;
				case '4':
					$icon_nav_prev = 'grve-icon-arrow-left';
					$icon_nav_next = 'grve-icon-arrow-right';
					break;
				default:
					$navigation_type = '1';
					$icon_nav_prev = 'grve-icon-arrow-left-alt';
					$icon_nav_next = 'grve-icon-arrow-right-alt';
					break;
			}

			$output .= '<div class="grve-carousel-navigation grve-' . esc_attr( $navigation_color ) . ' grve-navigation-' . esc_attr( $navigation_type ) . ' grve-navigation-' . esc_attr( $navigation_element ) . '">';
			$output .= '	<div class="grve-carousel-buttons">';
			$output .= '		<div class="grve-carousel-prev">';
			$output .= '			<i class="' . esc_attr( $icon_nav_prev ) . '"></i>';
			$output .= '		</div>';
			$output .= '		<div class="grve-carousel-next">';
			$output .= '			<i class="' . esc_attr( $icon_nav_next ) . '"></i>';
			$output .= '		</div>';
			$output .= '	</div>';
			$output .= '</div>';
		}

	return 	$output;

}

 /**
 * Prints Gallery or Slider
 */
function grve_blade_vce_print_gallery_slider( $gallery_mode, $slider_items, $image_size_slider ) {

?>
		<div class="grve-media">
			<div class="grve-element grve-carousel-wrapper">
				<?php echo grve_blade_vce_element_navigation('4'); ?>
				<div class="grve-slider grve-carousel-element " data-slider-speed="2500" data-slider-pause="yes" data-slider-autoheight="no">
<?php
					foreach ( $slider_items as $slider_item ) {
						$media_id = $slider_item['id'];
						echo '<div class="grve-slider-item">';
						echo wp_get_attachment_image( $media_id, $image_size_slider );
						echo '</div>';
					}
?>
				</div>
			</div>
		</div>
<?php

}

 /**
 * Prints post categories depending on the blog style
 */
function grve_blade_vce_print_post_categories( $grve_blog_style = 'blog-large' ) {

	$show_categories = false;
	if ( is_singular() ) {
		$show_categories = true;
	} else {
		switch( $grve_blog_style ) {

			case 'blog-small':
			case 'blog-large':
			default:
				$show_categories = true;
				break;
		}
	}

	if ( $show_categories ) {
		$in_categories_string =  apply_filters( 'blade_grve_vce_blog_string_categories_in', esc_html__( 'in', 'grve-blade-vc-extension' ) );
?>
		<span class="grve-post-categories">
			<?php echo $in_categories_string . ' '; ?><?php the_category(', '); ?>
		</span>
<?php

	}

}

 /**
 * Prints post date
 */
function grve_blade_vce_print_post_date( $mode = '') {
	global $post;

	if( 'list' == $mode ) {
?>
		<li class="grve-post-date">
<?php
	}
?>
			<time class="grve-post-date" datetime="<?php echo mysql2date( 'c', $post->post_date ); ?>">
				<?php echo get_the_date(); ?>
			</time>
<?php
	if( 'list' == $mode ) {
?>
		</li>
<?php
	}

}

 /**
 * Prints post comments
 */
function grve_blade_vce_print_post_comments() {
?>
	<li class="grve-post-comments"><a href="<?php the_permalink(); ?>#commentform"><i class="fa fa-comment-o"></i> <?php comments_number( '0' , '1', '%' ); ?></a></li>
<?php
}

 /**
 * Prints post author avatar
 */
function grve_blade_vce_print_post_author( $grve_blog_style, $post_format ) {
	if ( 'blog-large' == $grve_blog_style ) {
		if ( 'quote' != $post_format && 'link' != $post_format ) {
?>
	<div class="grve-post-author">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
	</div>
<?php
		}
	}
}

 /**
 * Prints post author by depending on the blog style
 */
function grve_blade_vce_print_post_author_by( $grve_blog_style = 'blog-large' ) {

	switch( $grve_blog_style ) {

		case 'blog-small':
		case 'blog-large':
		case 'masonry':
		case 'grid':
			$show_author_by = true;
			break;
		default:
			$show_author_by = false;
			break;
	}

	if ( $show_author_by ) {
		$author_by_string =  apply_filters( 'blade_grve_vce_blog_string_by_author', esc_html__( 'By', 'grve-blade-vc-extension' ) );
?>
		<li class="grve-post-author">
			<span><?php echo $author_by_string . ' '; ?></span><span><?php the_author_posts_link(); ?></span>
		</li>
<?php

	}

}

/**
 * Gets post class depending on the blog style
 */
function grve_blade_vce_get_post_class( $grve_blog_style = 'blog-large', $extra_class = '' ) {

	$post_classes = array( 'grve-blog-item' );
	if ( !empty( $extra_class ) ){
		array_push( $post_classes, $extra_class );
	}

	switch( $grve_blog_style ) {

		case 'blog-large':
			array_push( $post_classes, 'grve-big-post' );
			array_push( $post_classes, 'grve-non-isotope-item' );
			break;

		case 'blog-small':
			array_push( $post_classes, 'grve-small-post' );
			array_push( $post_classes, 'grve-non-isotope-item' );
			break;

		case 'masonry':
		case 'grid':
			array_push( $post_classes, 'grve-isotope-item' );
			break;

		default:
			break;

	}

	return implode( ' ', $post_classes );

}

function grve_blade_vce_get_image_size( $image_mode ) {

	switch( $image_mode ) {
		case 'medium':
			$image_size = 'medium';
		break;
		case 'large':
		case 'resize':
			$image_size = 'large';
		break;
		case 'thumbnail':
			$image_size = 'thumbnail';
		break;
		case 'square':
			$image_size = 'blade-grve-small-square';
		break;
		case 'landscape':
			$image_size = 'blade-grve-small-rect-horizontal';
		break;
		case 'landscape-wide':
			$image_size = 'blade-grve-small-rect-horizontal-wide';
		break;
		case 'portrait':
			$image_size = 'blade-grve-small-rect-vertical';
		break;
		case 'fullscreen':
		case 'extra-extra-large':
			$image_size = 'blade-grve-fullscreen';
		break;
		default:
			$image_size = 'full';
		break;
	}

	return $image_size;

}

function grve_blade_vce_get_custom_masonry_data( $size = 'square' ) {

	switch( $size ) {
		case 'landscape':
			$image_size_class = "grve-image-landscape";
			$image_size = 'blade-grve-medium-square';
			break;
		case 'portrait':
			$image_size_class = "grve-image-portrait";
			$image_size = 'blade-grve-medium-rect-vertical';
			break;
		case 'large-square':
			$image_size_class = "grve-image-large-square";
			$image_size = 'blade-grve-medium-square';
			break;
		case 'square':
		default:
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
			break;
	}
	return array(
		'class' => $image_size_class,
		'image_size' => $image_size,
	);
}

function grve_blade_vce_get_masonry_data( $index, $columns ) {

	$image_size_class = "grve-image-square";
	$image_size = 'blade-grve-small-square';

	if( '2' == $columns ) {

		if ( $index % 2  == 0 ) {
			$image_size_class = "grve-image-portrait";
			$image_size = 'blade-grve-medium-rect-vertical';
		}
		if ( $index % 4  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
		}
		if ( $index % 5  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = 'blade-grve-medium-square';
		}
		if ( $index % 6  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
		}
		if ( $index % 8  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = 'blade-grve-medium-square';
		}
		if ( $index % 9  == 0 ) {
			$image_size_class = "grve-image-portrait";
			$image_size = 'blade-grve-medium-rect-vertical';
		}
		if ( $index % 10  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
		}
		if ( $index % 15  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
		}
		if ( $index % 16  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
		}
	}

	if( '3' == $columns ) {

		if ( $index % 4  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = 'blade-grve-medium-square';
		}
		if ( $index % 7  == 0 ) {
			$image_size_class = "grve-image-large-square";
			$image_size = 'blade-grve-medium-square';
		}
		if ( $index % 8  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
		}
	}

	if( '4' == $columns ) {

		if ( $index % 3  == 0 ) {
			$image_size_class = "grve-image-portrait";
			$image_size = 'blade-grve-medium-rect-vertical';
		}
		if ( $index % 5  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = 'blade-grve-medium-square';
		}
		if ( $index % 6  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
		}
		if ( $index % 7  == 0 ) {
			$image_size_class = "grve-image-large-square";
			$image_size = 'blade-grve-medium-square';
		}
		if ( $index % 10  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
		}
		if ( $index % 14  == 0 ) {
			$image_size_class = "grve-image-square";
			$image_size = 'blade-grve-small-square';
		}

	}

	if( '5' == $columns ) {

		if ( $index % 3  == 0 ) {
			$image_size_class = "grve-image-portrait";
			$image_size = 'blade-grve-medium-rect-vertical';
		}
		if ( $index % 6  == 0 ) {
			$image_size_class = "grve-image-landscape";
			$image_size = 'blade-grve-medium-square';
		}
		if ( $index % 9  == 0 ) {
			$image_size_class = "grve-image-large-square";
			$image_size = 'blade-grve-medium-square';
		}
	}

	return array(
		'class' => $image_size_class,
		'image_size' => $image_size,
	);
}

function grve_blade_vce_text_to_bool( $value ) {
	if ( 'yes' == $value ) {
		return 'true';
	}
	return 'false';
}

function grve_blade_vce_unautop( $s ) {
    $s = str_replace("<p>", "", $s);
    $s = str_replace("</p>", "\n\n", $s);
    return $s;
}

/**
 * Prints post structured data
 */
function blade_ext_vce_print_structured_data() {
	if( function_exists( 'blade_grve_print_post_structured_data' ) ) {
		blade_grve_print_post_structured_data();
	}
}

//Replace all default templates.
add_filter( 'vc_load_default_templates_action', 'grve_blade_vce_add_custom_templates' );

function grve_blade_vce_add_custom_templates() {

/** Icon Boxes Section (Large) */
$data = array();
$data['name'] = esc_html__( 'Icon Boxes Section (Large)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row padding_top="90" padding_bottom="90" margin_bottom="0"][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="primary-5" title="UNIQUE DESIGNS" heading="h5" animation="fadeIn" animation_delay="400" icon_entypo="entypo-icon entypo-icon-star"]We tick masterfully all the boxes of a complete site by offering cutting edge design solutions.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="primary-5" title="AMAZING INTERFACE" heading="h5" animation="fadeIn" animation_delay="600" icon_entypo="entypo-icon entypo-icon-rocket"]Out of love for stylish and functional WP themes and for taking pride to support you.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="primary-5" title="EXTENSIVE TUTORIALS" heading="h5" animation="fadeIn" animation_delay="800" icon_entypo="entypo-icon entypo-icon-video"]Blade comes with an extensive live documentation and multiple HD videos.[/grve_icon_box][/vc_column][vc_column tablet_sm_width="hide" mobile_width="hide"][vc_empty_space height="60px"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="primary-5" title="HIGH RATED TEAM" heading="h5" animation="fadeIn" animation_delay="400" icon_entypo="entypo-icon entypo-icon-users"]Our customers’ reviews can make all potential customers feel confident about our products.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="primary-5" title="PROBLEM SOLVERS" heading="h5" animation="fadeIn" animation_delay="600" icon_entypo="entypo-icon entypo-icon-traffic-cone"] For you to stand out we take pride in supporting you all the way through 24/7.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="primary-5" title="GROUNDBREAKERS" heading="h5" animation="fadeIn" animation_delay="800" icon_entypo="entypo-icon entypo-icon-flag"]With respect to your need to stand out from the pack we offer you our ideas, our dreams.[/grve_icon_box][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Icon Boxes Section (Large - Circle Shape) */
$data = array();
$data['name'] = esc_html__( 'Icon Boxes Section (Large - Circle Shape)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row padding_top="90" padding_bottom="90" margin_bottom="0"][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="UNIQUE DESIGNS" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="400" icon_entypo="entypo-icon entypo-icon-star"]We tick masterfully all the boxes of a complete site by offering cutting edge design solutions.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="AMAZING INTERFACE" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="600" icon_entypo="entypo-icon entypo-icon-rocket"]Out of love for stylish and functional WP themes and for taking pride to support you.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="EXTENSIVE TUTORIALS" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="800" icon_entypo="entypo-icon entypo-icon-video"]Blade comes with an extensive live documentation and multiple HD videos.[/grve_icon_box][/vc_column][vc_column tablet_sm_width="hide" mobile_width="hide"][vc_empty_space height="60px"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="HIGH RATED TEAM" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="400" icon_entypo="entypo-icon entypo-icon-users"]Our customers’ reviews can make all potential customers feel confident about our products.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="PROBLEM SOLVERS" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="600" icon_entypo="entypo-icon entypo-icon-traffic-cone"] For you to stand out we take pride in supporting you all the way through 24/7.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="large" align="center" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="GROUNDBREAKERS" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="800" icon_entypo="entypo-icon entypo-icon-flag"]With respect to your need to stand out from the pack we offer you our ideas, our dreams.[/grve_icon_box][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Icon Boxes Section (Small) */
$data = array();
$data['name'] = esc_html__( 'Icon Boxes Section (Small)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row padding_top="90" padding_bottom="90" margin_bottom="0"][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" title="UNIQUE DESIGNS" heading="h5" animation="fadeIn" animation_delay="400" icon_entypo="entypo-icon entypo-icon-star"]We tick masterfully all the boxes of a complete site by offering cutting edge design solutions.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" title="AMAZING INTERFACE" heading="h5" animation="fadeIn" animation_delay="600" icon_entypo="entypo-icon entypo-icon-rocket"]Out of love for stylish and functional WP themes and for taking pride to support you.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" title="EXTENSIVE TUTORIALS" heading="h5" animation="fadeIn" animation_delay="800" icon_entypo="entypo-icon entypo-icon-video"]Blade comes with an extensive live documentation and multiple HD videos.[/grve_icon_box][/vc_column][vc_column tablet_sm_width="hide" mobile_width="hide"][vc_empty_space height="60px"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" title="HIGH RATED TEAM" heading="h5" animation="fadeIn" animation_delay="400" icon_entypo="entypo-icon entypo-icon-users"]Our customers’ reviews can make all potential customers feel confident about our products.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" title="PROBLEM SOLVERS" heading="h5" animation="fadeIn" animation_delay="600" icon_entypo="entypo-icon entypo-icon-traffic-cone"] For you to stand out we take pride in supporting you all the way through 24/7.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" title="GROUNDBREAKERS" heading="h5" animation="fadeIn" animation_delay="800" icon_entypo="entypo-icon entypo-icon-flag"]With respect to your need to stand out from the pack we offer you our ideas, our dreams.[/grve_icon_box][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Icon Boxes Section (Small - Circle Shape) */
$data = array();
$data['name'] = esc_html__( 'Icon Boxes Section (Small - Circle Shape)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row padding_top="90" padding_bottom="90" margin_bottom="0"][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="UNIQUE DESIGNS" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="400" icon_entypo="entypo-icon entypo-icon-star"]We tick masterfully all the boxes of a complete site by offering cutting edge design solutions.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="AMAZING INTERFACE" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="600" icon_entypo="entypo-icon entypo-icon-rocket"]Out of love for stylish and functional WP themes and for taking pride to support you.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="EXTENSIVE TUTORIALS" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="800" icon_entypo="entypo-icon entypo-icon-video"]Blade comes with an extensive live documentation and multiple HD videos.[/grve_icon_box][/vc_column][vc_column tablet_sm_width="hide" mobile_width="hide"][vc_empty_space height="60px"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="HIGH RATED TEAM" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="400" icon_entypo="entypo-icon entypo-icon-users"]Our customers’ reviews can make all potential customers feel confident about our products.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="PROBLEM SOLVERS" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="600" icon_entypo="entypo-icon entypo-icon-traffic-cone"] For you to stand out we take pride in supporting you all the way through 24/7.[/grve_icon_box][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][grve_icon_box icon_size="small" icon_library="entypo" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="GROUNDBREAKERS" heading="h5" icon_hover_effect="yes" animation="fadeIn" animation_delay="800" icon_entypo="entypo-icon entypo-icon-flag"]With respect to your need to stand out from the pack we offer you our ideas, our dreams.[/grve_icon_box][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Counters Section (Dark) */
$data = array();
$data['name'] = esc_html__( 'Counters Section (Dark)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" bg_type="color" padding_top="30" padding_bottom="30" margin_bottom="0" font_color="rgba(255,255,255,0.6)" bg_color="#232323"][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1447071485603{border-right-width: 1px !important;border-right-color: rgba(255,255,255,0.08) !important;border-right-style: solid !important;}"][grve_counter counter_end_val="25604" title="CODE LINES" heading="h6" animation="fadeInUp"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1447071498416{border-right-width: 1px !important;border-right-color: rgba(255,255,255,0.08) !important;border-right-style: solid !important;}"][grve_counter counter_end_val="2300" counter_suffix="+" title="CUSTOMERS" heading="h6" animation="fadeInUp" animation_delay="400"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1447071504300{border-right-width: 1px !important;border-right-color: rgba(255,255,255,0.08) !important;border-right-style: solid !important;}"][grve_counter counter_end_val="4500" title="HOURS" heading="h6" animation="fadeInUp" animation_delay="600"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1447071509970{border-right-width: 1px !important;border-right-color: rgba(255,255,255,0.08) !important;border-right-style: solid !important;}"][grve_counter counter_end_val="1980" title="TICKETS" heading="h6" animation="fadeInUp" animation_delay="800"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1447071515640{border-right-width: 1px !important;border-right-color: rgba(255,255,255,0.08) !important;border-right-style: solid !important;}"][grve_counter counter_end_val="270" title="DAYS" heading="h6" animation="fadeInUp" animation_delay="1000"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1443608176127{border-right-width: 1px !important;}"][grve_counter counter_end_val="219" title="RATINGS" heading="h6" animation="fadeInUp" animation_delay="1200"][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Counters Section (Light) */
$data = array();
$data['name'] = esc_html__( 'Counters Section (Light)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row heading_color="dark" section_type="fullwidth" padding_top="30" padding_bottom="30" margin_bottom="0"][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1446189538607{border-right-width: 1px !important;border-right-color: #e4e4e4 !important;border-right-style: solid !important;}"][grve_counter counter_end_val="25604" counter_color="grey" title="CODE LINES" heading="h6" animation="fadeInUp"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1446189528579{border-right-width: 1px !important;border-right-color: #e4e4e4 !important;border-right-style: solid !important;}"][grve_counter counter_end_val="2300" counter_suffix="+" counter_color="grey" title="CUSTOMERS" heading="h6" animation="fadeInUp" animation_delay="400"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1446189546232{border-right-width: 1px !important;border-right-color: #e4e4e4 !important;border-right-style: solid !important;}"][grve_counter counter_end_val="4500" counter_color="grey" title="HOURS" heading="h6" animation="fadeInUp" animation_delay="600"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1446189555408{border-right-width: 1px !important;border-right-color: #e4e4e4 !important;border-right-style: solid !important;}"][grve_counter counter_end_val="1980" counter_color="grey" title="TICKETS" heading="h6" animation="fadeInUp" animation_delay="800"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1446189563904{border-right-width: 1px !important;border-right-color: #e4e4e4 !important;border-right-style: solid !important;}"][grve_counter counter_end_val="270" counter_color="grey" title="DAYS" heading="h6" animation="fadeInUp" animation_delay="1000"][/vc_column][vc_column width="1/6" tablet_sm_width="1-3" css=".vc_custom_1443608176127{border-right-width: 1px !important;}"][grve_counter counter_end_val="219" counter_color="grey" title="RATINGS" heading="h6" animation="fadeInUp" animation_delay="1200"][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Callout Section */
$data = array();
$data['name'] = esc_html__( 'Callout Section', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" font_color="rgba(255,255,255,0.65)" bg_color="#e76b63" padding_top="30" padding_bottom="30" margin_bottom="0"][vc_column][grve_callout title="Your feedback has been delivered and we are back" heading="h5" button_text="Get in touch with us" button_type="outline" button_color="white" button_hover_color="white" button_link="url:%23||"][/grve_callout][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Typed Text Section */
$data = array();
$data['name'] = esc_html__( 'Typed Text Section', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row heading_color="light" equal_column_height="middle-content" bg_type="color" bg_color="#232323" padding_top="60" padding_bottom="60" margin_bottom="0"][vc_column][grve_typed_text typed_prefix="BLADE COMES WITH" typed_values="LIVE DOCUMENTATION,VIDEO TUTORIALS,DEDICATED SUPPORT,LIFETIME UPDATES" heading="h4" text_color="primary-5" align="center" textspeed="100" backspeed="80" startdelay="0" backdelay="500" loop="yes" cursor_text="_"][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Pie Charts Section (Dark) */
$data = array();
$data['name'] = esc_html__( 'Pie Charts Section (Dark)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top="90" padding_bottom="90" margin_bottom="0" bg_color="#232323"][vc_column width="1/3"][grve_pie_chart pie_chart_val="78" pie_chart_suffix="%" title="Helpdesk Support" heading="h5" pie_chart_text="We create powerful and premium themes for both developers and end-users" pie_chart_val_color="#ffffff" pie_active_color="#d58263" pie_chart_color="rgba(0,0,0,0.15)"][/vc_column][vc_column width="1/3"][grve_pie_chart pie_chart_val="76" pie_chart_suffix="%" title="WP Framework" heading="h5" pie_chart_text="It’s with a great pleasure that we offer you our premium support" pie_chart_val_color="#ffffff" pie_active_color="#d58263" pie_chart_color="rgba(0,0,0,0.15)"][/vc_column][vc_column width="1/3"][grve_pie_chart pie_chart_val="68" pie_chart_suffix="%" title="CSS Capabilities" heading="h5" pie_chart_text="Each one of us has been involved with the Internet since its younger years" pie_chart_val_color="#ffffff" pie_active_color="#d58263" pie_chart_color="rgba(0,0,0,0.15)"][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Pie Charts Section (Light) */
$data = array();
$data['name'] = esc_html__( 'Pie Charts Section (Light)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row padding_top="90" padding_bottom="90" margin_bottom="0"][vc_column width="1/3"][grve_pie_chart pie_chart_val="78" pie_chart_suffix="%" title="Helpdesk Support" heading="h5" pie_chart_text="We create powerful and premium themes for both developers and end-users" pie_chart_val_color="#000000" pie_active_color="#d58263" pie_chart_color="rgba(0,0,0,0.15)"][/vc_column][vc_column width="1/3"][grve_pie_chart pie_chart_val="76" pie_chart_suffix="%" title="WP Framework" heading="h5" pie_chart_text="It’s with a great pleasure that we offer you our premium support" pie_chart_val_color="#000000" pie_active_color="#d58263" pie_chart_color="rgba(0,0,0,0.15)"][/vc_column][vc_column width="1/3"][grve_pie_chart pie_chart_val="68" pie_chart_suffix="%" title="CSS Capabilities" heading="h5" pie_chart_text="Each one of us has been involved with the Internet since its younger years" pie_chart_val_color="#000000" pie_active_color="#d58263" pie_chart_color="rgba(0,0,0,0.15)"][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Slogan with Icon */
$data = array();
$data['name'] = esc_html__( 'Slogan with Icon', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row padding_top="90" margin_bottom="0" padding_bottom="90"][vc_column css=".vc_custom_1443538596041{padding-right: 10% !important;padding-left: 10% !important;}"][grve_icon icon_size="large" align="center" icon_library="entypo" icon_entypo="entypo-icon entypo-icon-star-empty"][grve_slogan title="Based on your feedback" heading="h2" increase_heading="120" subtitle="We create Digital Solutions" text_style="subtitle" align="center" button_text="" button2_text=""]We offer you the full control on “restricted” areas since now.[/grve_slogan][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Slogans 3 Columns */
$data = array();
$data['name'] = esc_html__( 'Slogans 3 Columns', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" padding_top="90" padding_bottom="90" margin_bottom="0"][vc_column width="1/3" css=".vc_custom_1447071196228{padding-right: 3% !important;padding-left: 3% !important;}"][grve_slogan title="Create" heading="h2" align="center" button_text="Learn More About" button_type="outline" button_color="grey" button_hover_color="primary-1" button_size="small" button_link="url:%23||" button2_text=""]Boundless creativity. Never rest, always in a creative flux. We test the limits of creativity every single day to meet the most demanding minds out there.[/grve_slogan][/vc_column][vc_column width="1/3" css=".vc_custom_1447071179870{padding-right: 3% !important;padding-left: 3% !important;}"][grve_slogan title="Excel" heading="h2" align="center" button_text="Learn More About" button_type="outline" button_color="grey" button_hover_color="primary-1" button_size="small" button_link="url:%23||" button2_text=""]Excel for greatness. We strive for excellence and share our knowledge so that users and developers become creative and great, become ‘Blade’.[/grve_slogan][/vc_column][vc_column width="1/3" css=".vc_custom_1447071189219{padding-right: 3% !important;padding-left: 3% !important;}"][grve_slogan title="Share" heading="h2" align="center" button_text="Learn More About" button_type="outline" button_color="grey" button_hover_color="primary-1" button_size="small" button_link="url:%23||" button2_text=""]Support all the way through. We share our web design wisdom and excellence for you to evolve and stand out from the competition.[/grve_slogan][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Steps Section (Dark) */
$data = array();
$data['name'] = esc_html__( 'Steps Section (Dark)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" equal_column_height="equal-column" bg_type="color" bg_color="#232323" margin_bottom="0" font_color="#8e8e8e"][vc_column width="1/3" css=".vc_custom_1443610153759{padding: 3% !important;background-color: #2d2d2d !important;}"][vc_custom_heading text="01." font_container="tag:div|font_size:80|text_align:left|color:%23888888|line_height:90px" css=".vc_custom_1447070134714{margin-bottom: 18px !important;}"][grve_slogan title="SHARING EXCELLENCE" heading="h4" subtitle="OUR PHILOSOPHY" button_text="" button2_text=""]You’re looking for answers, would like to solve a problem, or just want to let us know how we did.[/grve_slogan][/vc_column][vc_column width="1/3" css=".vc_custom_1443610175911{padding: 3% !important;background-color: #282828 !important;}"][vc_custom_heading text="02." font_container="tag:div|font_size:80|text_align:left|color:%23888888|line_height:90px" css=".vc_custom_1447070140710{margin-bottom: 18px !important;}"][grve_slogan title="BUSINESS JUMPSTART" heading="h4" subtitle="OUR SCOPE" button_text="" button2_text=""]You’re looking for answers, would like to solve a problem, or just want to let us know how we did.[/grve_slogan][/vc_column][vc_column width="1/3" css=".vc_custom_1443610182807{padding: 3% !important;}"][vc_custom_heading text="03." font_container="tag:div|font_size:80|text_align:left|color:%23888888|line_height:90px" css=".vc_custom_1447070147415{margin-bottom: 18px !important;}"][grve_slogan title="PROBLEM SOLVERS" heading="h4" subtitle="OUR HONESTY" button_text="" button2_text=""]You’re looking for answers, would like to solve a problem, or just want to let us know how we did.[/grve_slogan][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Steps Section (Light) */
$data = array();
$data['name'] = esc_html__( 'Steps Section (Light)', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row padding_top="90" padding_bottom="90" margin_bottom="0"][vc_column width="1/3"][grve_pie_chart pie_chart_val="78" pie_chart_suffix="%" title="Helpdesk Support" heading="h5" pie_chart_text="We create powerful and premium themes for both developers and end-users" pie_chart_val_color="#000000" pie_active_color="#d58263" pie_chart_color="rgba(0,0,0,0.15)"][/vc_column][vc_column width="1/3"][grve_pie_chart pie_chart_val="76" pie_chart_suffix="%" title="WP Framework" heading="h5" pie_chart_text="It’s with a great pleasure that we offer you our premium support" pie_chart_val_color="#000000" pie_active_color="#d58263" pie_chart_color="rgba(0,0,0,0.15)"][/vc_column][vc_column width="1/3"][grve_pie_chart pie_chart_val="68" pie_chart_suffix="%" title="CSS Capabilities" heading="h5" pie_chart_text="Each one of us has been involved with the Internet since its younger years" pie_chart_val_color="#000000" pie_active_color="#d58263" pie_chart_color="rgba(0,0,0,0.15)"][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

/** Share Section */
$data = array();
$data['name'] = esc_html__( 'Share Section', 'grve-blade-vc-extension' );
$data['content'] = <<<CONTENT
[vc_row padding_top="90" padding_bottom="90" margin_bottom="0"][vc_column][grve_slogan title="SHARE ON" heading="h4" align="center" button_text="" button2_text=""][/grve_slogan][grve_social social_facebook="yes" social_twitter="yes" social_linkedin="yes" social_reddit="yes" grve_likes="yes" icon_color="black" icon_shape="circle" shape_color="grey" shape_type="outline" align="center"][vc_column_text text_style="subtitle"]<p style="text-align: center;"><span style="color: #000000;">With <i class="fa fa-heart-o"></i> by <a style="color: #000000;" href="http://greatives.eu" target="_blank">Greatives</a> - HQ Themes</span></p>[/vc_column_text][/vc_column][/vc_row]
CONTENT;
vc_add_default_templates( $data );

return $data;

}

/**
 * Custom Content Filters
 */
add_filter( 'blade_ext_the_content', 'wptexturize'                       );
add_filter( 'blade_ext_the_content', 'convert_smilies',               20 );
add_filter( 'blade_ext_the_content', 'wpautop'                           );
add_filter( 'blade_ext_the_content', 'shortcode_unautop'                 );
add_filter( 'blade_ext_the_content', 'prepend_attachment'                );
add_filter( 'blade_ext_the_content', 'wp_make_content_images_responsive' );
add_filter( 'blade_ext_the_content', 'do_shortcode',                  11 );

//Omit closing PHP tag to avoid accidental whitespace output errors.
