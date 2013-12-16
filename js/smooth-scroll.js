(function($) {
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){ // When a link with the .scroll class is clicked
            event.preventDefault(); // Prevent the default action from occurring
            $('html,body').animate({
                scrollTop: ($(this.hash).offset().top - 80) 
            }, 500); 
            setActiveMenuLink($(this).attr('id'));
        });
    });
})(jQuery);