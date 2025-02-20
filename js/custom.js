	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() > 1000) {
			jQuery('a.arrowup').fadeIn();
		} else {
			jQuery('a.arrowup').fadeOut();
		}
	});
	
	jQuery('a.arrowup').click(function () {
		jQuery('body,html').stop(false, false).animate({
			scrollTop: 0
		}, 800);
		return false;
	});

    function top_img_prim_toggle(){jQuery(".top-img-prim").toggleClass("transparent")}
    function bottom_img_prim_toggle(){jQuery(".bottom-img-prim").toggleClass("transparent")}

    jQuery( document ).ready(function() {
        jQuery('img[data-src]').each(function() {
            var img = jQuery(this);
            img.attr('src', img.attr('data-src'));
            img.on('load', function() {
                img.removeAttr('data-src');
            });
        });
        if (jQuery('.top-img-prim').length) {
			setTimeout(top_img_prim_toggle, 500);
			setTimeout(bottom_img_prim_toggle, 1500);
        }
    });
