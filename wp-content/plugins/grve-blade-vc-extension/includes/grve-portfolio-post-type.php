<?php
/*
*	Portfolio Post Type Registration
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

if ( ! class_exists( 'GRVE_Blade_Extension_Portfolio_Post_Type' ) ) {
	class GRVE_Blade_Extension_Portfolio_Post_Type {

		function __construct() {

			// Adds the portfolio post type and taxonomies
			$this->grve_portfolio_init();


			// Manage Columns for portfolio overview
			add_filter( 'manage_edit-portfolio_columns',  array( &$this, 'grve_portfolio_edit_columns' ) );
			add_action( 'manage_posts_custom_column', array( &$this, 'grve_portfolio_custom_columns' ), 10, 2 );

		}

		function grve_portfolio_init() {

			$portfolio_base_slug = 'portfolio';
			if ( function_exists( 'blade_grve_option' ) ) {
				$portfolio_base_slug = blade_grve_option( 'portfolio_slug', 'portfolio' );
			}


			$labels = array(
				'name' => esc_html_x( 'Portfolio Items', 'Portfolio General Name', 'grve-blade-vc-extension' ),
				'singular_name' => esc_html_x( 'Portfolio Item', 'Portfolio Singular Name', 'grve-blade-vc-extension' ),
				'add_new' => esc_html__( 'Add New', 'grve-blade-vc-extension' ),
				'add_new_item' => esc_html__( 'Add New Portfolio Item', 'grve-blade-vc-extension' ),
				'edit_item' => esc_html__( 'Edit Portfolio Item', 'grve-blade-vc-extension' ),
				'new_item' => esc_html__( 'New Portfolio Item', 'grve-blade-vc-extension' ),
				'view_item' => esc_html__( 'View Portfolio Item', 'grve-blade-vc-extension' ),
				'search_items' => esc_html__( 'Search Portfolio Items', 'grve-blade-vc-extension' ),
				'not_found' =>  esc_html__( 'No Portfolio Items found', 'grve-blade-vc-extension' ),
				'not_found_in_trash' => esc_html__( 'No Portfolio Items found in Trash', 'grve-blade-vc-extension' ),
				'parent_item_colon' => '',
			);

			$category_labels = array(
				'name' => esc_html__( 'Portfolio Categories', 'grve-blade-vc-extension' ),
				'singular_name' => esc_html__( 'Portfolio Category', 'grve-blade-vc-extension' ),
				'search_items' => esc_html__( 'Search Portfolio Categories', 'grve-blade-vc-extension' ),
				'all_items' => esc_html__( 'All Portfolio Categories', 'grve-blade-vc-extension' ),
				'parent_item' => esc_html__( 'Parent Portfolio Category', 'grve-blade-vc-extension' ),
				'parent_item_colon' => esc_html__( 'Parent Portfolio Category:', 'grve-blade-vc-extension' ),
				'edit_item' => esc_html__( 'Edit Portfolio Category', 'grve-blade-vc-extension' ),
				'update_item' => esc_html__( 'Update Portfolio Category', 'grve-blade-vc-extension' ),
				'add_new_item' => esc_html__( 'Add New Portfolio Category', 'grve-blade-vc-extension' ),
				'new_item_name' => esc_html__( 'New Portfolio Category Name', 'grve-blade-vc-extension' ),
			);

			$field_labels = array(
				'name' => esc_html__( 'Portfolio Fields', 'grve-blade-vc-extension' ),
				'singular_name' => esc_html__( 'Portfolio Field', 'grve-blade-vc-extension' ),
				'search_items' => esc_html__( 'Search Portfolio Fields', 'grve-blade-vc-extension' ),
				'all_items' => esc_html__( 'All Portfolio Fields', 'grve-blade-vc-extension' ),
				'parent_item' => esc_html__( 'Parent Portfolio Field', 'grve-blade-vc-extension' ),
				'parent_item_colon' => esc_html__( 'Parent Portfolio Field:', 'grve-blade-vc-extension' ),
				'edit_item' => esc_html__( 'Edit Portfolio Field', 'grve-blade-vc-extension' ),
				'update_item' => esc_html__( 'Update Portfolio Field', 'grve-blade-vc-extension' ),
				'add_new_item' => esc_html__( 'Add New Portfolio Field', 'grve-blade-vc-extension' ),
				'new_item_name' => esc_html__( 'New Portfolio Field Name', 'grve-blade-vc-extension' ),
			);

			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 5,
				'menu_icon' => 'dashicons-format-gallery',
				'supports' => array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'custom-fields', 'comments' ),
				'rewrite' => array( 'slug' => $portfolio_base_slug, 'with_front' => false ),
			);

			register_post_type( 'portfolio' , $args );

			register_taxonomy(
				'portfolio_category',
				array( 'portfolio' ),
				array(
					'hierarchical' => true,
					'label' => esc_html__( 'Portfolio Categories', 'grve-blade-vc-extension' ),
					'labels' => $category_labels,
					'show_in_nav_menus' => false,
					'show_tagcloud' => false,
					'rewrite' => true,
				)
			);
			register_taxonomy_for_object_type( 'portfolio_category', 'portfolio' );

			register_taxonomy(
				'portfolio_field',
				array( 'portfolio' ),
				array(
					'hierarchical' => true,
					'label' => esc_html__( 'Portfolio Fields', 'grve-blade-vc-extension' ),
					'labels' => $field_labels,
					'show_in_nav_menus' => false,
					'show_tagcloud' => false,
					'rewrite' => true,
				)
			);
			register_taxonomy_for_object_type( 'portfolio_field', 'portfolio' );

		}

		function grve_portfolio_edit_columns( $columns ) {

			$columns['cb'] = "<input type=\"checkbox\" />";
			$columns['title'] = esc_html__( 'Title', 'grve-blade-vc-extension' );
			$columns['portfolio_thumbnail'] = esc_html__( 'Featured Image', 'grve-blade-vc-extension' );
			$columns['author'] = esc_html__( 'Author', 'grve-blade-vc-extension' );
			$columns['portfolio_category'] = esc_html__( 'Portfolio Categories', 'grve-blade-vc-extension' );
			$columns['portfolio_field'] = esc_html__( 'Portfolio Fields', 'grve-blade-vc-extension' );
			$columns['date'] = esc_html__( 'Date', 'grve-blade-vc-extension' );

			return $columns;
		}

		function grve_portfolio_custom_columns( $column, $post_id ) {

			switch ( $column ) {
				case "portfolio_thumbnail":
					if ( has_post_thumbnail( $post_id ) ) {
						$thumbnail_id = get_post_thumbnail_id( $post_id );
						$attachment_src = wp_get_attachment_image_src( $thumbnail_id, array( 80, 80 ) );
						$thumb = $attachment_src[0];
					} else {
						$thumb = get_template_directory_uri() . '/includes/images/no-image.jpg';
					}
					echo '<img class="attachment-80x80" width="80" height="80" alt="portfolio image" src="' . esc_url( $thumb ) . '">';
					break;
				case 'portfolio_category':
					echo get_the_term_list( $post_id, 'portfolio_category', '', ', ','' );
				break;
				case 'portfolio_field':
					echo get_the_term_list( $post_id, 'portfolio_field', '', ', ','' );
				break;
			}
		}

	}
	new GRVE_Blade_Extension_Portfolio_Post_Type;
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
