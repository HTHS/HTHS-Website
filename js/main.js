$(function() {
	$('#navbar li ul').hover(function() {
	    $(this).parent().find('a').addClass('current');
	}, function() {
	    $(this).parent().find('a').removeClass('current');
	});
});