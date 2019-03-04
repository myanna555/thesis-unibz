<?php
/*
*	Testimonial Post Type Registration
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

if ( ! class_exists( 'GRVE_Blade_Extension_Testimonial_Post_Type' ) ) {
	class GRVE_Blade_Extension_Testimonial_Post_Type {

		function __construct() {

			// Adds the testimonial post type and taxonomies
			$this->grve_testimonial_init();

			// Manage Columns for testimonial overview
			add_filter( 'manage_edit-testimonial_columns',  array( &$this, 'grve_testimonial_edit_columns' ) );
			add_action( 'manage_posts_custom_column', array( &$this, 'grve_testimonial_custom_columns' ), 10, 2 );

		}

		function grve_testimonial_init() {


			$labels = array(
				'name' => esc_html_x( 'Testimonial Items', 'Testimonial General Name', 'grve-blade-vc-extension' ),
				'singular_name' => esc_html_x( 'Testimonial Item', 'Testimonial Singular Name', 'grve-blade-vc-extension' ),
				'add_new' => esc_html__( 'Add New', 'grve-blade-vc-extension' ),
				'add_new_item' => esc_html__( 'Add New Testimonial Item', 'grve-blade-vc-extension' ),
				'edit_item' => esc_html__( 'Edit Testimonial Item', 'grve-blade-vc-extension' ),
				'new_item' => esc_html__( 'New Testimonial Item', 'grve-blade-vc-extension' ),
				'view_item' => esc_html__( 'View Testimonial Item', 'grve-blade-vc-extension' ),
				'search_items' => esc_html__( 'Search Testimonial Items', 'grve-blade-vc-extension' ),
				'not_found' =>  esc_html__( 'No Testimonial Items found', 'grve-blade-vc-extension' ),
				'not_found_in_trash' => esc_html__( 'No Testimonial Items found in Trash', 'grve-blade-vc-extension' ),
				'parent_item_colon' => '',
			);

			$category_labels = array(
				'name' => esc_html__( 'Testimonial Categories', 'grve-blade-vc-extension' ),
				'singular_name' => esc_html__( 'Testimonial Category', 'grve-blade-vc-extension' ),
				'search_items' => esc_html__( 'Search Testimonial Categories', 'grve-blade-vc-extension' ),
				'all_items' => esc_html__( 'All Testimonial Categories', 'grve-blade-vc-extension' ),
				'parent_item' => esc_html__( 'Parent Testimonial Category', 'grve-blade-vc-extension' ),
				'parent_item_colon' => esc_html__( 'Parent Testimonial Category:', 'grve-blade-vc-extension' ),
				'edit_item' => esc_html__( 'Edit Testimonial Category', 'grve-blade-vc-extension' ),
				'update_item' => esc_html__( 'Update Testimonial Category', 'grve-blade-vc-extension' ),
				'add_new_item' => esc_html__( 'Add New Testimonial Category', 'grve-blade-vc-extension' ),
				'new_item_name' => esc_html__( 'New Testimonial Category Name', 'grve-blade-vc-extension' ),
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
				'menu_icon' => 'dashicons-testimonial',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail' ),
				'rewrite' => array( 'slug' => 'testimonial', 'with_front' => false ),
			  );

			register_post_type( 'testimonial' , $args );

			register_taxonomy(
				'testimonial_category',
				array( 'testimonial' ),
				array(
					'hierarchical' => true,
					'label' => esc_html__( 'Testimonial Categories', 'grve-blade-vc-extension' ),
					'labels' => $category_labels,
					'show_in_nav_menus' => false,
					'show_tagcloud' => false,
					'rewrite' => true,
				)
			);
			register_taxonomy_for_object_type( 'testimonial_category', 'testimonial' );

		}

		function grve_testimonial_edit_columns( $columns ) {

			$columns['cb'] = "<input type=\"checkbox\" />";
			$columns['title'] = esc_html__( 'Title', 'grve-blade-vc-extension' );
			$columns['testimonial_thumbnail'] = esc_html__( 'Featured Image', 'grve-blade-vc-extension' );
			$columns['author'] = esc_html__( 'Author', 'grve-blade-vc-extension' );
			$columns['testimonial_category'] = esc_html__( 'Testimonial Categories', 'grve-blade-vc-extension' );
			$columns['date'] = esc_html__( 'Date', 'grve-blade-vc-extension' );

			return $columns;
		}

		function grve_testimonial_custom_columns( $column, $post_id ) {

			switch ( $column ) {
				case "testimonial_thumbnail":
					if ( has_post_thumbnail( $post_id ) ) {
						$thumbnail_id = get_post_thumbnail_id( $post_id );
						$attachment_src = wp_get_attachment_image_src( $thumbnail_id, array( 80, 80 ) );
						$thumb = $attachment_src[0];
					} else {
						$thumb = get_template_directory_uri() . '/includes/images/no-image.jpg';
					}
					echo '<img class="attachment-80x80" width="80" height="80" alt="portfolio image" src="' . esc_url( $thumb ) . '">';
					break;
				case 'testimonial_category':
					echo get_the_term_list( $post_id, 'testimonial_category', '', ', ','' );
				break;
			}
		}

	}
	new GRVE_Blade_Extension_Testimonial_Post_Type;
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
