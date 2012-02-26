var sorter_default_top;

function downloads_sorter_update() {
	var scrollTop = $(window).scrollTop();
	var activated = false;
	$('.downloads_type_title').each(function() {
		var offset = $(this).offset().top;
		if (offset - scrollTop >= 0) { // if the title has scrolled off of the screen
			var element = $(this).prevAll('.downloads_type_title');
			if (element.length == 0) {
				element = $(this);
			}
			var href = '#' + element.attr('id');
			$('#downloads_sorter_typewrapper a').removeClass('downloads_sorter_type_current');
			$('#downloads_sorter_typewrapper a[href="' + href + '"]').addClass('downloads_sorter_type_current');
			activated = true;
			return false;
		}
	});
	if (!activated) {
		var href = '#' + $('.downloads_type_title').last().attr('id');
		$('#downloads_sorter_typewrapper a').removeClass('downloads_sorter_type_current');
		$('#downloads_sorter_typewrapper a[href="' + href + '"]').addClass('downloads_sorter_type_current');
	}
	
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
