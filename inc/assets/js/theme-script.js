jQuery(document).ready(function($){
    //'use strict';

//console.log(WKWC_options);
	// WPCF7 Star Rating
	$(".wpcf7-form-control.wpcf7-uacf7_star_rating").removeClass("form-control");

	// MailPoet
	$(".mailpoet_form_columns").addClass("form-inline");
	$(".mailpoet_form_columns input").addClass("form-control");
	$("input.mailpoet_submit").addClass("btn btn-success");
	$("table").not(".opening-hours").addClass("table");

	// Cover Image Animation
	if (WKWC_options.coverImageAni && WKWC_options.coverImageAni !== "none") {
		$('#page-sub-header').addClass('animated ' + WKWC_options.coverImageAni);
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

    // Features
	if (WKWC_options.featureAni && WKWC_options.featureAni !== "none") {
		$('.single-feature').addClass('animated ' + WKWC_options.featureAni);
		$('.contact .listing-item').addClass('animated ' + WKWC_options.featureAni);
	}

    // Pause animation until element is visible
	$('.animated').animateVisible({tolerance: 0});
	// Show animation for visible element on load
	$(window).trigger('animateVisibleResizeDone')

	$('.page-scroller').off('click');

    $(function($) {
      var offset = $('#masthead').height() + ($('#wpadminbar').height() ?? 0) + 20;
      $('a[href*=#]:not([href=#],[href*="modal"],.carousel-control-prev,.carousel-control-next)').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top - offset
            }, 1000);
            return false;
          }
        }
      });

      //Executed on page load with URL containing an anchor tag.
      if($(location.href.split("#")[1])) {
          var target = $('#'+location.href.split("#")[1]);
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top - offset
            }, 1000);
            return false;
          }
        }
    });

    if ($('#wpadminbar').length) {
        $("#masthead").css("top", $("#wpadminbar").height() ?? 0);

        $(window).on('resize', function(){
            $("#masthead").css("top", $("#wpadminbar").height() ?? 0);
        });
    }
	
	$(window).scroll(function () {
		var top = $(document).scrollTop();
		if (top > 100) {
		  $('#masthead.transparent-background').removeClass('navbar-transparent');
		  $('#masthead.no-background').addClass('bg-light');
		} else {
		  $('#masthead.transparent-background').addClass('navbar-transparent');
		  $('#masthead.no-background').removeClass('bg-light');
		}
	});
});
