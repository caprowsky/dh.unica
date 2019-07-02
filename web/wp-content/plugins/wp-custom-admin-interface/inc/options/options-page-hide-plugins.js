jQuery(document).ready(function ($) {
    
// ******************************* HIDE PLUGINS PAGE ***************************//
    
    
    
    //select/deselect all functionality
    $('.wrap').on("click", "#select-all-items", function (event) {
        event.preventDefault();
        
        var allItems = '';
        
        
        $('.plugin-item').each(function(index) {
            
            var hiddenPlugins = $('#wp_custom_admin_interface_hide_these_plugins').val('');
            
            var pluginPath = $(this).find('#plugin-name').attr('data');
            
            allItems += ','+pluginPath;
            
            
            $(this).addClass("hidden-plugin-item");
            $(this).find('.remove-plugin-item').addClass("fa-eye");
            $(this).find('.remove-plugin-item').removeClass("fa-eye-slash");   
 
        });
        
        $('#wp_custom_admin_interface_hide_these_plugins').val(allItems);
        
        
    });
    
    $('.wrap').on("click", "#deselect-all-items", function (event) {
        event.preventDefault();

        $('.plugin-item').each(function(index) {
            
            var hiddenPlugins = $('#wp_custom_admin_interface_hide_these_plugins').val('');
            
            $(this).removeClass("hidden-plugin-item");
            $(this).find('.remove-plugin-item').removeClass("fa-eye");
            $(this).find('.remove-plugin-item').addClass("fa-eye-slash");   
 
        });
    });
    
    
    
    
    
    //code to add and remove items from input when clicking the hide icon

    $('.wrap').on("click", ".remove-plugin-item", function () {

        var hiddenPlugins = $('#wp_custom_admin_interface_hide_these_plugins').val();

        if (hiddenPlugins != null) {
            var hiddenPluginsArray = hiddenPlugins.split(',');
        }
        
        var pluginPath = $(this).parent().find('#plugin-name').attr('data');
        
        
        if ($.inArray(pluginPath, hiddenPluginsArray) != -1) {
            //it is in array i.e. we need to remove it  
            $(this).parent().parent().removeClass("hidden-plugin-item");    
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
            
            hiddenPluginsArray.splice($.inArray(pluginPath, hiddenPluginsArray), 1);
            $('#wp_custom_admin_interface_hide_these_plugins').val(hiddenPluginsArray.join());
            
        } else {
            //its not in the array i.e. we need to add it
            $(this).parent().parent().addClass("hidden-plugin-item");
            $(this).addClass("fa-eye");
            $(this).removeClass("fa-eye-slash"); 
            
            hiddenPluginsArray.push(pluginPath);
            $('#wp_custom_admin_interface_hide_these_plugins').val(hiddenPluginsArray.join());

        }

    });
    
    //code to assign the appropriate classes initially
    
    function assignInitialHidePluginClasses(){
        
        $('.plugin-item').each(function(index) {
            
            var pluginPath = $(this).find('#plugin-name').attr('data');
            var hiddenPlugins = $('#wp_custom_admin_interface_hide_these_plugins').val();

            if (hiddenPlugins != null) {
                var hiddenPluginsArray = hiddenPlugins.split(',');
            }
            
            
            if ($.inArray(pluginPath, hiddenPluginsArray) != -1) {
                $(this).addClass("hidden-plugin-item");
                $(this).find('.remove-plugin-item').addClass("fa-eye");
                $(this).find('.remove-plugin-item').removeClass("fa-eye-slash");   
            }
            
        });
        
        
    }
    //lets run this function initially
    assignInitialHidePluginClasses();  
    
    
    
    
    
    
});