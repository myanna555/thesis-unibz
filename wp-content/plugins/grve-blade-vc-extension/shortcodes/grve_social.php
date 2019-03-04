<?php
/**
 * Social Shortcode
 */

if( !function_exists( 'grve_blade_vce_social_shortcode' ) ) {

	function grve_blade_vce_social_shortcode( $atts, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'social_email' => '',
					'social_facebook' => '',
					'social_twitter' => '',
					'social_linkedin' => '',
					'social_googleplus' => '',
					'social_reddit' => '',
					'social_pinterest' => '',
					'social_tumblr' => '',
					'grve_likes' => '',
					'animation' => '',
					'align' => 'left',
					'shape_color' => 'primary-1',
					'icon_size' => 'medium',
					'icon_shape' => 'no-shape',
					'shape_type' => 'simple',
					'icon_color' => 'primary-1',
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


		$social_classes = array( 'grve-element', 'grve-social', 'grve-align-' . $align );

		if ( !empty( $animation ) ) {
			array_push( $social_classes, 'grve-animated-item' );
			array_push( $social_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $social_classes, $el_class);
		}
		$social_class_string = implode( ' ', $social_classes );

		$social_shape_classes = array();

		array_push( $social_shape_classes, 'grve-' . $icon_size );
		array_push( $social_shape_classes, 'grve-' . $icon_shape );

		if ( 'no-shape' != $icon_shape ) {
			array_push( $social_shape_classes, 'grve-with-shape' );
			array_push( $social_shape_classes, 'grve-' . $shape_type );
			if ( 'outline' != $shape_type ) {
				array_push( $social_shape_classes, 'grve-bg-' . $shape_color );
			} else {
				array_push( $social_shape_classes, 'grve-text-' . $shape_color );
				array_push( $social_shape_classes, 'grve-text-hover-' . $shape_color );
			}
		}

		$social_shape_class_string = implode( ' ', $social_shape_classes );


		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$grve_permalink = get_permalink();
		$grve_title = get_the_title();

		$image_size = 'large';
		if ( has_post_thumbnail() ) {
			$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
			$attachment_src = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );
			$grve_image_url = $attachment_src[0];
		} else {
			$grve_image_url = get_template_directory_uri() . '/images/empty/' . $image_size . '.jpg';
		}

		$page_email_string = 'mailto:?subject=' . $grve_title . '&body=' . $grve_title . ': ' . $grve_permalink;

		ob_start();

		?>
			<div class="<?php echo esc_attr( $social_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data; ?>>
				<ul>
					<?php if ( !empty( $social_email  ) ) { ?>
					<li><a href="<?php echo esc_url( $page_email_string ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-email"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-envelope"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_facebook ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-facebook"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-facebook"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_twitter ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-twitter"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-twitter"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_linkedin ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-linkedin"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-linkedin"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_googleplus ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-googleplus"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-google-plus"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_reddit ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-reddit"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-reddit"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_pinterest  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-pinterest" data-pin-img="<?php echo esc_url( $grve_image_url ); ?>" ><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-pinterest"></i></a></li>
					<?php } ?>
					<?php if ( !empty( $social_tumblr  ) ) { ?>
					<li><a href="<?php echo esc_url( $grve_permalink ); ?>" title="<?php echo esc_attr( $grve_title ); ?>" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-social-share-tumblr"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-tumblr"></i></a></li>
					<?php } ?>

					<?php if ( !empty( $grve_likes ) && function_exists( 'blade_grve_likes' ) ) {
						global $post;
						$post_id = $post->ID;
					?>
					<li><a href="#" class="<?php echo esc_attr( $social_shape_class_string ); ?> grve-like-counter-link" data-post-id="<?php echo esc_attr( $post_id ); ?>"><i class="grve-text-<?php echo esc_attr( $icon_color ); ?> fa fa-heart"></i><span class="grve-like-counter"><?php echo blade_grve_likes( $post_id ); ?></span></a></li>
					<?php } ?>

				</ul>
			</div>
		<?php

		return ob_get_clean();

	}
	add_shortcode( 'grve_social', 'grve_blade_vce_social_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_social_shortcode_params' ) ) {
	function grve_blade_vce_social_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Social", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Place your preferred social", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-social",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "E-mail", "grve-blade-vc-extension" ),
					"param_name" => "social_email",
					"description" => esc_html__( "Share with E-mail", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Show E-mail social share", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Facebook", "grve-blade-vc-extension" ),
					"param_name" => "social_facebook",
					"description" => esc_html__( "Share in Facebook", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Show Facebook social share", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Twitter", "grve-blade-vc-extension" ),
					"param_name" => "social_twitter",
					"description" => esc_html__( "Share in Twitter", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Show Twitter social share", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Linkedin", "grve-blade-vc-extension" ),
					"param_name" => "social_linkedin",
					"description" => esc_html__( "Share in Linkedin", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Show Linkedin social share", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Google +", "grve-blade-vc-extension" ),
					"param_name" => "social_googleplus",
					"description" => esc_html__( "Share in Google +", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Show Google + social share", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "reddit", "grve-blade-vc-extension" ),
					"param_name" => "social_reddit",
					"description" => esc_html__( "Submit in reddit", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Show reddit social share", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Pinterest", "grve-blade-vc-extension" ),
					"param_name" => "social_pinterest",
					"description" => esc_html__( "Submit in Pinterest (Featured Image is used as image)", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Show Pinterest social share", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Tumblr", "grve-blade-vc-extension" ),
					"param_name" => "social_tumblr",
					"description" => esc_html__( "Submit in Tumblr", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Show Tumblr social share", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "(Greatives) Likes", "grve-blade-vc-extension" ),
					"param_name" => "grve_likes",
					"description" => esc_html__( "(Greatives) Likes", "grve-blade-vc-extension" ),
					"value" => array( esc_html__( "Show (Greatives) Likes", "grve-blade-vc-extension" ) => 'yes' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon size", "grve-blade-vc-extension" ),
					"param_name" => "icon_size",
					"value" => array(
						esc_html__( "Large", "grve-blade-vc-extension" ) => 'large',
						esc_html__( "Medium", "grve-blade-vc-extension" ) => 'medium',
						esc_html__( "Small", "grve-blade-vc-extension" ) => 'small',
					),
					"std" => 'medium',
					"description" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon Color", "grve-blade-vc-extension" ),
					"param_name" => "icon_color",
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
					"description" => esc_html__( "Color of the social icon.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon shape", "grve-blade-vc-extension" ),
					"param_name" => "icon_shape",
					"value" => array(
						esc_html__( "None", "grve-blade-vc-extension" ) => 'no-shape',
						esc_html__( "Square", "grve-blade-vc-extension" ) => 'square',
						esc_html__( "Round", "grve-blade-vc-extension" ) => 'round',
						esc_html__( "Circle", "grve-blade-vc-extension" ) => 'circle',
					),
					"description" => '',
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Shape Color", "grve-blade-vc-extension" ),
					"param_name" => "shape_color",
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
					"description" => esc_html__( "Color of the shape.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Shape type", "grve-blade-vc-extension" ),
					"param_name" => "shape_type",
					"value" => array(
						esc_html__( "Simple", "grve-blade-vc-extension" ) => 'simple',
						esc_html__( "Outline", "grve-blade-vc-extension" ) => 'outline',
					),
					"description" => esc_html__( "Select shape type.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				grve_blade_vce_add_align(),
				grve_blade_vce_add_animation(),
				grve_blade_vce_add_animation_delay(),
				grve_blade_vce_add_margin_bottom(),
				grve_blade_vce_add_el_class(),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'grve_social', 'grve_blade_vce_social_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_social_shortcode_params( 'grve_social' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
