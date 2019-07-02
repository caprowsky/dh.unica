jQuery(document).ready(function ($) {

    
    $('.wrap').on("click","#custom-admin-notice .notice-dismiss",function(event) {
        event.preventDefault();        
        
        var userId = $(this).parent().attr('data');

        //do request    
        var data = {
            'action': 'dismiss_message',
            'userId': userId,
        };


        jQuery.post(ajaxurl, data, function (response) {

        });
        
    });
    

});
