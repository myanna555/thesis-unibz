<?php
/**
 * Team Shortcode
 */

if( !function_exists( 'grve_blade_vce_team_shortcode' ) ) {

	function grve_blade_vce_team_shortcode( $attr, $content ) {

		$output = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'image' => '',
					'image_size' => 'square',
					'team_style' => 'style-1',
					'zoom_effect' => 'none',
					'overlay_color' => 'light',
					'overlay_opacity' => '90',
					'name' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'identity' => '',
					'social_facebook' => '',
					'social_twitter' => '',
					'social_linkedin' => '',
					'social_github' => '',
					'social_xing' => '',
					'align' => 'left',
					'email' => '',
					'link' => '',
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

		$heading_class = 'grve-' . $heading;

		if( 'square' == $image_size ) {
			$image_size = 'blade-grve-small-square';
		} elseif( 'portrait' == $image_size ) {
			$image_size = 'blade-grve-small-rect-vertical';
		} elseif ( 'landscape' == $image_size ) {
			$image_size = 'blade-grve-small-rect-horizontal';
		} elseif( 'medium_large' == $image_size ) {
			$image_size = 'medium_large';
		} elseif( 'medium' == $image_size ) {
			$image_size = 'medium';
		}  else {
			$image_size = 'large';
		}

		//Team Title & Caption Color
		$text_color = 'light';
		if( 'light' == $overlay_color ) {
			$text_color = 'dark';
		}


		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		if ( !empty( $image ) ) {
			$id = preg_replace('/[^\d]/', '', $image);
			$image_string = wp_get_attachment_image( $id, $image_size );
		} else {
			$image_src = GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL .'assets/images/empty/' . $image_size . '.jpg';
			$image_string = '<img src="' . esc_url( $image_src ) . '" alt="Empty Team"">';
		}

		if ( !empty( $link ) ){
			$href = vc_build_link( $link );
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

		$email_string =  apply_filters( 'blade_grve_vce_string_email', esc_html__( 'E-mail', 'grve-blade-vc-extension' ) );

		$links = '';
		if ( !empty( $social_facebook ) ) {
			$links .= '<li><a href="' . esc_url( $social_facebook ) . '" target="_blank" class="grve-text-' . esc_attr( $text_color ) . '">Facebook</a></li>';
		}
		if ( !empty( $social_twitter ) ) {
			$links .= '<li><a href="' . esc_url( $social_twitter ) . '" target="_blank" class="grve-text-' . esc_attr( $text_color ) . '">Twitter</a></li>';
		}
		if ( !empty( $social_linkedin ) ) {
			$links .= '<li><a href="' . esc_url( $social_linkedin ) . '" target="_blank" class="grve-text-' . esc_attr( $text_color ) . '">Linkedin</a></li>';
		}
		if ( !empty( $social_github ) ) {
			$links .= '<li><a href="' . esc_url( $social_github ) . '" target="_blank" class="grve-text-' . esc_attr( $text_color ) . '">GitHub</a></li>';
		}
		if ( !empty( $social_xing ) ) {
			$links .= '<li><a href="' . esc_url( $social_xing ) . '" target="_blank" class="grve-text-' . esc_attr( $text_color ) . '">XING</a></li>';
		}
		if ( !empty( $email ) ) {
			$links .= '<li><a href="mailto:' . antispambot( $email ) . '" class="grve-text-' . esc_attr( $text_color ) . '">' . esc_html( $email_string ). '</a></li>';
		}

		$team_classes = array( 'grve-element' );

		array_push( $team_classes, 'grve-' . $team_style);

		if ( !empty( $animation ) ) {
			array_push( $team_classes, 'grve-animated-item' );
			array_push( $team_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}
		if ( !empty( $el_class ) ) {
			array_push( $team_classes, $el_class);
		}

		$team_class_string = implode( ' ', $team_classes );


		ob_start();

		?>

		<?php
		if ( 'style-1' == $team_style ) {
		?>
		<div class="grve-team <?php echo esc_attr( $team_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data; ?>>
			<figure class="grve-image-hover">
				<div class="grve-team-person grve-media">
				<?php if ( !empty( $url ) && '#' != $url ) { ?>
					<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>">
				<?php } ?>
					<?php echo $image_string; ?>
				<?php if ( !empty( $url ) && '#' != $url ) { ?>
					</a>
				<?php } ?>
				</div>
				<figcaption>
					<div class="grve-team-content">
						<div class="grve-team-description grve-align-<?php echo $align; ?>">
							<div class="grve-team-identity grve-subtitle"><?php echo $identity; ?></div>
							<?php if ( !empty( $url ) && '#' != $url ) { ?>
							<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>">
							<?php } ?>
							<<?php echo tag_escape( $heading_tag ); ?> class="grve-team-name grve-text-hover-primary-1 <?php echo esc_attr( $heading_class ); ?>"><?php echo $name; ?></<?php echo tag_escape( $heading_tag ); ?>>
							<?php if ( !empty( $url ) && '#' != $url ) { ?>
							</a>
							<?php } ?>
							<?php if ( !empty( $content ) ) { ?>
							<p><?php echo grve_blade_vce_unautop( $content ); ?></p>
							<?php } ?>
						</div>
						<?php if ( !empty( $links ) ) { ?>
						<div class="grve-team-social grve-list-divider grve-small-text grve-align-<?php echo esc_attr( $align ); ?>">
							<ul>
								<?php echo $links; ?>
							</ul>
						</div>
						<?php } ?>
					</div>
				</figcaption>
			</figure>
		</div>
		<?php
			} else {
		?>
		<div class="grve-team <?php echo esc_attr( $team_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data; ?>>

			<figure class="grve-image-hover grve-zoom-<?php echo esc_attr( $zoom_effect ); ?>">
				<div class="grve-team-person grve-media">
					<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
					<?php echo $image_string; ?>
				</div>
				<figcaption>
					<div class="grve-team-content">
						<div class="grve-team-description grve-align-<?php echo $align; ?>">
							<div class="grve-team-identity grve-subtitle grve-text-<?php echo esc_attr( $text_color ); ?>"><?php echo $identity; ?></div>
							<?php if ( !empty( $url ) && '#' != $url ) { ?>
							<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>">
							<?php } ?>
							<<?php echo tag_escape( $heading_tag ); ?> class="grve-team-name <?php echo esc_attr( $heading_class ); ?> grve-text-<?php echo esc_attr( $text_color ); ?>"><?php echo $name; ?></<?php echo tag_escape( $heading_tag ); ?>>
							<?php if ( !empty( $url ) && '#' != $url ) { ?>
							</a>
							<?php } ?>
						</div>
						<?php if ( !empty( $links ) ) { ?>
						<div class="grve-team-social grve-list-divider grve-small-text grve-align-<?php echo esc_attr( $align ); ?> grve-text-<?php echo esc_attr( $text_color ); ?>">
							<ul>
								<?php echo $links; ?>
							</ul>
						</div>
						<?php } ?>
					</div>
				</figcaption>
			</figure>

		</div>
		<?php
			}
		?>

		<?php

		return ob_get_clean();

	}
	add_shortcode( 'grve_team', 'grve_blade_vce_team_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_team_shortcode_params' ) ) {
	function grve_blade_vce_team_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Team", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Show your team members", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-team",
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
					"type" => "dropdown",
					"heading" => esc_html__( "Image Mode", "grve-blade-vc-extension" ),
					"param_name" => "image_size",
					'value' => array(
						esc_html__( 'Square Crop', 'grve-blade-vc-extension' ) => 'square',
						esc_html__( 'Landscape Crop', 'grve-blade-vc-extension' ) => 'landscape',
						esc_html__( 'Portrait Crop', 'grve-blade-vc-extension' ) => 'portrait',
						esc_html__( 'Resize ( Large )', 'grve-blade-vc-extension' ) => 'resize',
						esc_html__( 'Resize ( Medium Large )', 'grve-blade-vc-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'grve-blade-vc-extension' ) => 'medium',
					),
					'std' => 'square',
					"description" => esc_html__( "Select your Image Mode.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Team Style", "grve-blade-vc-extension" ),
					"param_name" => "team_style",
					"value" => array(
						esc_html__( "Style 1", "grve-blade-vc-extension" ) => 'style-1',
						esc_html__( "Style 2", "grve-blade-vc-extension" ) => 'style-2',
					),
					"description" => esc_html__( "Style of the team.", "grve-blade-vc-extension" ),
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
					"dependency" => array( 'element' => "team_style", 'value' => array( 'style-2' ) ),
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
					"dependency" => array( 'element' => "team_style", 'value' => array( 'style-2' ) ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "grve-blade-vc-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "team_style", 'value' => array( 'style-2' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Name", "grve-blade-vc-extension" ),
					"param_name" => "name",
					"value" => "John Smith",
					"description" => esc_html__( "Enter your team name.", "grve-blade-vc-extension" ),
					"save_always" => true,
					"admin_label" => true,
				),
				grve_blade_vce_get_heading_tag( "h3" ),
				grve_blade_vce_get_heading( "h3" ),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Identity", "grve-blade-vc-extension" ),
					"param_name" => "identity",
					"value" => "",
					"description" => esc_html__( "Enter your team identity/profession e.g: Designer", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Facebook", "grve-blade-vc-extension" ),
					"param_name" => "social_facebook",
					"value" => "",
					"description" => esc_html__( "Enter facebook URL. Clear input if you don't want to display.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Twitter", "grve-blade-vc-extension" ),
					"param_name" => "social_twitter",
					"value" => "",
					"description" => esc_html__( "Enter twitter URL. Clear input if you don't want to display.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Linkedin", "grve-blade-vc-extension" ),
					"param_name" => "social_linkedin",
					"value" => "",
					"description" => esc_html__( "Enter linkedin URL. Clear input if you don't want to display.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "GitHub", "grve-blade-vc-extension" ),
					"param_name" => "social_github",
					"value" => "",
					"description" => esc_html__( "Enter GitHub URL. Clear input if you don't want to display.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "XING", "grve-blade-vc-extension" ),
					"param_name" => "social_xing",
					"value" => "",
					"description" => esc_html__( "Enter XING URL. Clear input if you don't want to display.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Email", "grve-blade-vc-extension" ),
					"param_name" => "email",
					"value" => "",
					"description" => esc_html__( "Enter your email. Clear input if you don't want to display.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "grve-blade-vc-extension" ),
					"param_name" => "content",
					"value" => "Sample Text",
					"description" => esc_html__( "Enter your text.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "team_style", 'value' => array( 'style-1' ) ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Link", "grve-blade-vc-extension" ),
					"param_name" => "link",
					"value" => "",
					"description" => esc_html__( "Enter link.", "grve-blade-vc-extension" ),
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
	vc_lean_map( 'grve_team', 'grve_blade_vce_team_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_team_shortcode_params( 'grve_team' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
