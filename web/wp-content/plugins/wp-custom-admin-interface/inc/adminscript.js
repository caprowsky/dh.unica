jQuery(document).ready(function ($) {
    
    
    

    //hides and then shows on click help tooltips
    $(".hidden").hide();
    $(".information-icon").click(function (event) {
        event.preventDefault();
        $(this).next(".hidden").slideToggle();
    });
    
    
    //instantiates the Wordpress colour picker
    $('.my-color-field').wpColorPicker();
    
   
   //makes image upload field 
   $('.postbox').on("click",".wp_custom_admin_interface_media_upload_button", function(e){
        e.preventDefault();
        
        var previousInput = $(this).prev(); 
       
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            
            previousInput.val(image_url);

        });
    });
    
   
    
    
    
    

    //adds shortcode button text to footer tinymce area  
    $('.wp_custom_admin_interface_append_buttons_footer_text').click(function () {
        
        $('#wp_custom_admin_interface_custom_footer_ifr').contents().find("#tinymce p").html( $('#wp_custom_admin_interface_custom_footer_ifr').contents().find("#tinymce p").html() +$(this).attr("value"));
        
        $('#wp-wp_custom_admin_interface_custom_footer-editor-container').find("textarea").html( $('#wp-wp_custom_admin_interface_custom_footer-editor-container').find("textarea").html() +$(this).attr("value"));
        
    });
    
    //adds shortcode button text to widget tinymce area  
    $('.wp_custom_admin_interface_append_buttons_widget_text').click(function () {
        
        $('#wp_custom_admin_interface_custom_widget_content_ifr').contents().find("#tinymce p").html( $('#wp_custom_admin_interface_custom_widget_content_ifr').contents().find("#tinymce p").html() +$(this).attr("value"));
        
        $('#wp-wp_custom_admin_interface_custom_widget_content-editor-container').find("textarea").html( $('#wp-wp_custom_admin_interface_custom_widget_content-editor-container').find("textarea").html() +$(this).attr("value"));
        
    });
    
    
    //adds shortcode button text to widget tinymce area  
    $('.wp_custom_admin_interface_append_buttons_notice_text').click(function () {
        
        $('#wp_custom_admin_interface_notice_message_ifr').contents().find("#tinymce p").html( $('#wp_custom_admin_interface_notice_message_ifr').contents().find("#tinymce p").html() +$(this).attr("value"));
        
        $('#wp_custom_admin_interface_notice_message-editor-container').find("textarea").html( $('#wp-wp_custom_admin_interface_notice_message-editor-container').find("textarea").html() +$(this).attr("value"));
        
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //exception case work
    // ******************************* EXCEPTION CASES ***************************//
    
    
        function createUserAndRoleSelection(selected, destination){

            var selectedOption = selected;

            var allRolesAndUsers = $('#combinedListOfUsersAndRoles').attr('data');

            var allRolesAndUsersRemoveLastComma = allRolesAndUsers.slice(0,-1);

            var allRolesAndUsersArray = allRolesAndUsersRemoveLastComma.split(',');

            var output = '<div class="exception-case"><select>';

            for (key in allRolesAndUsersArray){

                var option = allRolesAndUsersArray[key];

                if(option.indexOf('Role:') >= 0) {

                    var optionValue = option.substr(6,option.length - 6);

                    if(optionValue == selectedOption) {
                        output += '<option selected="selected" value="'+optionValue+'">'+option+'</option>';    
                    } else{
                        output += '<option value="'+optionValue+'">'+option+'</option>';    
                    }



                } else {

                    var optionFirstBracket = option.indexOf('(');
                    var optionLastBracket = option.indexOf(')');
                    var optionValue = option.substr(optionFirstBracket+1,optionLastBracket-optionFirstBracket-1);

                    var optionDisplay = option.substr(0,optionFirstBracket);

                    if(optionValue == selectedOption) {
                        output += '<option selected="selected" value="'+optionValue+'">'+optionDisplay+'</option>';
                    } else {
                        output += '<option value="'+optionValue+'">'+optionDisplay+'</option>';    
                    }

                }

            } 

            output += '</select><i class="fa fa-plus add-exception-case" aria-hidden="true"></i><i class="fa fa-minus remove-exception-case" aria-hidden="true"></i></div>';
            
            destination.find('#outputOfUsersAndRolesSelection').append(output);


        }
    
    
    
    

    
    $('.userAndRoleSelection').each(function(index) {

        var typeContainer = $(this);
        var exceptionContainer = $(this).next().next();
        
        //lets get our users and roles and turn it into a dropdown


        //execute function initially
        //get saved setting
        var savedExceptions = exceptionContainer.find('.saved_exception_cases').val();
        
        //remove last comma    
        var savedExceptionsRemoveLastComma = savedExceptions.slice(0,-1);
        //turn the comma list into an array
        var savedExceptionsArray = savedExceptionsRemoveLastComma.split(',');


        if(savedExceptions.length>0){
            //for each item in the array call the function to create a select line item and give it a preselected value of our array value
            $.each(savedExceptionsArray,function(key,value) {
                createUserAndRoleSelection(value,exceptionContainer);        
            });

        } else {
            //call the initial exception message
            addInitialException(exceptionContainer);  
        }



        
    });

    
        
    
        //function to render the add select option when no exceptions are created
        function addInitialException(destination){
            
        destination.find('#outputOfUsersAndRolesSelection').append('<div class="add-exception-case" id="add-initial-exception"><h3><i class="fa fa-plus" aria-hidden="true"></i> Add an exception case</h3></div>');     
               
        }
    
        
    
        //add exception case
        $('.wrap').on("click", ".add-exception-case", function (event) {

            //prevent the form from submitting    
            event.preventDefault(); 

            //remove initial add exception if exists
            
            var containerRow = $(this).parent().parent().parent().parent(); 
            
            $(this).parent().parent().find('#add-initial-exception').remove(); 
            
            createUserAndRoleSelection('',containerRow);
            

        });
    
    
   


        //remove exception case
        $('.wrap').on("click", ".remove-exception-case", function (event) {

            //prevent the form from submitting    
            event.preventDefault(); 

            var parentContainer = $(this).parent().parent();
            var parentParentContainer = $(this).parent().parent().parent();
            
            var countOfExceptionCases = parentContainer.find('.exception-case').length; 
            
            if(countOfExceptionCases == 1) {
                $(this).parent().remove();
                addInitialException(parentParentContainer);
            } else {
                $(this).parent().remove();    
            }

        });
    
 
});