<?php
/**
 * Related Products
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop, $homemarket_theme_options;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = wc_get_related_products( $product->get_id(), $homemarket_theme_options['related_product_count'] );

if ( sizeof( $related ) === 0 || !$homemarket_theme_options['related_products_show'] ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $homemarket_theme_options['related_product_count'],
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->get_id() )
) );

$products                    = new WP_Query( $args );
$woocommerce_loop['name']    = 'related';
$woocommerce_loop['columns'] = isset($homemarket_theme_options['related_product_colum']) ? $homemarket_theme_options['related_product_colum'] : 4;


if ( $products->have_posts() ) : ?>

	<div class="related products">

		<h2><?php _e( 'Related Products', 'homemarket' ); ?></h2>

		<div class="carousel-products woocommerce slider-wrapper">

            <?php
            global $woocommerce_loop;

            $woocommerce_loop['display_style'] = 'carousel';
            $woocommerce_loop['navigation_style'] = 'style-1';

            woocommerce_product_loop_start();
            ?>

            <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                <?php wc_get_template_part( 'content', 'product' ); ?>

            <?php endwhile; // end of the loop. ?>

            <?php
            woocommerce_product_loop_end();
            ?>
        </div>

	</div>

<?php endif;

wp_reset_postdata();
