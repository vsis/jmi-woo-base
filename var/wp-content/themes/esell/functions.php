<?php

	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework.php';
	include_once('baztro.php');
	include_once('includes/installs.php');
	include_once('includes/core/core.php');
	require get_template_directory() . '/includes/metaboxpage.php';
	require get_template_directory() . '/includes/metaboxsingle.php';	
	require get_template_directory() . '/includes/metaboxproduct.php';
	/**
	 * Implement the Custom Header feature.
	 */
	require get_template_directory() . '/includes/custom-header.php';
	require get_template_directory() . '/includes/customizer.php';

	
	
function esell_scripts() {
	wp_enqueue_style( 'esell-style', get_stylesheet_uri() );
	wp_enqueue_style( 'esell-font-awesome', get_stylesheet_directory_uri() . '/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'esell-ticker-style', get_stylesheet_directory_uri() . '/css/ticker-style.css' );
		wp_enqueue_script('esell-smoothscroll', get_template_directory_uri().'/js/smoothscroll.js', array(), '1.0', false );
		wp_enqueue_script('esell-ticker-js', get_template_directory_uri().'/js/tickerme.min.js', array(), '1.0', false );
		
	// Enqueues the javascript for comment replys 
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
	
	//Custom css output	
		$custom_css = html_entity_decode(of_get_option('esell_customcss'));
		wp_add_inline_style( 'esell-style', $custom_css );	 
	}
	add_action( 'wp_enqueue_scripts', 'esell_scripts' );
/**
 * Enqueue script for custom customize control.
 */
function esell_custom_customize_enqueue() {
	wp_enqueue_style( 'customizer-css', get_stylesheet_directory_uri() . '/css/customizer-css.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'esell_custom_customize_enqueue' );

	// Home Icon for Menu

	function esell_hdmenu() {
		echo '<ul>';
		if ('page' != get_option('show_on_front')) {
		if (is_front_page())
		$class = 'class="current_page_item home-icon"';
		else
			$class = 'class="home-icon"';
				echo '<li ' . $class . ' ><a href="'.esc_url( home_url() ). '/"><i class="fa fa-home"></i></a></li>';
			}
				wp_list_pages('title_li=');
			echo '</ul>';
		}

	add_filter( 'wp_nav_menu_items', 'esell_home_link', 10, 2 );

	function esell_home_link($items, $args) {
		if (is_front_page())
		$class = 'class="current_page_item home-icon"';
		else
		$class = 'class="home-icon"';
		$homeMenuItem =
		'<li ' . $class . '>' .
		$args->before .
		'<a href="' . esc_url( home_url( '/')). '" title="Home">' .
		$args->link_before . '<i class="fa fa-home"></i>' . $args->link_after .
		'</a>' .
		$args->after .
		'</li>';
		$items = $homeMenuItem . $items;
		return $items;
	}


/* Enable support for post-thumbnails ********************************************/
		
	// If we want to ensure that we only call this function if
	// the user is working with WP 2.9 or higher,
	// let's instead make sure that the function exists first
	
function esell_theme_setup() { 
		if ( function_exists( 'add_theme_support' ) ) { 
		add_theme_support( 'post-thumbnails' );
		}
		
	if(of_get_option('esell_woozoom')=='on'){ add_theme_support( 'wc-product-gallery-zoom' );}
	if(of_get_option('esell_woolightbox')!=='off'){ add_theme_support( 'wc-product-gallery-lightbox' );}
	if(of_get_option('esell_wooslider')=='on'){ add_theme_support( 'wc-product-gallery-slider' );}
		
		add_image_size( 'defaultthumb', 200, 200 );
		add_image_size( 'ltpostthumb', 60, 60, true );
		add_theme_support( 'title-tag' );
	    load_theme_textdomain('esell', get_template_directory() . '/languages');
        add_editor_style('esell');
		add_theme_support( 'custom-logo', array(
   'height'      => 90,
   'width'       => 400,
   'header-text' => array( 'site-title', 'site-description' ),
   'flex-width' => true,
   'flex-height' => true,
) );
		register_nav_menus(
			array(
 				'esell-navigation' => __('Navigation', 'esell' ),
 				'Footer-menu' => __('Footer Menu', 'esell'),
			)		
		);
        add_theme_support('automatic-feed-links');
		add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
		}
		// Sets up the content width value based on the theme's design
		global $content_width;
		if ( ! isset( $content_width ) ) {
		$content_width = 670;}
		//woocommerce plugin support
		add_theme_support( 'woocommerce' );
		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'esell_custom_background_args', array(
		'default-color' => 'F3F3F3',
		'default-image' => '',
		) ) );
	add_action( 'after_setup_theme', 'esell_theme_setup' );
	
function esell_post_meta_data() {
	printf( __( '%2$s  %4$s', 'esell' ),
	'meta-prep meta-prep-author posted', 
	sprintf( '<span itemprop="datePublished" class="timestamp updated">%3$s</span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_html( get_the_date() )
	),
	'byline',
	sprintf( '<span class="author vcard" itemprop="author" itemtype="http://schema.org/Person"><span class="fn">%3$s</span></span>',
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'esell' ), get_the_author() ),
		esc_attr( get_the_author() )
		)
	);
}

