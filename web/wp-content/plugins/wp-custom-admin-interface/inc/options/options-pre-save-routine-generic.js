jQuery(document).ready(function ($) {

    
    //PRESAVE ROUTINE 
    $('#custom_admin_interface_settings_form').submit(function(event) { 
        

        event.preventDefault();
        
  
        $('.settings-loading-message').remove();

        //show loading message
        $('<div class="notice notice-warning is-dismissible settings-loading-message"><p><i class="fa fa-circle-o-notch wp-custom-admin-interface-loading" aria-hidden="true"></i> Please wait while we save the settings...</p></div>').insertAfter('.wp-custom-admin-interface-save-button');

        //run ajax to clear the transients
        var data = {
            'action': 'delete_transients'
        };

        jQuery.post(ajaxurl, data, function (response) {
            //we don't need to do anything
        });
        
        
        //lets delete the transients relating to the dismiss message only if the the page is the admin notice page
        if($('#wp_custom_admin_interface_notice_color').length){
            var data = {
                'action': 'delete_dismiss_transients'
            };

            jQuery.post(ajaxurl, data, function (response) {
                //we don't need to do anything
            });    
        }
        
        
        //only trigger the tinymce save act
        if($('.tmce-active').length){
            tinyMCE.triggerSave();    
        }
        
        //if user/role selection exists add the exceptions to the hidden input field
        if($('.userAndRoleSelection').length){
            $('.userAndRoleSelection').each(function() {

            var newExceptions = '';

            var nextContainer = $(this).next().next();

            $.each(nextContainer.find('select'),function() {

                var exceptionCaseValue = $(this).val();

                newExceptions += exceptionCaseValue+',';

            });
                nextContainer.find('.saved_exception_cases').val(newExceptions);

            });
        }

        //save the settings via ajax call
        $(this).ajaxSubmit({
        success: function(){
            
            
            
            $('.settings-loading-message').remove();
            $('.settings-saved-message').remove();

            $('<div class="notice notice-success is-dismissible settings-saved-message"><p>The settings have been saved.</p></div>').insertAfter('.wp-custom-admin-interface-save-button');
            setTimeout(function() {
                $('.settings-saved-message').slideUp();
            }, 3000);
            
            

        }
        }); 
        
    });    
});