<?php
/**
 * Icon Box Shortcode
 */

if( !function_exists( 'grve_blade_vce_icon_box_shortcode' ) ) {

	function grve_blade_vce_icon_box_shortcode( $atts, $content ) {

		$output = $link_start = $link_end = $retina_data = $text_style_class = $data = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'title' => '',
					'heading_tag' => 'h3',
					'heading' => 'h3',
					'icon_library' => 'fontawesome',
					'icon_fontawesome' => 'fa fa-adjust',
					'icon_openiconic' => 'vc-oi vc-oi-dial',
					'icon_typicons' => 'typcn typcn-adjust-brightness',
					'icon_entypo' => 'entypo-icon entypo-icon-note',
					'icon_linecons' => 'vc_li vc_li-heart',
					'icon_simplelineicons' => 'smp-icon-user',
					'icon_type' => 'icon',
					'icon_size' => 'medium',
					'icon_shape' => 'no-shape',
					'shape_type' => 'simple',
					'icon_color' => 'primary-1',
					'icon_shape_color' => 'grey',
					'icon_animation' => 'no',
					'icon_hover_effect' => 'no',
					'icon_char' => '',
					'icon_image' => '',
					'retina_icon_image' => '',
					'align' => 'left',
					'text_style' => 'none',
					'link' => '',
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

		$icon_box_classes = array( 'grve-element' );

		array_push( $icon_box_classes, 'grve-box-icon' );
		array_push( $icon_box_classes, 'grve-align-' . $align );
		array_push( $icon_box_classes, 'grve-' . $icon_size );

		if ( !empty( $animation ) ) {
			array_push( $icon_box_classes, 'grve-animated-item' );
			array_push( $icon_box_classes, $animation);
			$data = ' data-delay="' . esc_attr( $animation_delay ) . '"';
		}

		if ( 'yes' == $icon_animation ) {
			array_push( $icon_box_classes, 'grve-advanced-hover' );
		}
		if ( !empty ( $el_class ) ) {
			array_push( $icon_box_classes, $el_class);
		}

		if( 'yes' == $icon_hover_effect && 'no-shape' != $icon_shape ) {
			array_push( $icon_box_classes, 'grve-hover-effect' );
		}

		$icon_wrapper_classes = array( 'grve-wrapper-icon' );
		$icon_classes = array();

		if ( 'no-shape' != $icon_shape ) {
			array_push( $icon_wrapper_classes, 'grve-' . $shape_type );
			array_push( $icon_box_classes, 'grve-with-shape' );
		}
		array_push( $icon_wrapper_classes, 'grve-' . $icon_shape );

		if ( 'no-shape' != $icon_shape && 'outline' != $shape_type ) {
			array_push( $icon_wrapper_classes, 'grve-bg-' . $icon_shape_color );
		} else {
			array_push( $icon_wrapper_classes, 'grve-text-' . $icon_shape_color );
		}

		if ( 'icon' == $icon_type ) {

			$icon_class = isset( ${"icon_" . $icon_library} ) ? esc_attr( ${"icon_" . $icon_library} ) : 'fa fa-adjust';
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				vc_icon_element_fonts_enqueue( $icon_library );
			}
			array_push( $icon_classes, $icon_class );
			array_push( $icon_classes, 'grve-text-' . $icon_color );
		}

		if ( 'image' == $icon_type ) {
			array_push( $icon_wrapper_classes, 'grve-image-icon' );
		}

		$icon_box_class_string = implode( ' ', $icon_box_classes );
		$icon_wrapper_class_string = implode( ' ', $icon_wrapper_classes );
		$icon_class_string = implode( ' ', $icon_classes );


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

		if ( !empty( $url ) && '#' != $url ) {
			$link_start = '<a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '">';
			$link_end = '</a>';
		}

		// Paragraph
		if ( 'none' != $text_style ) {
			$text_style_class = 'grve-' .$text_style;
		}

		$style = grve_blade_vce_build_margin_bottom_style( $margin_bottom );

		$output .= '<div class="' . esc_attr( $icon_box_class_string ) . '" style="' . $style . '"' . $data . '>';

		$output .= $link_start;

		if ( 'image' == $icon_type ) {
			if ( !empty( $icon_image ) ) {
				$img_id = preg_replace('/[^\d]/', '', $icon_image);
				$img_src = wp_get_attachment_image_src( $img_id, 'full' );
				$img_url = $img_src[0];
				$image_srcset = '';
				if ( !empty( $retina_icon_image ) ) {
					$img_retina_id = preg_replace('/[^\d]/', '', $retina_icon_image);
					$img_retina_src = wp_get_attachment_image_src( $img_retina_id, 'full' );
					$retina_url = $img_retina_src[0];
					$image_srcset = $img_url . ' 1x,' . $retina_url . ' 2x';
				}
				$output .= '<div class="grve-image-icon">';
				$output .= wp_get_attachment_image( $img_id, 'full' , "", array( 'srcset'=> $image_srcset ) );
				$output .= '</div>';
			} else {
				$dummy_image_url = GRVE_BLADE_VC_EXT_PLUGIN_DIR_URL .'assets/images/empty/thumbnail.jpg';
				$output .= '  <div class="grve-image-icon"><img alt="Dummy Image" src="' . esc_url( $dummy_image_url ) . '" width="150" height="150"></div>';
			}
		} else if( 'char' == $icon_type ) {
			$output .= '  <div class="' . esc_attr( $icon_wrapper_class_string ) . '"><span class="grve-text-' . esc_attr( $icon_color ) . '">'. $icon_char. '</span></div>';
		} else {
			$output .= '  <div class="' . esc_attr( $icon_wrapper_class_string ) . '"><i class="'. esc_attr( $icon_class_string ) . '"></i></div>';
		}

		$output .= '  <div class="grve-box-content">';
		if ( !empty( $title ) ) {
		$output .= '      <' . tag_escape( $heading_tag ) . ' class="grve-box-title ' . esc_attr( $heading_class ) . '">' . $title. '</' . tag_escape( $heading_tag ) . '>';
		}
		if ( !empty( $content ) ) {
		$output .= '    <p class="' . esc_attr( $text_style_class ) . '">' . grve_blade_vce_unautop( $content ) . '</p>';
		}
		$output .= '  </div>';
		$output .= $link_end;
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'grve_icon_box', 'grve_blade_vce_icon_box_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'grve_blade_vce_icon_box_shortcode_params' ) ) {
	function grve_blade_vce_icon_box_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Icon Box", "grve-blade-vc-extension" ),
			"description" => esc_html__( "Add an icon, character or image with title and text", "grve-blade-vc-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-icon-box",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon Box Type", "grve-blade-vc-extension" ),
					"param_name" => "icon_type",
					"value" => array(
						esc_html__( "Icon", "grve-blade-vc-extension" ) => 'icon',
						esc_html__( "Image", "grve-blade-vc-extension" ) => 'image',
						esc_html__( "Character", "grve-blade-vc-extension" ) => 'char',
					),
					"description" => '',
					"admin_label" => true,
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon size", "grve-blade-vc-extension" ),
					"param_name" => "icon_size",
					"value" => array(
						esc_html__( "Large", "grve-blade-vc-extension" ) => 'large',
						esc_html__( "Medium", "grve-blade-vc-extension" ) => 'medium',
						esc_html__( "Small", "grve-blade-vc-extension" ) => 'small',
						esc_html__( "Extra Small", "grve-blade-vc-extension" ) => 'extra-small',
					),
					"std" => 'medium',
					"description" => '',
				),
				grve_blade_vce_add_align(),
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
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon' ) ),
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
					"description" => esc_html__( "Color of the icon.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon', 'char' ) ),
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
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'icon', 'char' ) ),
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
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Icon Shape Color", "grve-blade-vc-extension" ),
					"param_name" => "icon_shape_color",
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
					'std' => 'grey',
					"description" => esc_html__( "This affects to the Background of the simple shape type. Alternatively, affects to the line shape type.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Advanced Hover", "grve-blade-vc-extension" ),
					"param_name" => "icon_animation",
					"value" => array( esc_html__( "If selected, you will have advanced hover.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "align", 'value' => array( 'center' ) ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Icon Image", "grve-blade-vc-extension" ),
					"param_name" => "icon_image",
					"value" => '',
					"description" => esc_html__( "Select an icon image.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'image' ) ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__( "Retina Icon Image", "grve-blade-vc-extension" ),
					"param_name" => "retina_icon_image",
					"value" => '',
					"description" => esc_html__( "Select a 2x icon.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'image' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Character", "grve-blade-vc-extension" ),
					"param_name" => "icon_char",
					"value" => "A",
					"description" => esc_html__( "Type a single character.", "grve-blade-vc-extension" ),
					"dependency" => array( 'element' => "icon_type", 'value' => array( 'char' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "grve-blade-vc-extension" ),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__( "Enter icon box title.", "grve-blade-vc-extension" ),
					"admin_label" => true,
				),
				grve_blade_vce_get_heading_tag( "h3" ),
				grve_blade_vce_get_heading( "h3" ),
				array(
					"type" => "textarea",
					"heading" => esc_html__( "Text", "grve-blade-vc-extension" ),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__( "Enter your content.", "grve-blade-vc-extension" ),
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
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Link", "grve-blade-vc-extension" ),
					"param_name" => "link",
					"value" => "",
					"description" => esc_html__( "Enter link.", "grve-blade-vc-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Hover Effect", "grve-blade-vc-extension" ),
					"param_name" => "icon_hover_effect",
					"value" => array( esc_html__( "If selected, you will have hover effect.", "grve-blade-vc-extension" ) => 'yes' ),
					"dependency" => array( 'element' => "icon_shape", 'value' => array( 'square', 'round', 'circle' ) ),
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
	vc_lean_map( 'grve_icon_box', 'grve_blade_vce_icon_box_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = grve_blade_vce_icon_box_shortcode_params( 'grve_icon_box' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
