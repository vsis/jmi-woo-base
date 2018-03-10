<?php
/**
 * Add meta box
 *
 */
function esellsingle_add_meta_boxes( $post ){
	add_meta_box( 'food_meta_box', __( '<span class="dashicons dashicons-layout"></span> Post Layout Select [Pro Only]', 'esell' ), 'esellsingle_build_meta_box', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'esellsingle_add_meta_boxes' );
/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function esellsingle_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'esellsinglemeta_meta_box_nonce' );
	// retrieve the _food_esellsinglemeta current value
	$current_esellsinglemeta = get_post_meta( $post->ID, '_food_esellsinglemeta', true );
	
$upgradetopro = 'Layout Select for current post only - for website layout please choose from theme options <a href="' . esc_url('http://www.insertcart.com/product/esell-business-wp-theme/','esell') . '" target="_blank">' . esc_attr__( 'Get eSell Pro', 'esell' ) . '</a>';

	?>
	<div class='inside'>

		<h4><?php echo $upgradetopro; ?></h4>
		<p>
			<input type="radio" name="esellsinglemeta" value="rsd" <?php checked( $current_esellsinglemeta, 'rsd' ); ?> /> <?php _e('Right Sidebar - Default','esell'); ?><br />
			<input type="radio" name="esellsinglemeta" value="ls" <?php checked( $current_esellsinglemeta, 'ls' ); ?> /> <?php _e('Left Sidebar','esell'); ?><br/>
			<input type="radio" name="esellsinglemeta" value="lr" <?php checked( $current_esellsinglemeta, 'lr' ); ?> /> <?php _e('Left - Right Sidebars','esell'); ?> <br/>
			<input type="radio" name="esellsinglemeta" value="fc" <?php checked( $current_esellsinglemeta, 'fc' ); ?> /> <?php _e('Full Content - No Sidebar','esell'); ?>
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
function food_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['esellsinglemeta_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['esellsinglemeta_meta_box_nonce'], basename( __FILE__ ) ) ){
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
	// esellsinglemeta string
	if ( isset( $_REQUEST['esellsinglemeta'] ) ) {
		update_post_meta( $post_id, '_food_esellsinglemeta', sanitize_text_field( $_POST['esellsinglemeta'] ) );
	}

}
add_action( 'save_post', 'food_save_meta_box_data' );