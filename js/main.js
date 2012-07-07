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
	
	// Mobile navbar
	// Create the dropdown base
	$("<select />").appendTo("#navbar_mobile");
	
	// Create default option "Go to..."
	$("<option />", {
		"selected": "selected",
		"value"   : "",
		"text"    : "Go to page..."
	}).appendTo("#navbar_mobile select");
	
	// Populate dropdown with menu items
	$("#navbar > ul > li").each(function() {
		var el = $(this).find("a").eq(0);
		$("<option />", {
			"value"   : el.attr("href"),
			"text"    : el.text()
		}).appendTo("#navbar_mobile select");
		$(this).find("ul > li > a").each(function() {
			var el = $(this);
			$("<option />", {
				"value"   : el.attr("href"),
				"text"    : "- " + el.text()
			}).appendTo("#navbar_mobile select");
		});
	});
	
	$("#navbar_mobile select").change(function() {
		window.location = $(this).find("option:selected").val();
	});
	
	// Mobile/desktop view switcher
	$('link[href$="mobile.css"]').attr('disabled', false);
	$('a#mobileview').click(function(e) {
	    e.preventDefault();
	    $('link[href$="mobile.css"]').attr('disabled', false);
	});
	$('a#desktopview').click(function(e) {
        e.preventDefault();
        $('link[href$="mobile.css"]').attr('disabled', true);
    });
});