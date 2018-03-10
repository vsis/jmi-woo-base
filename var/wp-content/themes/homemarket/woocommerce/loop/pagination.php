<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query, $homemarket_theme_options;

if ($homemarket_theme_options['products_item']) {
    $per_page = explode(',', $homemarket_theme_options['products_item']);
} else {
    $per_page = explode(',', '12,24,36');
}
$page_count = homemarket_loop_shop_per_page();
$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

?>
<nav class="woocommerce-pagination">
    <form class="woocommerce-viewing" method="get">
        <label><?php echo __('View', 'homemarket') ?>: </label>
        <select name="count" class="count">
            <?php foreach ( $per_page as $count ) : ?>
                <option value="<?php echo esc_attr( $count ); ?>" <?php selected( $page_count, $count ); ?>><?php echo esc_html( $count ); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="paged" value=""/>
        <?php
        // Keep query string vars intact
        foreach ( $_GET as $key => $val ) {
            if ( 'count' === $key || 'submit' === $key || 'paged' === $key ) {
                continue;
            }
            if ( is_array( $val ) ) {
                foreach( $val as $innerVal ) {
                    echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
                }
            } else {
                echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
            }
        }
        ?>
    </form>
	<?php
        if ( $total <= 1 ) {
            echo '</nav>';
            return;
        }
        $size_count = 3;
       
        echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'         => $base,
			'format'       => $format,
			'add_args'     => false,
			'current'      => max( 1, $current ),
			'total'        => $total,
			'prev_text'    => '',
			'next_text'    => '',
			'type'         => 'list',
			'end_size'     => $size_count,
			'mid_size'     => floor($size_count / 2)
		) ) );
	?>
</nav>
