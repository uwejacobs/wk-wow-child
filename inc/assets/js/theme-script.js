jQuery(document).ready(function($){
    'use strict';

console.log(WKWC_options);

	// Cover Image Animarion
	if (WKWC_options.coverImageAni && WKWC_options.coverImageAni !== "none") {
		$('#page-sub-header').addClass('xanimated ' + WKWC_options.coverImageAni);
	}
	
	// WP Photo 
	if (WKWC_options.photoSellerGalleryAni && WKWC_options.photoSellerGalleryAni !== "none") {
		$('.gallery_item_container').addClass('animated ' + WKWC_options.photoSellerGalleryAni);
	}

    // Headers
	if (WKWC_options.headerAni && WKWC_options.headerAni !== "none") {
		$('h1,h2,h3,h4,h5,h6').addClass('animated ' + WKWC_options.headerAni);
	}

    // Buttons
	if (WKWC_options.buttonAni && WKWC_options.buttonAni !== "none") {
		$('.btn').hover(
			function() {
				$(this).addClass('animated ' + WKWC_options.buttonAni);
			},
			function() {
				$(this).removeClass('animated ' + WKWC_options.buttonAni);
			}
		);
	}

    // Pause animation until element is visible
	$('.animated').animateVisible({tolerance: .5});
	// Show animation for visible element on load
	$(window).trigger('animateVisibleResizeDone')
});
