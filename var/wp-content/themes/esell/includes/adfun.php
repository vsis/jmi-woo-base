<div id="bottom-menu">
<div id="bottom-menu-inner" class="clearfix">
<div id="bottom-menu-1">
<?php if (!dynamic_sidebar('esellbottom1') ) : ?>
	<?php endif; ?>
</div>
<div id="bottom-menu-2">
	<?php if (!dynamic_sidebar('esellbottom2') ) : ?>
	<?php endif; ?>
</div>
<div id="bottom-menu-4">
	<?php if ( !dynamic_sidebar('esellbottom3') ) : ?>
	<?php endif; ?>
</div> 
</div> 
</div>
<div id="footer">
	<div id="footer-inner" class="clearfix">
<a href="<?php echo esc_url( home_url('/'));?>" title="<?php bloginfo('name');?>" ><?php bloginfo('name');?></a> <?php _e('Copyright &#169;', 'esell'); ?> <?php echo date('Y');?> <a href="<?php echo esc_url( __( 'http://www.insertcart.com/product/esell-business-wp-theme/', 'esell' ) ); ?>" title="<?php esc_attr_e( 'wrock.org', 'esell' ); ?>"><?php printf( __( '| Theme: eSell %s', 'esell' ),''); ?></a>
	<?php wp_nav_menu( array( 'theme_location' => 'footer-menu','container_class' => '','menu_id' => 'footerhorizontal',    'echo' => true,'after' =>'|','depth' =>'1','fallback_cb' => false ) ); ?>	

	</div> <!-- end div #footer-inner -->
	</div> <!-- end div #footer -->
	<!-- END FOOTER -->
</div> 