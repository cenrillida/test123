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