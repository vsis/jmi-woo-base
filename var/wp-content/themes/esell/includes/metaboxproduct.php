<?php
/**
 * Add meta box
 *
 */
function esellproduct_add_meta_boxes( $post ){
	add_meta_box( 'food_meta_box', __( '<span class="dashicons dashicons-layout"></span> Woocommerce Layout Select [Pro Only]', 'esell' ), 'esellproduct_build_meta_box', 'product', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'esellproduct_add_meta_boxes' );
/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function esellproduct_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'esellproductmeta_meta_box_nonce' );
	// retrieve the _food_esellproductmeta current value
	$current_esellproductmeta = get_post_meta( $post->ID, '_food_esellproductmeta', true );
	$upgradetopro = 'Layout Select for current product only - for website layout please choose from theme options <a href="' . esc_url('http://www.insertcart.com/product/esell-business-wp-theme/','esell') . '" target="_blank">' . esc_attr__( 'Get eSell Pro', 'esell' ) . '</a>';

	?>
	<div class='inside'>

		<h4><?php echo $upgradetopro; ?></h4>
		<p>
			<input type="radio" name="esellproductmeta" value="fc" <?php checked( $current_esellproductmeta, 'fc' ); ?> /> <?php _e('Full Content - No Sidebar (Default)','esell'); ?>
			<input type="radio" name="esellproductmeta" value="rsd" <?php checked( $current_esellproductmeta, 'rsd' ); ?> /> <?php _e('Right Sidebar','esell'); ?><br />
			<input type="radio" name="esellproductmeta" value="ls" <?php checked( $current_esellproductmeta, 'ls' ); ?> /> <?php _e('Left Sidebar','esell'); ?><br/>
		</p>

		

	</div>
	<?php
}
/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */
function esellproduct_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['esellproductmeta_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['esellproductmeta_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	// store custom fields values
	// esellproductmeta string
	if ( isset( $_REQUEST['esellproductmeta'] ) ) {
		update_post_meta( $post_id, '_food_esellproductmeta', sanitize_text_field( $_POST['esellproductmeta'] ) );
	}

}
add_action( 'save_post', 'esellproduct_save_meta_box_data' );