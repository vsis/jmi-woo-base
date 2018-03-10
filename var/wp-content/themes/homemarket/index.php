<?php get_header(); 

$blog_page_layout = '';

if ( isset($homemarket_theme_options['blog_page_layout']) ) :

	if ( $homemarket_theme_options['blog_page_layout'] == '1' ):
		$blog_page_layout = 'full-page';
	elseif ( $homemarket_theme_options['blog_page_layout'] == '2' ):
		$blog_page_layout = 'left-page';
	elseif ( $homemarket_theme_options['blog_page_layout'] == '3' ):
		$blog_page_layout = 'right-page';
	endif;

endif;

$wrapper_class = "";
if ( isset( $homemarket_theme_options['header_main_layout'] ) && ( $homemarket_theme_options['header_main_layout'] == "3" ) ) {
	$wrapper_class = "wrapper";
} else {
	$wrapper_class = "";
}

?>

	<main class="index-page main-content <?php echo $wrapper_class; ?>">

		<div class="breadcrumb-container">

			<?php  
				if ( ( $homemarket_theme_options['show_breadcrumbs'] == "1" ) || ( $homemarket_theme_options['show_page_title'] == "1" ) ) :
			?>
				<?php if ( !isset($homemarket_theme_options['breadcrumbs_background']) ) { ?>
				<div id="breadcrumb-wrapper" class="breadcrumb-initial">
				<?php } else { ?>
				<div id="breadcrumb-wrapper">
				<?php } ?>
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
		
		<div class="wrapper <?php echo $blog_page_layout; ?>">
			<div class="blog-sidebar">
				<?php 
					if ( $homemarket_theme_options['post_page_layout'] == '1' ) { 
						?><h2><?php 
						_e( 'No Sidebar', 'homemarket' );
						?></h2><?php 
					} else {
						if ( is_active_sidebar( 'blog-sidebar' ) ) {
							dynamic_sidebar( 'blog-sidebar' ); 
						}
					}
				?>
			</div>

			<div id="content">
				<div class="blog-posts">
					<?php

					if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'blog' ); ?>

					<?php endwhile; ?>
						<div class="post-pagination-field">
							<?php homemarket_post_pagination(); ?>
						</div>
					<?php else : ?>

					        <h1><?php _e( 'No post found', 'homemarket' ) ?></h1>
						
					<?php endif; ?>
					
				</div>
			</div>

			<div class="mobile-sidebar">
				<div class="sidebar-toggle">
					<i class="fa sidebar-mobile-icon"></i>
				</div>
			</div>
		</div>
	</main>

<?php get_footer(); ?>