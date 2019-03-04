<?php

/*
 *	Helper functions
 *
 * 	@version	1.0
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */



 /**
 * Generic Parameters to reuse
 * Used in vc shortcodes
 */

if( !function_exists( 'grve_blade_vce_add_animation' ) ) {
	function grve_blade_vce_add_animation() {
		return array(
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
			"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "grve-blade-vc-extension" ),
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_animation_delay' ) ) {
	function grve_blade_vce_add_animation_delay() {
		return array(
			"type" => "textfield",
			"heading" => esc_html__('Css Animation Delay', 'grve-blade-vc-extension'),
			"param_name" => "animation_delay",
			"value" => '200',
			"description" => esc_html__( "Add delay in milliseconds.", "grve-blade-vc-extension" ),
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_margin_bottom' ) ) {
	function grve_blade_vce_add_margin_bottom() {
		return array(
			"type" => "textfield",
			"heading" => esc_html__('Bottom margin', 'grve-blade-vc-extension'),
			"param_name" => "margin_bottom",
			"description" => esc_html__( "You can use px, em, %, etc. or enter just number and it will use pixels.", "grve-blade-vc-extension" ),
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_el_class' ) ) {
	function grve_blade_vce_add_el_class() {
		return array(
			"type" => "textfield",
			"heading" => esc_html__( "Extra class name", "grve-blade-vc-extension" ),
			"param_name" => "el_class",
			"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "grve-blade-vc-extension" ),
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_align' ) ) {
	function grve_blade_vce_add_align() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "Alignment", "grve-blade-vc-extension" ),
			"param_name" => "align",
			"value" => array(
				esc_html__( "Left", "grve-blade-vc-extension" ) => 'left',
				esc_html__( "Right", "grve-blade-vc-extension" ) => 'right',
				esc_html__( "Center", "grve-blade-vc-extension" ) => 'center',
			),
			"description" => '',
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_order_by' ) ) {
	function grve_blade_vce_add_order_by() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "Order By", "grve-blade-vc-extension" ),
			"param_name" => "order_by",
			"value" => array(
				esc_html__( "Date", "grve-blade-vc-extension" ) => 'date',
				esc_html__( "Last modified date", "grve-blade-vc-extension" ) => 'modified',
				esc_html__( "Number of comments", "grve-blade-vc-extension" ) => 'comment_count',
				esc_html__( "Title", "grve-blade-vc-extension" ) => 'title',
				esc_html__( "Author", "grve-blade-vc-extension" ) => 'author',
				esc_html__( "Random", "grve-blade-vc-extension" ) => 'rand',
			),
			"description" => '',
			"admin_label" => true,
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_order' ) ) {
	function grve_blade_vce_add_order() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "Order", "grve-blade-vc-extension" ),
			"param_name" => "order",
			"value" => array(
				esc_html__( "Descending", "grve-blade-vc-extension" ) => 'DESC',
				esc_html__( "Ascending", "grve-blade-vc-extension" ) => 'ASC'
			),
			"dependency" => array( 'element' => "order_by", 'value' => array( 'date', 'modified', 'comment_count', 'name', 'author', 'title' ) ),
			"description" => '',
			"admin_label" => true,
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_slideshow_speed' ) ) {
	function grve_blade_vce_add_slideshow_speed() {
		return array(
			"type" => "textfield",
			"heading" => esc_html__( "Slideshow Speed", "grve-blade-vc-extension" ),
			"param_name" => "slideshow_speed",
			"value" => '3000',
			"description" => esc_html__( "Slideshow Speed in ms.", "grve-blade-vc-extension" ),
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_pagination_speed' ) ) {
	function grve_blade_vce_add_pagination_speed() {
		return array(
			"type" => "textfield",
			"heading" => esc_html__( "Pagination Speed", "grve-blade-vc-extension" ),
			"param_name" => "pagination_speed",
			"value" => '400',
			"description" => esc_html__( "Pagination Speed in ms.", "grve-blade-vc-extension" ),
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_navigation_type' ) ) {
	function grve_blade_vce_add_navigation_type() {
		return array(
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
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_navigation_color' ) ) {
	function grve_blade_vce_add_navigation_color() {
		return array(
			"type" => "dropdown",
			"heading" => esc_html__( "Navigation Color", "grve-blade-vc-extension" ),
			"param_name" => "navigation_color",
			'value' => array(
				esc_html__( 'Dark' , 'grve-blade-vc-extension' ) => 'dark',
				esc_html__( 'Light' , 'grve-blade-vc-extension' ) => 'light',
			),
			"description" => esc_html__( "Select the background Navigation color.", "grve-blade-vc-extension" ),
		);
	}
}

if( !function_exists( 'grve_blade_vce_add_auto_height' ) ) {
	function grve_blade_vce_add_auto_height() {
		return array(
			"type" => 'checkbox',
			"heading" => esc_html__( "Auto Height", "grve-blade-vc-extension" ),
			"param_name" => "auto_height",
			"value" => array( esc_html__( "Select if you want smooth auto height", "grve-blade-vc-extension" ) => 'yes' ),
		);
	}
}


//Title Headings/Tags
if( !function_exists( 'grve_blade_vce_get_heading_tag' ) ) {
	function grve_blade_vce_get_heading_tag( $std = '' ) {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Title Tag", "grve-blade-vc-extension" ),
			"param_name" => "heading_tag",
			"value" => array(
				esc_html__( "h1", "grve-blade-vc-extension" ) => 'h1',
				esc_html__( "h2", "grve-blade-vc-extension" ) => 'h2',
				esc_html__( "h3", "grve-blade-vc-extension" ) => 'h3',
				esc_html__( "h4", "grve-blade-vc-extension" ) => 'h4',
				esc_html__( "h5", "grve-blade-vc-extension" ) => 'h5',
				esc_html__( "h6", "grve-blade-vc-extension" ) => 'h6',
				esc_html__( "div", "grve-blade-vc-extension" ) => 'div',
			),
			"description" => esc_html__( "Title Tag for SEO", "grve-blade-vc-extension" ),
			"std" => $std,
		);
	}
}

if( !function_exists( 'grve_blade_vce_get_heading' ) ) {
	function grve_blade_vce_get_heading( $std = '' ) {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Title Size/Typography", "grve-blade-vc-extension" ),
			"param_name" => "heading",
			"admin_label" => true,
			"value" => array(
				esc_html__( "h1", "grve-blade-vc-extension" ) => 'h1',
				esc_html__( "h2", "grve-blade-vc-extension" ) => 'h2',
				esc_html__( "h3", "grve-blade-vc-extension" ) => 'h3',
				esc_html__( "h4", "grve-blade-vc-extension" ) => 'h4',
				esc_html__( "h5", "grve-blade-vc-extension" ) => 'h5',
				esc_html__( "h6", "grve-blade-vc-extension" ) => 'h6',
				esc_html__( "Leader Text", "grve-blade-vc-extension" ) => 'leader-text',
				esc_html__( "Subtitle Text", "grve-blade-vc-extension" ) => 'subtitle-text',
				esc_html__( "Small Text", "grve-blade-vc-extension" ) => 'small-text',
				esc_html__( "Link Text", "grve-blade-vc-extension" ) => 'link-text',
			),
			"description" => esc_html__( "Title size and typography, defined in Theme Options - Typography Options", "grve-blade-vc-extension" ),
			"std" => $std,
		);
	}
}

if( !function_exists( 'grve_blade_vce_get_heading_blog' ) ) {
	function grve_blade_vce_get_heading_blog( $std = '' ) {
		return	array(
			"type" => "dropdown",
			"heading" => esc_html__( "Title Size", "grve-blade-vc-extension" ),
			"param_name" => "heading",
			"admin_label" => true,
			"value" => array(
				esc_html__( "Auto", "grve-blade-vc-extension" ) => 'auto',
				esc_html__( "h1", "grve-blade-vc-extension" ) => 'h1',
				esc_html__( "h1", "grve-blade-vc-extension" ) => 'h1',
				esc_html__( "h2", "grve-blade-vc-extension" ) => 'h2',
				esc_html__( "h3", "grve-blade-vc-extension" ) => 'h3',
				esc_html__( "h4", "grve-blade-vc-extension" ) => 'h4',
				esc_html__( "h5", "grve-blade-vc-extension" ) => 'h5',
				esc_html__( "h6", "grve-blade-vc-extension" ) => 'h6',
				esc_html__( "Leader Text", "grve-blade-vc-extension" ) => 'leader-text',
				esc_html__( "Subtitle Text", "grve-blade-vc-extension" ) => 'subtitle-text',
				esc_html__( "Small Text", "grve-blade-vc-extension" ) => 'small-text',
				esc_html__( "Link Text", "grve-blade-vc-extension" ) => 'link-text',
			),
			"description" => esc_html__( "Title size and typography", "grve-blade-vc-extension" ),
			"std" => $std,
		);
	}
}

//Button Parameters

function grve_blade_vce_get_button_params( $group = 'button', $index = '' ) {


	if ( 'first' == $group ) {
		$group_string = esc_html__( "First Button", "grve-blade-vc-extension" );
	} elseif ( 'second' == $group ) {
		$group_string = esc_html__( "Second Button", "grve-blade-vc-extension" );
	} else {
		$group_string = esc_html__( "Button", "grve-blade-vc-extension" );
	}

	$btn_params = array(
		array(
			"type" => "textfield",
			"heading" => esc_html__( "Button Text", "grve-blade-vc-extension" ),
			"param_name" => "button" . $index . "_text",
			"save_always" => true,
			"admin_label" => true,
			"value" => "Button",
			"description" => esc_html__( "Text of the button.", "grve-blade-vc-extension" ),
			"group" => $group_string,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Type", "grve-blade-vc-extension" ),
			"param_name" => "button" . $index . "_type",
			"value" => array(
				esc_html__( "Simple", "grve-blade-vc-extension" ) => 'simple',
				esc_html__( "Outline", "grve-blade-vc-extension" ) => 'outline',
			),
			"description" => esc_html__( "Select button type.", "grve-blade-vc-extension" ),
			"group" => $group_string,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Color", "grve-blade-vc-extension" ),
			"param_name" => "button" . $index . "_color",
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
			"description" => esc_html__( "Color of the button.", "grve-blade-vc-extension" ),
			"group" => $group_string,
			"std" => 'primary-1',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Hover Color", "grve-blade-vc-extension" ),
			"param_name" => "button" . $index . "_hover_color",
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
			"description" => esc_html__( "Color of the button.", "grve-blade-vc-extension" ),
			"group" => $group_string,
			"std" => 'black',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Size", "grve-blade-vc-extension" ),
			"param_name" => "button" . $index . "_size",
			"value" => array(
				esc_html__( "Extra Small", "grve-blade-vc-extension" ) => 'extrasmall',
				esc_html__( "Small", "grve-blade-vc-extension" ) => 'small',
				esc_html__( "Medium", "grve-blade-vc-extension" ) => 'medium',
				esc_html__( "Large", "grve-blade-vc-extension" ) => 'large',
				esc_html__( "Extra Large", "grve-blade-vc-extension" ) => 'extralarge',
			),
			"description" => '',
			"std" => 'medium',
			"group" => $group_string,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( "Button Shape", "grve-blade-vc-extension" ),
			"param_name" => "button" . $index . "_shape",
			"value" => array(
				esc_html__( "Square", "grve-blade-vc-extension" ) => 'square',
				esc_html__( "Round", "grve-blade-vc-extension" ) => 'round',
				esc_html__( "Extra Round", "grve-blade-vc-extension" ) => 'extra-round',
			),
			"description" => '',
			"std" => 'square',
			"group" => $group_string,
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__( "Button Link", "grve-blade-vc-extension" ),
			"param_name" => "button" . $index . "_link",
			"value" => "",
			"description" => esc_html__( "Enter link.", "grve-blade-vc-extension" ),
			"group" => $group_string,
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__( "Add icon?", "grve-blade-vc-extension" ),
			"param_name" => "btn" . $index . "_add_icon",
			"value" => array( esc_html__( "Select if you want to show an icon next to button", "grve-blade-vc-extension" ) => 'yes' ),
			"group" => $group_string
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
			'param_name' => 'btn' . $index . '_icon_library',
			'description' => esc_html__( 'Select icon library.', 'grve-blade-vc-extension' ),
			"dependency" => array( 'element' => "btn" . $index . "_add_icon", 'value' => array( 'yes' ) ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
			'param_name' => 'btn' . $index . '_icon_fontawesome',
			'value' => 'fa fa-adjust',
			'settings' => array(
				'emptyIcon' => false,
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
			'param_name' => 'btn' . $index . '_icon_openiconic',
			'value' => 'vc-oi vc-oi-dial',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'openiconic',
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'openiconic',
			),
			'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
			'param_name' => 'btn' . $index . '_icon_typicons',
			'value' => 'typcn typcn-adjust-brightness',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'typicons',
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'typicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
			'param_name' => 'btn' . $index . '_icon_entypo',
			'value' => 'entypo-icon entypo-icon-note',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'entypo',
				'iconsPerPage' => 300,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'entypo',
			),
			'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
			'param_name' => 'btn' . $index . '_icon_linecons',
			'value' => 'vc_li vc_li-heart',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'linecons',
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'linecons',
			),
			'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
			"group" => $group_string,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'grve-blade-vc-extension' ),
			'param_name' => 'btn' . $index . '_icon_simplelineicons',
			'value' => 'smp-icon-user',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'simplelineicons',
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'btn' . $index . '_icon_library',
				'value' => 'simplelineicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'grve-blade-vc-extension' ),
			"group" => $group_string,
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__( "Button aria-label", "grve-blade-vc-extension" ),
			"param_name" => "btn" . $index . "_aria_label",
			"description" => esc_html__( "The aria-label attribute is used to provide the label to any assistive technologies.", "grve-blade-vc-extension" ),
			"group" => $group_string,
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__( "Button class name", "grve-blade-vc-extension" ),
			"param_name" => "button" . $index . "_class",
			"description" => esc_html__( "If you wish to style your button differently, then use this field to add a class name and then refer to it in your css file.", "grve-blade-vc-extension" ),
			"group" => $group_string,
		),
	);
	return $btn_params;
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
