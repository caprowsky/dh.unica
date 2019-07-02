jQuery(document).ready(function ($) {
    

        // ******************************* HIDE USERS PAGE ***************************//
    
    
    //select/deselect all functionality
    $('.wrap').on("click", "#select-all-items", function (event) {
        event.preventDefault();
        
        var allItems = '';
        
        
        $('.user-item').each(function(index) {
            
            var hiddenusers = $('#wp_custom_admin_interface_hide_these_users').val('');
            
            var userPath = $(this).find('#user-name').attr('data');
            
            allItems += ','+userPath;
            
            
            $(this).addClass("hidden-user-item");
            $(this).find('.remove-user-item').addClass("fa-eye");
            $(this).find('.remove-user-item').removeClass("fa-eye-slash");   
 
        });
        
        $('#wp_custom_admin_interface_hide_these_users').val(allItems);
        
        
    });
    
    $('.wrap').on("click", "#deselect-all-items", function (event) {
        event.preventDefault();

        $('.user-item').each(function(index) {
            
            var hiddenusers = $('#wp_custom_admin_interface_hide_these_users').val('');
            
            $(this).removeClass("hidden-user-item");
            $(this).find('.remove-user-item').removeClass("fa-eye");
            $(this).find('.remove-user-item').addClass("fa-eye-slash");   
 
        });
    });
   
   
    
    
    
    
    
    //code to add and remove items from input when clicking the hide icon

    $('.wrap').on("click", ".remove-user-item", function () {

        var hiddenUsers = $('#wp_custom_admin_interface_hide_these_users').val();

        if (hiddenUsers != null) {
            var hiddenUsersArray = hiddenUsers.split(',');
        }
        
        var userPath = $(this).parent().find('#user-name').attr('data');
        
        
        if ($.inArray(userPath, hiddenUsersArray) != -1) {
            //it is in array i.e. we need to remove it  
            $(this).parent().parent().removeClass("hidden-user-item");    
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
            
            hiddenUsersArray.splice($.inArray(userPath, hiddenUsersArray), 1);
            $('#wp_custom_admin_interface_hide_these_users').val(hiddenUsersArray.join());
            
        } else {
            //its not in the array i.e. we need to add it
            $(this).parent().parent().addClass("hidden-user-item");
            $(this).addClass("fa-eye");
            $(this).removeClass("fa-eye-slash"); 
            
            hiddenUsersArray.push(userPath);
            $('#wp_custom_admin_interface_hide_these_users').val(hiddenUsersArray.join());

        }

    });
    
    //code to assign the appropriate classes initially
    
    function assignInitialHideUserClasses(){
        
        $('.user-item').each(function(index) {
            
            var userPath = $(this).find('#user-name').attr('data');
            var hiddenUsers = $('#wp_custom_admin_interface_hide_these_users').val();

            if (hiddenUsers != null) {
                var hiddenUsersArray = hiddenUsers.split(',');
            }
            
            
            if ($.inArray(userPath, hiddenUsersArray) != -1) {
                $(this).addClass("hidden-user-item");
                $(this).find('.remove-user-item').addClass("fa-eye");
                $(this).find('.remove-user-item').removeClass("fa-eye-slash");   
            }
            
        });
        
        
    }
    //lets run this function initially
    assignInitialHideUserClasses();
    
    
    
    
    
});