/* Excerpt ********************************************/

    function esell_excerptlength_teaser($length) {
    return 12;
    }
    function esell_excerptlength_index($length) {
    return 45;
    }
    function esell_excerptmore($more) {
    return '...';
    }
    
    
    function esell_excerpt($length_callback='', $more_callback='') {
    global $post;
    add_filter('excerpt_length', $length_callback);
 
    add_filter('excerpt_more', $more_callback);
   
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
    }

function esell_readinfo() {

 echo '<a class="promaxmore" href="';
 echo ''.the_permalink().'';
 echo '">'.of_get_option('esell_moreinfo','Details' ).'</a>';
}
add_action('woocommerce_after_shop_loop_item', 'esell_readinfo');


 function esell_search_form( $form ) {
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
	<div><label class="screen-reader-text" for="s">' . esc_attr__( 'Search for:','esell' ) . '</label>
	<input type="text" placeholder="'.__('Search','esell').'" value="' . get_search_query() . '" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__( 'Go','esell' ) .'" />
	</div>
	</form>';

	return $form;
}

add_filter( 'get_search_form', 'esell_search_form' );

/* Widgets ********************************************/

    function esell_widgets_init() {

	register_sidebar(array(
		'name' => __( 'Front Page Widget', 'esell' ),
	    'id' => 'esellfront',
	    'description' => 'After Featured Area and Before Products',
	    'before_widget' => '<div class="box clearfloat"><div class="boxinside clearfloat">',
	    'after_widget' => '</div></div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => __( 'Sidebar', 'esell' ),
	    'id' => 'esellsidebar',
	    'before_widget' => '<div class="box clearfloat"><div class="boxinside clearfloat">',
	    'after_widget' => '</div></div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'name' => __( 'Bottom Menu 1', 'esell' ),
	    'id' => 'esellbottom1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h4>',
	    'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __( 'Bottom Menu 2', 'esell' ),
	    'id' => 'esellbottom2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h4>',
	    'after_title' => '</h4>',
	));	

	register_sidebar(array(
		'name' => __( 'Bottom Menu 3', 'esell' ),
	    'id' => 'esellbottom3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h4>',
	    'after_title' => '</h4>',
	));	


}
add_action('widgets_init', 'esell_widgets_init');
//---------------------------- [ Pagenavi Function ] ------------------------------//
 function esell_pagenavi() {
	global $wp_query;
	$big = 123456789;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="wp-pagenavi">';
	            echo '<span class="pages">'. $paged . ' of ' . $wp_query->max_num_pages .'</span>';
	            foreach ( $page_format as $page ) {
	                    echo "$page";
	            }
	           echo '</div>';
	 }
}



