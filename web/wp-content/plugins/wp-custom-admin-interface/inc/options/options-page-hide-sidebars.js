jQuery(document).ready(function ($) {
    

        // ******************************* HIDE SIDEBARS PAGE ***************************//
    
    //select/deselect all functionality
    $('.wrap').on("click", "#select-all-items", function (event) {
        event.preventDefault();
        
        var allItems = '';
        
        
        $('.sidebar-item').each(function(index) {
            
            var hiddensidebars = $('#wp_custom_admin_interface_hide_these_sidebars').val('');
            
            var sidebarPath = $(this).find('#sidebar-name').attr('data');
            
            allItems += ','+sidebarPath;
            
            
            $(this).addClass("hidden-sidebar-item");
            $(this).find('.remove-sidebar-item').addClass("fa-eye");
            $(this).find('.remove-sidebar-item').removeClass("fa-eye-slash");   
 
        });
        
        $('#wp_custom_admin_interface_hide_these_sidebars').val(allItems);
        
        
    });
    
    $('.wrap').on("click", "#deselect-all-items", function (event) {
        event.preventDefault();

        $('.sidebar-item').each(function(index) {
            
            var hiddensidebars = $('#wp_custom_admin_interface_hide_these_sidebars').val('');
            
            $(this).removeClass("hidden-sidebar-item");
            $(this).find('.remove-sidebar-item').removeClass("fa-eye");
            $(this).find('.remove-sidebar-item').addClass("fa-eye-slash");   
 
        });
    });
    
    
    
    //code to add and remove items from input when clicking the hide icon

    $('.wrap').on("click", ".remove-sidebar-item", function () {

        var hiddenSidebars = $('#wp_custom_admin_interface_hide_these_sidebars').val();

        if (hiddenSidebars != null) {
            var hiddenSidebarsArray = hiddenSidebars.split(',');
        }
        
        var sidebarPath = $(this).parent().find('#sidebar-name').attr('data');
        
        
        if ($.inArray(sidebarPath, hiddenSidebarsArray) != -1) {
            //it is in array i.e. we need to remove it  
            $(this).parent().parent().removeClass("hidden-sidebar-item");    
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
            
            hiddenSidebarsArray.splice($.inArray(sidebarPath, hiddenSidebarsArray), 1);
            $('#wp_custom_admin_interface_hide_these_sidebars').val(hiddenSidebarsArray.join());
            
        } else {
            //its not in the array i.e. we need to add it
            $(this).parent().parent().addClass("hidden-sidebar-item");
            $(this).addClass("fa-eye");
            $(this).removeClass("fa-eye-slash"); 
            
            hiddenSidebarsArray.push(sidebarPath);
            $('#wp_custom_admin_interface_hide_these_sidebars').val(hiddenSidebarsArray.join());

        }

    });
    
    //code to assign the appropriate classes initially
    
    function assignInitialHideSidebarClasses(){
        
        $('.sidebar-item').each(function(index) {
            
            var sidebarPath = $(this).find('#sidebar-name').attr('data');
            var hiddenSidebars = $('#wp_custom_admin_interface_hide_these_sidebars').val();

            if (hiddenSidebars != null) {
                var hiddenSidebarsArray = hiddenSidebars.split(',');
            }
            
            
            if ($.inArray(sidebarPath, hiddenSidebarsArray) != -1) {
                $(this).addClass("hidden-sidebar-item");
                $(this).find('.remove-sidebar-item').addClass("fa-eye");
                $(this).find('.remove-sidebar-item').removeClass("fa-eye-slash");   
            }
            
        });
        
        
    }
    //lets run this function initially
    assignInitialHideSidebarClasses();
    
    
    
    
});