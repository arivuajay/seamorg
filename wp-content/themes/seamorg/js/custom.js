/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function randomString(length) {
    chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i)
        result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
}
(function($) {
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        if ($('input#user_password-118').length > 0) {
            $('input#user_password-118').val(randomString(8));
        }

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

//        if (!$('#event-rsvp').is(':checked')) {
//            $('#event-rsvp').prop("checked", 'checked').triggerHandler('click');
//        }
//$('#weather_report').parent('p').remove();
        jQuery(".create-event-part1 select#location-select-id").select2();
        jQuery(".page-id-66  .um-field-bank_account_no,.page-id-66  .um-field-bank_routing_no").remove();
    });
})(jQuery);

