<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$product_get_id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;

?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<div class="grve-single-post-meta grve-categories">
	 <?php
			echo '<ul class="grve-small-text">';
			if ( function_exists( 'wc_get_product_category_list' ) ) {
				echo wc_get_product_category_list( $product_get_id, '</li><li>', '<li>', '</li>' );
			} else {
				echo wp_kses_post( $product->get_categories( '</li><li>', '<li>', '</li>' ) );
			}
			echo '</ul>';

	?>
	</div>
	<div class="grve-single-post-meta grve-tags">
	 <?php
			echo '<ul class="grve-small-text">';
			if ( function_exists( 'wc_get_product_tag_list' ) ) {
				echo wc_get_product_tag_list ( $product_get_id,'</li><li>','<li>', '</li>' );
			} else {
				echo wp_kses_post( $product->get_tags( '</li><li>', '<li>', '</li>' ) );
			}
			echo '</ul>';
	?>
	</div>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
