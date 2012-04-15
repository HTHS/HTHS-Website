$(function() {
    // Highlight currently active parent menu item when hovering over its dropdown menu. 
	$('#navbar li ul').hover(function() {
	    $(this).parent().find('a').addClass('current');
	}, function() {
	    $(this).parent().find('a').removeClass('current');
	});
	
	// Disable menu items which link to "#", as these don't have an associated page. 
	$('#navbar > ul > li > a[href$="#"]').css({'cursor': 'default'}).click(function(){
	    return false;
	});
});