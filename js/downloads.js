var sorter_default_top;

function downloads_sorter_update() {
	var scrollTop = $(window).scrollTop();
	
	// Search for the last element header that has scrolled off of the top of the screen, or is within 10 pixels of the edge. 
	// Default to the first category if none has scrolled away. 
	var element = $('.downloads_type_title').first(); 
	$($('.downloads_type_title').get().reverse()).each(function() {
		var offset = $(this).offset().top;
		if (offset < scrollTop + 10) { 
			element = $(this);
			return false;
		}
	});
	
	// Find and highlight the corresponding category in the sorter. 
	var href = '#' + element.attr('id');
	$('#downloads_sorter_typewrapper a').removeClass('downloads_sorter_type_current');
	$('#downloads_sorter_typewrapper a[href="' + href + '"]').addClass('downloads_sorter_type_current');
	
	if (scrollTop + 20 > sorter_default_top) {
		$('#downloads_sorter').offset({'top': scrollTop + 20});
	} else {
		$('#downloads_sorter').offset({'top': sorter_default_top});
	}
}

$(function() {
	sorter_default_top = $('#downloads_sorter').offset().top;
	$(window).scroll(function() {
		downloads_sorter_update();
	});
	$(window).resize(function() {
		downloads_sorter_update();
	});
	downloads_sorter_update();
});
