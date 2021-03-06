<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>	
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">
<!-- BEGIN HEADER -->
	<div id="header">
    <div id="header-inner" class="clearfix">
		<div id="logo">
		<?php if ( esell_the_custom_logo()  ) {
      esell_the_custom_logo();
   }
   else { ?>
			<?php if (of_get_option( 'esell_logo' )): ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo of_get_option( 'esell_logo' ); ?>"  alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/></a>
      			<?php else : ?>        
          <?php if ( is_front_page() && is_home() ) : ?>
		<div class="site-branding">
			<h1 itemprop="headline" class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- .site-branding -->
	<?php else : ?>		
		<div class="site-branding">
			<p itemprop="headline" class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- .site-branding -->
   
	<?php endif; ?> 
    <?php endif; ?>
	<?php } ?>
		</div>
		<?php if(of_get_option('esell_headerbut')!=='on'){ 
		 if (class_exists('woocommerce')) {load_template(get_template_directory() . '/wooacc.php'); }else { ?><div id="search"><?php get_search_form(); ?></div>
		 <?php }} ?> 
				
	    </div> 	</div> 
	<!-- BEGIN TOP NAVIGATION -->		
	<div id="navigation" class="nav"> 
    <div id="navigation-inner" class="clearfix">
	<div class="secondary">		<?php wp_nav_menu(array('container' => '', 'theme_location' => 'esell-navigation', 'fallback_cb' => 'esell_hdmenu')); ?>
	</div>
	</div></div>
	<?php if (of_get_option('news_ticker') !=='off') {  echo wp_kses_post(esell_newticker());} ?>
