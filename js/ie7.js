$(function() {
    $("#navbar > ul > li").wrap("<td />");
    $("#navbar > ul").wrap("<tr />");
    $("#navbar").wrapInner("<table />");
    
    $(".fancytitle").wrap('<div class="fancytitle_wrap" />')
    $(".fancytitle_wrap").prepend('<div class="fancytitle_before"></div>');
});