jQuery(document).ready(function($) {
	"use strict";

	$('.products.product-display-custom.home-products-carousel-enable').each( function(index) {
		var home_carousel_col = $(this).attr('data-column');

		if ( home_carousel_col == 1 ) {
			$(this).owlCarousel({
				autoplay : true,
				autoHeight : true,
				nav: true,
				navText: ["", ""],
				dots: false,
				rewind: true,
				lazyLoad : true,
				items : home_carousel_col,
		    });
		} else {
			$(this).owlCarousel({
				autoplay : true,
				autoHeight : true,
				nav: true,
				navText: ["", ""],
				dots: false,
				rewind: true,
				lazyLoad : true,
				responsiveClass: true,
				responsive: {
					0: {
						items: 1,
					},
					361: {
						items: 2,
					},
					541: {
						items: 3,
					},
					768: {
						items : home_carousel_col,
					}
				}
		    });
		}
		
	} );


	var brand_carousel_col = $('.carousel-brand').attr('data-brand-column');
	var category_carousel_col = $('.carousel-category').attr('data-brand-column');
	var recent_post_col = $('.recent-post-content.carousel-post').attr('data-post-column');

	/*===============================================
				Carousel Slider Setting
	================================================*/

	$('#carousel').flexslider({
		animation: "slide",
		controlNav: false,
		slideshow: false,
		itemWidth: 292,
		itemMargin: 0,
		asNavFor: '#slider'
	});

	$('#slider').flexslider({
		animation: "slide",
		controlNav: false,
		slideshowSpeed:5000,
		slideshow: true,
		sync: "#carousel",
		pauseOnAction: true,
		after: function(slider) {
		  if (!slider.playing) {
		    slider.play();
		  }
		}
	});

    $(".carousel-brand").owlCarousel({
		autoplay : true,
		autoHeight : true,
		nav: true,
		navText: ["", ""],
		dots: false,
		rewind: true,
		responsiveClass: true,
		responsive: {
			0: {
				items: 1,
			},
			361: {
				items: 2,
			},
			541: {
				items: 3,
			},
			768: {
				items : brand_carousel_col,
			}
		}
    });

    $(".carousel-category").owlCarousel({
		autoplay : true,
		autoHeight : true,
		nav: true,
		navText: ["", ""],
		dots: false,
		rewind: true,
		responsiveClass: true,
		responsive: {
			0: {
				items: 1,
			},
			361: {
				items: 2,
			},
			541: {
				items: 3,
			},
			768: {
				items : category_carousel_col,
			}
		}
    });

    $(".recent-post-content.carousel-post").owlCarousel({
		autoplay : true,
		autoHeight : true,
		nav: true,
		navText: ["", ""],
		dots: false,
		rewind: true,
		responsiveClass: true,
		responsive: {
			0: {
				items: 1,
			},
			540: {
				items: 2,
			},
			769: {
				items: 3,
			},
			1000: {
				items : recent_post_col,
			}
		}
    });

    $(".post-carousel.homemarket-carousel").owlCarousel({
		autoplay : true,
		items : 1,
		autoHeight : true,
		nav: false,
		navText: ["", ""],
		dots: true,
		rewind: true,
    });

    /*===============================================
				Added to Cart refresh
	================================================*/

	$( document ).on('added_to_cart', 'body', function(event, fragments, cart_hash, btn) {
		var parentTag =  btn.parents('li.product');
		btn.next().appendTo(parentTag);
	});

	var notificationContent = '';

	$('body').on('click', '.ajax_add_to_cart', function(){
		$('.woocommerce-message').remove();
	});

	$( '.woocommerce-viewing' ).off( 'change', 'select.count' ).on( 'change', 'select.count', function(e) {
        e.preventDefault();
        $( this ).closest( 'form' ).submit();
    });

    /*===============================================
					Mobile Nav Menu
	================================================*/

    $('#nav-mobile-icon').on('click', function(){
		$(this).toggleClass('open');
		$('html').toggleClass('js-drawer-open js-drawer-open-left');
		$('body').toggleClass('js-drawer-open js-drawer-open-left');
	});

	$('#NavDrawer .mobile-nav-header .mobile-nav-close').on('click', function() {
		$('#nav-mobile-icon').removeClass('open');
		$('html').removeClass('js-drawer-open js-drawer-open-left');
		$('body').removeClass('js-drawer-open js-drawer-open-left');
	});

	$('#NavDrawer ul.site-nav > li.menu-item.menu-item-has-children').on('click', function() {
		$(this).toggleClass('submenu-open');

		if ( $(this).hasClass('submenu-open') ) {
			$(this).find('ul.sub-menu').slideDown(500);
		} else {
			$(this).find('ul.sub-menu').slideUp(500);
		}
	});

	$('.mobile-sidebar').on('click', function() {
		$(this).toggleClass('open');
		$('#collection.left-page .sidebar-content').toggleClass('open');
		$('.index-page .blog-sidebar').toggleClass('open');
		$('.archive-page .blog-sidebar').toggleClass('open');
		$('.single-page .post-sidebar').toggleClass('open');
	});

	/*===============================================
					Masonry layout
	================================================*/

	if ( $('#masonry_grid').length ) {
		new AnimOnScroll( document.getElementById( "masonry_grid" ), {
			minDuration : 0.4,
			maxDuration : 0.7,
			viewportFactor : 0.2
		} );
	}

	/* Collection Menu Hover */
	$('.sidebar-collections').on('hover', function() {
		$(this).find('.sdcollections-content').toggleClass('opened');
	});

	/* Ajax Cart Message Remove */
	var notificationContent = '';

	$( 'body' ).on('click', '.ajax_add_to_cart', function(){ 
		$('.woocommerce-message').remove();
		if ($('body').hasClass('woocommerce-wishlist')) {
			var imgSrc = $(this).parents('tr').find('img.attachment-shop_thumbnail').attr('src');
			var prodTitle = $(this).parents('tr').find('.product-name a.product-name').text();
		}

		if ( typeof imgSrc != 'undefined' && typeof prodTitle != 'undefined' )
		{
			notificationContent = '<div class="woocommerce-message"><div class="product_notification_wrapper"><div class="product_notification_background" style="background-image:url(' + imgSrc + ')"></div><div class="product_notification_text">&quot;' + prodTitle + '&quot;' + addedToCartMessage +'</div></div></div>';
		}
		else 
		{
			notificationContent = false;
		}
	});

	$(document).on('added_to_cart', function(event, data) {
		if (notificationContent !== false)
		{
			$('.main-content').append(notificationContent);
		}
	});

	/* Variable product image */
	$( document ).on( 'found_variation', '.variations_form', function( event, variation ) {
		if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
			var $form             	= $(this),
				$product          	= $form.closest( '.product' ),
				$featured_img		= $product.find( '.product-image-slider' ),
				$gallery_img      	= $product.find( '.product-thumbs-slider' ),
				$swiper_img			= $product.find('.swiper-wrapper.images');

			if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
				if ( $gallery_img.find( 'img[src="' + variation.image.thumb_src + '"]' ).length > 0 ) {
					$gallery_img.find( 'img[src="' + variation.image.thumb_src + '"]' ).trigger('click');
					$form.attr( 'current-image', variation.image_id );
					return;
				} else {
					var changed_thumb_img = $gallery_img.find('.owl-item').first();
					changed_thumb_img.find('img').attr('src', variation.image.thumb_src);
					changed_thumb_img.find('img').trigger('click');
					var changed_img = $featured_img.find('.owl-item.active');
					changed_img.find('img').attr('src', variation.image.src);
					changed_img.find('.zoomContainer > div:first').css('background-image', 'url(' + variation.image.src + ')');
				}

				if ( $swiper_img.find( 'img[src="' + variation.image.src + '"]' ).length > 0 ) {
					var variationImage = $swiper_img.find( 'img[src="' + variation.image.src + '"]' ).parent('.swiper-slide');
					var imageIndex = variationImage.index('.homemarket-slider-wrapper .swiper-wrapper .swiper-slide');

					$('.homemarket-slider-wrapper .swiper-pagination > span').eq(imageIndex).click();
					$form.attr( 'current-image', variation.image_id );
					return;
				}
			}
		}
	} );

	/* category widget sub dropdown */
	var parentCategory =  $('aside.sidebar ul.product-categories li.cat-parent')
	if ( parentCategory.hasClass('current-cat') || parentCategory.hasClass('current-cat-parent') ) {
		parentCategory.removeClass('parent-close');
		parentCategory.addClass('parent-open');			
	}

	$('aside.sidebar ul.product-categories li.cat-parent').off('click').on('click', function() {

		if ( !$(this).hasClass('parent-open') ) {

			$(this).removeClass('parent-close');
			$(this).addClass('parent-open');
			$(this).find('.children').slideDown(500);

		} else {

			$(this).removeClass('parent-open');
			$(this).addClass('parent-close');
			$(this).find('.children').slideUp(500);

		}

	});

	$('.nav-bar .site-nav>li.menu-item-has-children').each(function() {
		var leftPosition = $(this).position().left;
		var navWidth = $('.nav-bar .site-nav').width();
		var submenuWidth = navWidth - leftPosition;
		var real_submenuWidth = $(this).find('>ul.sub-menu.level-0').outerWidth(true);

		if ( real_submenuWidth > submenuWidth ) {
			$(this).find('>ul.sub-menu.level-0').css('right', 0);
		}
	});

});
