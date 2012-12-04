$(document).ready(function(){
    $("#top-menu").hide();
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 350) {
                $('#top-menu').fadeIn();
            } else {
                $('#top-menu').fadeOut();
            }
        });
    });
});