/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function($) {
    $(document).ready(function() {

        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
//                    MINUS 130 FOR HEADER FIXED
                    $('html,body').animate({
                        scrollTop: target.offset().top - 130
                    }, 1000);
                    return false;
                }
            }
        });


        $('.book-button').on('click', function() {
            $('.booking-form-section h3').show();
            $('.em-booking-form,.em-booking-login').slideUp();
            _mode = $(this).data('mode');
            $("." + _mode).slideDown();
        });
    });
})(jQuery);

