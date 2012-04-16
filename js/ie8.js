$(function() {
    // Fix fancytitle display. 
    $('.fancytitle').each(function() {
        var elem = this;
        var title = $(elem).html();
        $(elem).html('<div class="fancytitle_inner"></div>');
        var elem2 = $(elem).find('.fancytitle_inner');
        $(elem2).html(title);
    });
});
