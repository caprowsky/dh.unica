jQuery(document).ready(function ($) {
    
    
    $("#accordion").accordion({
        collapsible: true,
        autoHeight: false,
        heightStyle: "content",
        active: false,
        speed: "fast"
    });
    
    //export settings - select all
    $('#export-options-select-all').click(function (event) {
    event.preventDefault(); 

        $('.export-options-checkbox').prop('checked','checked');    
          
    });
    
    //export settings - deselect all
    $('#export-options-deselect-all').click(function (event) {
    event.preventDefault(); 

        $('.export-options-checkbox').prop('checked','');    
          
    });
    
    
    
    
    //copy the settings
    $('.copy-settings-button').click(function (event) {
    event.preventDefault(); 
        
        var selectedExportOptions = [];  
        var security = $(this).attr('data');
        
        $('.copy-settings-button-copy').remove();
        $('.copy-settings-input').remove();
        
        
        //get all checkboxes that are checked
        $( ".export-options-checkbox" ).each(function( index ) {
            
            var optionCheckbox = $(this);
            var optionCheckboxValue = $(this).val();
            
            if(optionCheckbox.is(':checked')) {
                selectedExportOptions.push(optionCheckboxValue);        
            }
            
        });
        
        if(selectedExportOptions.length == 0) {
            
            $('<div class="notice notice-error is-dismissible no-settings-selected"><p>No settings have been selected. Please select at least one setting.</p></div>').insertAfter('.copy-settings-button');
                        
            setTimeout(function() {
                $('.no-settings-selected').slideUp();
            }, 5500);
        
            
        } else {
        
            var data = {
                'action': 'export_settings',
                'settings': selectedExportOptions,
                'security': security,
            };

            jQuery.post(ajaxurl, data, function (response) {
                
                //lets escape quote
                response = response.replace(/"/g, '&quot;');

                $('<div style="margin-top:20px;" class="notice notice-success is-dismissible export-success"><p>The export successfully generated.</p></div>').insertAfter('.copy-settings-button');
                
                $('<input style="margin-left:30px;" class="wp_custom_admin_interface_settings_input copy-settings-input" type="text" value="'+response+'"><button style="margin-left:-5px; border-top-left-radius: 0px !important; border-bottom-left-radius: 0px !important; border: 1px #fff solid !important; border-left-color:transparent !important;" class="clipboard button-secondary copy-settings-button-copy" style="cursor:pointer;" data-clipboard-text="'+response+'"><i class="fa fa-clipboard" aria-hidden="true"></i></button>').insertAfter('.copy-settings-button');
                
                new ClipboardJS('.copy-settings-button-copy');
                        
                setTimeout(function() {
                    $('.export-success').slideUp();
                }, 5500);
                
                                     
            });
        
        }
        

    });
    
    //adds copy click event to generated button
    $('.wrap').on('click', '.copy-settings-button-copy', function(event){
        event.preventDefault(); 
        new ClipboardJS('.copy-settings-button-copy');
        $('.copy-settings-button-copy').text("Copied!");
        setTimeout(function() { $('.copy-settings-button-copy').html('<i class="fa fa-clipboard" aria-hidden="true"></i>'); }, 2000);
    });
    
    
    
    
    
    //import settings
    $('#import-settings').click(function (event) {
    event.preventDefault();   
            
    $(".postbox .notice-error").fadeOut("slow", function(){
        $(".import-status-message").remove();
    })    
        
    var settings = $('#wp_custom_admin_interface_import_settings').val();
    var security = $('#wp_custom_admin_interface_import_settings').attr('data'); 
        
//    console.log(settings);    
    
    //do request    
        var data = {
            'action': 'import_settings',
            'settings': settings,
            'security': security,
        };


        jQuery.post(ajaxurl, data, function (response) {

            console.log(response);

            if(response == "success") {
                $('<div class="notice notice-info is-dismissible import-status-message"><p>The settings have been successfully imported.</p></div>').insertAfter('#import-settings');
                
                setTimeout(function() {
                    $('.import-status-message').slideUp();
                }, 5500);
                
            } else {
                $('<div class="notice notice-error is-dismissible import-status-message"><p>'+response+'</p></div>').insertAfter('#import-settings');

            }
        });
    
    
    });
    
    
   
    
    
    
    
    
    //export settings - select all
    $('#delete-options-select-all').click(function (event) {
    event.preventDefault(); 

        $('.delete-options-checkbox').prop('checked','checked');    
          
    });
    
    //export settings - deselect all
    $('#delete-options-deselect-all').click(function (event) {
    event.preventDefault(); 

        $('.delete-options-checkbox').prop('checked','');    
          
    });
    
    
    
    
    //delete plugin settings
    $('#delete-settings').click(function (event) {
        event.preventDefault();   
            
        $(".postbox .notice-error").fadeOut("slow", function(){
            $(".delete-status-message").remove();
        }) 
        
        
        
        var selectedDeleteOptions = [];
        //get all checkboxes that are checked
        $( ".delete-options-checkbox" ).each(function( index ) {
            
            var optionCheckbox = $(this);
            var optionCheckboxValue = $(this).val();
            
            if(optionCheckbox.is(':checked')) {
                selectedDeleteOptions.push(optionCheckboxValue);        
            }
            
        });
        
        if(selectedDeleteOptions.length == 0) {
            
            $('<div class="notice notice-error is-dismissible no-delete-settings-selected"><p>No settings have been selected. Please select at least one setting.</p></div>').insertAfter('#delete-settings');
                        
            setTimeout(function() {
                $('.no-delete-settings-selected').slideUp();
            }, 5500);
        
            
        } else {
            
            var confirmation = confirm('Are you sure you want to delete the selected settings?');    

            if(confirmation == true) {    


                var security = $('#delete-settings').attr('data'); 


                //do request    
                    var data = {
                        'action': 'delete_settings',
                        'settings': selectedDeleteOptions,
                        'security': security,
                    };


                    jQuery.post(ajaxurl, data, function (response) {

                        $('<div class="notice notice-info is-dismissible delete-status-message"><p>Selected plugin settings have been deleted.</p></div>').insertAfter('#delete-settings');

                        setTimeout(function() {
                            $('.delete-status-message').slideUp();
                        }, 5500);

                    });   

            } //end confirmation
        
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

         

  
    }); //end delete plugin settings
    
    

    
}); //end jQuery