/* ----------------------------------------------------------------------------------- */
/* Customize Comment Form
/*----------------------------------------------------------------------------------- */
add_filter( 'comment_form_default_fields', 'esell_comment_form_fields' );
function esell_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
    
    $fields   =  array(
        'author' => '<div class="large-6 columns"><div class="row collapse prefix-radius"><div class="small-3 columns">' . '<span class="prefix"><i class="fa fa-user"></i>' . __( 'Name','esell' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</span> </div>' .
                    '<div class="small-9 columns"><input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="20"' . $aria_req . ' /></div></div></div>',
        'email'  => '<div class="large-6 columns"><div class="row collapse prefix-radius"><div class="small-3 columns">' . '<span class="prefix"><i class="fa fa-envelope-o"></i>' . __( 'Email','esell' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</span></div> ' .
                    '<div class="small-9 columns"><input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="20"' . $aria_req . ' /></div></div></div>',
        'url'    => '<div class="large-6 columns"><div class="row collapse prefix-radius"><div class="small-3 columns">' . '<span class="prefix"><i class="fa fa-external-link"></i>' . __( 'Website','esell' ) . '</span> </div>' .
                    '<div class="small-9 columns"><input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div></div>'        
    );
    
    return $fields;
    
    
}

add_filter( 'comment_form_defaults', 'esell_comment_form' );
function esell_comment_form( $argsbutton ) {
        $argsbutton['class_submit'] = 'button'; 
    
    return $argsbutton;
}


 function esell_woocommerce_thumbnail() {
		global $product, $woocommerce;

		$items_in_cart = array();

		if ( $woocommerce->cart->get_cart() && is_array( $woocommerce->cart->get_cart() ) ) {
			foreach ( $woocommerce->cart->get_cart() as $cart ) {
				$items_in_cart[] = $cart['product_id'];
			}
		}

		$id      = get_the_ID();
		$in_cart = in_array( $id, $items_in_cart );
		$size    = 'shop_catalog';

		$gallery          = get_post_meta( $id, '_product_image_gallery', true );
		$attachment_image = '';
		if ( ! empty( $gallery ) ) {
			$gallery          = explode( ',', $gallery );
			$first_image_id   = $gallery[0];
			$attachment_image = wp_get_attachment_image( $first_image_id, $size, false, array( 'class' => 'hover-image' ) );
		}
		$thumb_image = get_the_post_thumbnail( $id, $size );

		if ( $attachment_image ) {
			$classes = 'crossfade-images';
		} else {
			$classes = '';
		}

		echo '<span class="' . $classes . '">';
		echo $attachment_image;
		echo $thumb_image;
		
		echo '</span>';
	}
	
	add_action( 'woocommerce_before_shop_loop_item_title', 'esell_woocommerce_thumbnail', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', create_function('', 'echo "<div class=\"product-images\">";'), 5, 2);
	add_action( 'woocommerce_before_shop_loop_item_title',create_function('', 'echo "</div>";'), 12, 2);
	
	
/*********************************/
/* WooCommerce Quick Checkout
*******************************************/
function esell_addtocart_button_func() {
        // echo content.
		global $product;
		$pid = $product->get_id();
		$quicklink = WC()->cart->get_checkout_url();
        echo '<div class="button quickcheckout"><a href="'.$quicklink.'?add-to-cart='.$pid.'">'.esc_attr(of_get_option('esell_quickcheckoutname','Quick Checkout')).'</a></div>';
}
add_action( 'woocommerce_after_add_to_cart_button', 'esell_addtocart_button_func' );

/****************************************
News Ticker
*****************************************/
function esell_newticker(){
	$tickercat = of_get_option('tickercategory');
	
?><div class="tickertitle"><div class="bn-title"><p><?php echo esc_attr(of_get_option('esell_menumain','News & Updates ')); ?></p><span></span></div>
<ul id="ticker">
	<?php
	$esell_args = array( 
	 'ignore_sticky_posts' => true,
	 'showposts' => 5,
	 'cat' => $tickercat, 
	'orderby' => 'date',  );
	$the_query = new WP_Query( $esell_args );
	 if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) : $the_query->the_post();
 ?>				
	<li class="news-item">
	<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><br />
	</li>			
	<?php 
	endwhile;
	endif; 
	wp_reset_postdata();
	?>
	</ul></div>
	<?php
}						
/****************************************
Custom Logo
*****************************************/

if ( ! function_exists( 'esell_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 */
function esell_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
	}
endif;