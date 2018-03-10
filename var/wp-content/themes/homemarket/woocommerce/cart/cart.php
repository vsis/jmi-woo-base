<?php
/**
 * Cart Page
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $homemarket_theme_options;

$cart_breadcrumb = "";

if ( $homemarket_theme_options['show_breadcrumbs'] != "1" ) {
	$cart_breadcrumb = "hide-breadcrumb";
}

?>
<div class="shopping-cart-page <?php echo $cart_breadcrumb; ?>">
	<div class="breadcrumb-container">

		<?php  
			if ( ( $homemarket_theme_options['show_breadcrumbs'] == "1" ) || ( $homemarket_theme_options['show_page_title'] == "1" ) ) :
		?>
			<div id="breadcrumb-wrapper">
				<?php 
					if ( (isset($homemarket_theme_options['show_breadcrumbs'])) && ($homemarket_theme_options['show_breadcrumbs'] == "1" ) ) {
						do_action( 'woocommerce_breadcrumb_init' ); 
					}
				?>
				<?php 
					if ( (isset($homemarket_theme_options['show_page_title'])) && ($homemarket_theme_options['show_page_title'] == "1" ) ):
						if ( apply_filters( 'woocommerce_show_page_title', true ) ) : 
				?>
					<h1 class="page-title"><?php wp_title('', true, ''); ?></h1>
				<?php 
						endif;
					endif; 
				?>
			</div>
		<?php endif; ?>

	</div>

	<?php
	wc_print_notices();

	do_action( 'woocommerce_before_cart' ); ?>
	<div class="cart-box-form">
		<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

		<?php do_action( 'woocommerce_before_cart_table' ); ?>

		<table class="shop_table shop_table_responsive cart" cellspacing="0">
			<thead>
				<tr>
					<th class="product-name"><?php _e( 'Product', 'homemarket' ); ?></th>
					<th class="product-price"><?php _e( 'Price', 'homemarket' ); ?></th>
					<th class="product-quantity"><?php _e( 'Quantity', 'homemarket' ); ?></th>
					<th class="product-subtotal"><?php _e( 'Total', 'homemarket' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>

				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

							<td class="product-name" data-title="<?php _e( 'Product', 'homemarket' ); ?>">
								<div class="img_item">
									<?php
										$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

										if ( ! $product_permalink ) {
											echo $thumbnail;
										} else {
											printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
										}
									?>
								</div>
								<div class="info_item">
									<?php
										if ( ! $product_permalink ) {
											echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
										} else {
											echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="product-title">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
										}

										// Meta data
										echo wc_get_formatted_cart_item_data( $cart_item );

										// Backorder notification
										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'homemarket' ) . '</p>';
										}
									?>
									<?php
										echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
											'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											__( 'Remove this item', 'homemarket' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() ),
											__( 'Remove', 'homemarket' )
										), $cart_item_key );
									?>
								</div>
							</td>

							<td class="product-price" data-title="<?php _e( 'Price', 'homemarket' ); ?>">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
							</td>

							<td class="product-quantity" data-title="<?php _e( 'Quantity', 'homemarket' ); ?>">
								<?php
									if ( $_product->is_sold_individually() ) {
										$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
									} else {
										$product_quantity = woocommerce_quantity_input( array(
											'input_name'  => "cart[{$cart_item_key}][qty]",
											'input_value' => $cart_item['quantity'],
											'max_value'   => $_product->get_max_purchase_quantity(),
											'min_value'   => '0'
										), $_product, false );
									}

									echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
								?>
							</td>

							<td class="product-subtotal" data-title="<?php _e( 'Total', 'homemarket' ); ?>">
								<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
								?>
							</td>
						</tr>
						<?php
					}
				}

				do_action( 'woocommerce_cart_contents' );
				?>
				<tr>
					<td colspan="6" class="actions">

						<?php if ( wc_coupons_enabled() ) { ?>
							<div class="coupon">

								<label for="coupon_code"><?php _e( 'Coupon:', 'homemarket' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'homemarket' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'homemarket' ); ?>" />

								<?php do_action( 'woocommerce_cart_coupon' ); ?>
							</div>
						<?php } ?>

						<input class="update_cart_submit" type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'homemarket' ); ?>" />

						<?php do_action( 'woocommerce_cart_actions' ); ?>

						<?php wp_nonce_field( 'woocommerce-cart' ); ?>
					</td>
				</tr>

				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_after_cart_table' ); ?>

		</form>
	</div>
	<div class="cart-collaterals">

		<?php do_action( 'woocommerce_cart_collaterals' ); ?>

	</div>

	<?php do_action( 'woocommerce_after_cart' ); ?>
</div>