<?php
/**
 * Add meta box
 *
 */
function esellpage_add_meta_boxes( $post ){
	add_meta_box( 'food_meta_box', __( '<span class="dashicons dashicons-layout"></span> Page Layout Select [Pro Only]', 'esell' ), 'esellpage_build_meta_box', 'page', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'esellpage_add_meta_boxes' );
/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function esellpage_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'esellpagemeta_meta_box_nonce' );
	// retrieve the _food_esellpagemeta current value
	$current_esellpagemeta = get_post_meta( $post->ID, '_food_esellpagemeta', true );
	
$upgradetopro = 'Layout Select for current Page only - for website layout please choose from theme options <a href="' . esc_url('http://www.insertcart.com/product/esell-business-wp-theme/','esell') . '" target="_blank">' . esc_attr__( 'Get eSell Pro', 'esell' ) . '</a>';

	?>
	<div class='inside'>

		<h4><?php echo $upgradetopro; ?></h4>
		<p>
			<input type="radio" name="esellpagemeta" value="rsd" <?php checked( $current_esellpagemeta, 'rsd' ); ?> /> <?php _e('Right Sidebar - Default','esell'); ?><br />
			<input type="radio" name="esellpagemeta" value="ls" <?php checked( $current_esellpagemeta, 'ls' ); ?> /> <?php _e('Left Sidebar','esell'); ?><br/>
			<input type="radio" name="esellpagemeta" value="lr" <?php checked( $current_esellpagemeta, 'lr' ); ?> /> <?php _e('Left - Right Sidebars','esell'); ?> <br/>
			<input type="radio" name="esellpagemeta" value="fc" <?php checked( $current_esellpagemeta, 'fc' ); ?> /> <?php _e('Full Content - No Sidebar','esell'); ?>
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
function esellpage_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['esellpagemeta_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['esellpagemeta_meta_box_nonce'], basename( __FILE__ ) ) ){
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
	// esellpagemeta string
	if ( isset( $_REQUEST['esellpagemeta'] ) ) {
		update_post_meta( $post_id, '_food_esellpagemeta', sanitize_text_field( $_POST['esellpagemeta'] ) );
	}

}
add_action( 'save_post', 'esellpage_save_meta_box_data' );