<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( function_exists( 'wc_get_cart_url' ) ) {
	$get_cart_url = wc_get_cart_url();
} else {
	$get_cart_url = WC()->cart->get_cart_url();
}
if ( function_exists( 'wc_get_checkout_url' ) ) {
	$get_checkout_url = wc_get_checkout_url();
} else {
	$get_checkout_url = WC()->cart->get_checkout_url();
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<ul class="cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					?>
					<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<?php
						if ( function_exists( 'wc_get_cart_remove_url' ) ) {
							$get_cart_remove_url = wc_get_cart_remove_url( $cart_item_key );
						} else {
							$get_cart_remove_url = WC()->cart->get_remove_url( $cart_item_key );
						}
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove remove_from_cart_button" title="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="grve-icon grve-icon-close-sm"></i></a>',
							esc_url( $get_cart_remove_url ),
							esc_attr__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
						<?php if ( ! $_product->is_visible() ) : ?>
							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name . '&nbsp;'; ?>
						<?php else : ?>
							<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name . '&nbsp;'; ?>
							</a>
						<?php endif; ?>
						<?php
							if ( function_exists( 'wc_get_formatted_cart_item_data' ) ) {
								echo wc_get_formatted_cart_item_data( $cart_item );
							} else {
								echo WC()->cart->get_item_data( $cart_item );
							}
						?>
						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
					</li>
					<?php
				}
			}
		?>

	<?php else : ?>

		<li class="empty"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></li>

	<?php endif; ?>

</ul><!-- end product list -->

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<div class="grve-subtotal grve-link-text"><strong><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></div>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="buttons">
		<a href="<?php echo esc_url( $get_cart_url ); ?>" class="grve-btn grve-btn-extrasmall grve-bg-primary-1 grve-bg-hover-black"><?php esc_html_e( 'View cart', 'woocommerce' ); ?></a>
		<a href="<?php echo esc_url( $get_checkout_url ); ?>" class="grve-btn grve-btn-extrasmall grve-bg-grey grve-bg-hover-black"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
	</p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
