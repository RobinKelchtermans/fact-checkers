$(document).ready(function() {
    $('.togglable-card').click(function() {
        setTimeout(() => {
            $([document.documentElement, document.body]).animate({
                scrollTop: $(this).offset().top - 100
            }, 500);
        }, 200);
    });

});