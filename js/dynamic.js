function dynamic_load(href) {
    var animation_complete = false;
    var loading_complete = false;
    
    var new_content = '';
    
    var insert = function() {
        if (animation_complete && loading_complete) {
            // Insert new elements and animate them in
            $('#main_content_wrap').css({'opacity': '0'}).html(new_content);
            $('#main_content_wrap .fancybox').css({'position': 'relative', 'left': '20px', 'opacity': '0'});
            $('#main_content_wrap').css({'opacity': '1'});
            $('#main_content_wrap .fancybox').animate({'left': '0', 'opacity': '1'});
            
            // Call document ready event again
            $(document).ready();
        }
    };
    
    // Animate elements out
    $('#main_content_wrap .fancybox').css({'position': 'relative'}).animate({'left': '-20px', 'opacity': '0'}, function() {
        // Remove elements when done
        $('#main_content_wrap').html('');
        animation_complete = true;
        insert();
    });
    
    // Get new content
    $.get(href, function(data){
        new_content = $(data).find('#main_content_wrap').html();
        loading_complete = true;
        insert();
    });
}

$(function() {
    $('body').delegate('a', 'click', function() {
        var href = $(this).attr('href');
        var stateObj = {'href': href};
        history.pushState(stateObj, href, href);
        dynamic_load(href);
        return false;
    });
    
    window.onpopstate = function(e) {
        if (e.state.href != null && e.state.href != document.location) {
            dynamic_load(e.state.href);
        }
    };
});
