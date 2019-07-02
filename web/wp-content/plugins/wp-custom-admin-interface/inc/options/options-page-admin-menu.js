jQuery(document).ready(function ($) {
    




    //add newly added menu items
    $('#add-newly-added-menu-items').click(function (event) {
        event.preventDefault();  
        //this variable will be used to add html and we will prepend this to the menu for easy visibility
        var packagedAdminMenuManager = '';

        var topLevelMenuSettingDecodedAndParsed = JSON.parse($(this).attr('menudata'));
        var subLevelMenuSettingDecodedAndParsed = JSON.parse($(this).attr('submenudata'));

        for(key in topLevelMenuSettingDecodedAndParsed) {
            
            //this function is required to remove notification numbers from labels
            function removeNotificationsFromLabels (input){
                //declare the input
                var originalText = input;
                //check to see if a span exists as this means there's a number
                if(originalText.indexOf('<span') !== -1) {
                    //find the position of the span and lets get just the content before the span
                    var positionOfSpan = originalText.indexOf('<span');
                    return originalText.substr(0,positionOfSpan-1); 
                } else {
                    //otherwise just leave the text how it is
                    return originalText;
                }
            }
            
            //the item isn't a separator so let's output a visual representation of the main menu
            //first lets declare the variables which grabs the menu label, menu URL and menu icon
            var topLevelMenuLabel =  removeNotificationsFromLabels(topLevelMenuSettingDecodedAndParsed[key][0]);
            var topLevelMenuURL = topLevelMenuSettingDecodedAndParsed[key][2];
            var topLevelIcon = topLevelMenuSettingDecodedAndParsed[key][6];
            var topLevelClasses = topLevelMenuSettingDecodedAndParsed[key][4];
            var topLevelThirdValue = decodeURIComponent(topLevelMenuSettingDecodedAndParsed[key][3]);
            var topLevelFifthValue = decodeURIComponent(topLevelMenuSettingDecodedAndParsed[key][5]);
            var topLevelMenuCapability = topLevelMenuSettingDecodedAndParsed[key][1];

            //only do something if the top level menu has a label
            if(topLevelMenuLabel.length > 0){

                //let's see if the icon of the top level menu item is a dashicon or a custom svg
                if(topLevelIcon == null || topLevelIcon.indexOf('dashicons-') === -1) {

                    //ok so the item is a custom svg icon so let's output this code to render the icon, we need to use the background image in CSS to render the SVG
                    var topLevelIconOutput = '<span data="'+topLevelIcon+'" class="svg svg-menu-icon menu-item-icon" style="background-image: url(&quot;'+topLevelIcon+'&quot;);"></span>';
        
                } else {
                    //ok so the item is a dashicon so let's output this code to render the dashicon
                    var topLevelIconOutput = '<span data="'+topLevelIcon+'" class="menu-item-icon dashicons-before '+topLevelIcon+'"></span>';    
                }
                

                //let's now output the top level menu item using the variables declared above
                packagedAdminMenuManager += '<li class="menu-item"><div>'+topLevelIconOutput+'<input readonly="readonly" type="text" data="'+topLevelMenuURL+'" class="menu-label" value="'+topLevelMenuLabel+'"><i class="fa fa-pencil-square-o edit-menu-item" title="Edit menu label" aria-hidden="true"></i><input readonly="readonly" type="text" data="'+topLevelMenuURL+'" class="menu-url restricted-advanced-functionality" style="margin-left:20px;" value="'+topLevelMenuURL+'"><i class="restricted-advanced-functionality fa fa-link edit-menu-item-link" title="Edit menu link" aria-hidden="true"></i><input readonly="readonly" type="text" data="'+topLevelClasses+'" class="menu-classes restricted-advanced-functionality" style="margin-left:20px;" value="'+topLevelClasses+'"><i class="restricted-advanced-functionality fa fa-code edit-menu-item-classes" title="Edit menu classes" aria-hidden="true"></i>'+adminCampailitiesSelect(topLevelMenuCapability)+'<input readonly="readonly" type="text" data="'+topLevelThirdValue+'" class="menu-third-value" style="margin-left:20px;" value="'+topLevelThirdValue+'"><input readonly="readonly" type="text" data="'+topLevelFifthValue+'" class="menu-fifth-value" style="margin-left:20px;" value="'+topLevelFifthValue+'"><i class="fa fa-eye-slash remove-menu-item" title="Hide menu item" aria-hidden="true"></i></div>';

                //let's now declare a variable which gets the appropriate sub menu item for this particular top level menu item
                var subLevelObject = subLevelMenuSettingDecodedAndParsed[topLevelMenuURL];
                
                //check if sub leve menus exist otherwise do nothing
                if (subLevelObject != null){

                    packagedAdminMenuManager += '<ul>';
                    //let's loop through each sub menu item for the top level menu item as there could be multiple sub level menu items
                    for (key in subLevelObject) {

                        //declare variables for the label and URL
                        var subLevelMenuLabel = removeNotificationsFromLabels(subLevelObject[key][0]);
                        var subLevelMenuURL = subLevelObject[key][2];
                        var subLevelMenuCapability = subLevelObject[key][1];
                        var subLevelMenuThirdValue = decodeURIComponent(subLevelObject[key][3]);

                        //lets output the sub menu items using our above variables
                        packagedAdminMenuManager += '<li class="menu-item"><div><span data="dashicons-admin-generic" class="menu-item-icon dashicons-before dashicons-admin-generic"></span><input readonly="readonly" type="text" data="'+topLevelMenuURL+'['+subLevelMenuURL+']" class="menu-label" value="'+subLevelMenuLabel+'"><i class="fa fa-pencil-square-o edit-menu-item" title="Edit menu label" aria-hidden="true"></i><input readonly="readonly" type="text" data="'+subLevelMenuURL+'" class="menu-url restricted-advanced-functionality" style="margin-left:20px;" value="'+subLevelMenuURL+'"><i class="restricted-advanced-functionality fa fa-link edit-menu-item-link" title="Edit menu link" aria-hidden="true"></i><input readonly="readonly" type="text" data="menu-top" class="menu-classes restricted-advanced-functionality" style="margin-left:20px;" value="menu-top"><i class="restricted-advanced-functionality fa fa-code edit-menu-item-classes" title="Edit menu classes" aria-hidden="true"></i>'+adminCampailitiesSelect(subLevelMenuCapability)+'<input readonly="readonly" type="text" data="" class="menu-third-value" style="margin-left:20px;" value="'+subLevelMenuThirdValue+'"><input readonly="readonly" type="text" data="" class="menu-fifth-value" style="margin-left:20px;" value=""><i class="fa fa-eye-slash remove-menu-item" title="Hide menu item" aria-hidden="true"></i></div></li>';    
                    }
                    
                    packagedAdminMenuManager += '</ul>';
                }
                
                packagedAdminMenuManager += '</li>';
            }

        }


        $('#admin-menu-manager').prepend(packagedAdminMenuManager);



        //re-assign labels appropriate classes
        assignLabelsAppropriateClasses();
            
        //maintain advanced functionality where appropriate
        setAdvancedFunctionality();

        //lets render a success message
        $('<div class="notice notice-info is-dismissible restore-menu-message"><p>The newly added menu items have now been added to the top of your menu.</p></div>').insertAfter('#admin-menu-manager-buttons');
        
        setTimeout(function() {
            $('.restore-menu-message').slideUp();
        }, 5500);



    });    







    //function to render the admin menu manager taking the menu and submenu parameters given to it to build out the menu
    function renderAdminMenuManager (menu, submenu) {
        
        //lets remove all items inside existing div (if they should exist), this is used when restoring the menu from the last save or loading the default WordPress menu
        $('#admin-menu-manager').empty();
        var packagedAdminMenuManager = '';

        //declare input variables
        var menuInput = menu;
        var subMenuInput = submenu;
        

        // console.log(menuInput);

        if (menu.indexOf("[") != -1) {
            var topLevelMenuSettingDecodedAndParsed = JSON.parse(menuInput);
            var subLevelMenuSettingDecodedAndParsed = JSON.parse(subMenuInput);
        } else {
            var topLevelMenuSettingDecodedAndParsed = JSON.parse(atob(menuInput));
            var subLevelMenuSettingDecodedAndParsed = JSON.parse(atob(subMenuInput));  
        }


        //get the inputs and put it into JSON format so we can play with it later
        
                
        
        //for development purposes render this JSON representation of the inputs
//        console.log(topLevelMenuSettingDecodedAndParsed);
//        console.log(subLevelMenuSettingDecodedAndParsed);
        

        //loop through each item in the top level of the menu
        for(key in topLevelMenuSettingDecodedAndParsed) {
            
            //declare a variable which grabs the classes of the top level menu item
            var separatorCheck = topLevelMenuSettingDecodedAndParsed[key][4];
            
            //check to see if the item is a separator or a normal top level menu item
            if(separatorCheck.indexOf('wp-menu-separator') !== -1) {
                
                //the menu item is a separator so let's output a visual representation of a separator
                packagedAdminMenuManager += '<li class="mjs-nestedSortable-no-nesting menu-item"><div class="menu-item-separator"><span class="hr-container"><hr class="separator-rule"></span><i class="fa fa-trash-o delete-menu-item delete-separator" title="Remove separator" aria-hidden="true"></i></div></li>';

            } else {
                
                
                //this function is required to remove notification numbers from labels
                function removeNotificationsFromLabels (input){
                    //declare the input
                    var originalText = input;
                    //check to see if a span exists as this means there's a number
                    if(originalText.indexOf('<span') !== -1) {
                        //find the position of the span and lets get just the content before the span
                        var positionOfSpan = originalText.indexOf('<span');
                        return originalText.substr(0,positionOfSpan-1); 
                    } else {
                        //otherwise just leave the text how it is
                        return originalText;
                    }
                }
                
                //the item isn't a separator so let's output a visual representation of the main menu
                //first lets declare the variables which grabs the menu label, menu URL and menu icon
                var topLevelMenuLabel =  removeNotificationsFromLabels(topLevelMenuSettingDecodedAndParsed[key][0]);
                var topLevelMenuURL = topLevelMenuSettingDecodedAndParsed[key][2];
                var topLevelIcon = topLevelMenuSettingDecodedAndParsed[key][6];
                var topLevelClasses = topLevelMenuSettingDecodedAndParsed[key][4];
                var topLevelThirdValue = decodeURIComponent(topLevelMenuSettingDecodedAndParsed[key][3]);
                var topLevelFifthValue = decodeURIComponent(topLevelMenuSettingDecodedAndParsed[key][5]);
                var topLevelMenuCapability = topLevelMenuSettingDecodedAndParsed[key][1];


                //let's see if the icon of the top level menu item is a dashicon or a custom svg
                if(topLevelIcon.indexOf('dashicons-') !== -1) {
                    
                    //ok so the item is a dashicon so let's output this code to render the dashicon
                    var topLevelIconOutput = '<span data="'+topLevelIcon+'" class="menu-item-icon dashicons-before '+topLevelIcon+'"></span>'; 
                    
                } else {
                    
                    //ok so the item is a custom svg icon so let's output this code to render the icon, we need to use the background image in CSS to render the SVG
                    var topLevelIconOutput = '<span data="'+topLevelIcon+'" class="svg svg-menu-icon menu-item-icon" style="background-image: url(&quot;'+topLevelIcon+'&quot;);"></span>';
                    
                }
                

                //let's now output the top level menu item using the variables declared above
                packagedAdminMenuManager += '<li class="menu-item"><div>'+topLevelIconOutput+'<input readonly="readonly" type="text" data="'+topLevelMenuURL+'" class="menu-label" value="'+topLevelMenuLabel+'"><i class="fa fa-pencil-square-o edit-menu-item" title="Edit menu label" aria-hidden="true"></i><input readonly="readonly" type="text" data="'+topLevelMenuURL+'" class="menu-url restricted-advanced-functionality" style="margin-left:20px;" value="'+topLevelMenuURL+'"><i class="restricted-advanced-functionality fa fa-link edit-menu-item-link" title="Edit menu link" aria-hidden="true"></i><input readonly="readonly" type="text" data="'+topLevelClasses+'" class="menu-classes restricted-advanced-functionality" style="margin-left:20px;" value="'+topLevelClasses+'"><i class="restricted-advanced-functionality fa fa-code edit-menu-item-classes" title="Edit menu classes" aria-hidden="true"></i>'+adminCampailitiesSelect(topLevelMenuCapability)+'<input readonly="readonly" type="text" data="'+topLevelThirdValue+'" class="menu-third-value" style="margin-left:20px;" value="'+topLevelThirdValue+'"><input readonly="readonly" type="text" data="'+topLevelFifthValue+'" class="menu-fifth-value" style="margin-left:20px;" value="'+topLevelFifthValue+'"><i class="fa fa-eye-slash remove-menu-item" title="Hide menu item" aria-hidden="true"></i></div>';

                //let's now declare a variable which gets the appropriate sub menu item for this particular top level menu item
                var subLevelObject = subLevelMenuSettingDecodedAndParsed[topLevelMenuURL];
                
                //check if sub leve menus exist otherwise do nothing
                if (subLevelObject != null){

                    packagedAdminMenuManager += '<ul>';
                    //let's loop through each sub menu item for the top level menu item as there could be multiple sub level menu items
                    for (key in subLevelObject) {

                        //declare variables for the label and URL
                        var subLevelMenuLabel = removeNotificationsFromLabels(subLevelObject[key][0]);
                        var subLevelMenuURL = subLevelObject[key][2];
                        var subLevelMenuCapability = subLevelObject[key][1];
                        var subLevelMenuThirdValue = decodeURIComponent(subLevelObject[key][3]);

                        //lets output the sub menu items using our above variables
                        packagedAdminMenuManager += '<li class="menu-item"><div><span data="dashicons-admin-generic" class="menu-item-icon dashicons-before dashicons-admin-generic"></span><input readonly="readonly" type="text" data="'+topLevelMenuURL+'['+subLevelMenuURL+']" class="menu-label" value="'+subLevelMenuLabel+'"><i class="fa fa-pencil-square-o edit-menu-item" title="Edit menu label" aria-hidden="true"></i><input readonly="readonly" type="text" data="'+subLevelMenuURL+'" class="menu-url restricted-advanced-functionality" style="margin-left:20px;" value="'+subLevelMenuURL+'"><i class="restricted-advanced-functionality fa fa-link edit-menu-item-link" title="Edit menu link" aria-hidden="true"></i><input readonly="readonly" type="text" data="menu-top" class="menu-classes restricted-advanced-functionality" style="margin-left:20px;" value="menu-top"><i class="restricted-advanced-functionality fa fa-code edit-menu-item-classes" title="Edit menu classes" aria-hidden="true"></i>'+adminCampailitiesSelect(subLevelMenuCapability)+'<input readonly="readonly" type="text" data="" class="menu-third-value" style="margin-left:20px;" value="'+subLevelMenuThirdValue+'"><input readonly="readonly" type="text" data="" class="menu-fifth-value" style="margin-left:20px;" value=""><i class="fa fa-eye-slash remove-menu-item" title="Hide menu item" aria-hidden="true"></i></div></li>';    
                    }
                    
                    packagedAdminMenuManager += '</ul>';
                }
                
                packagedAdminMenuManager += '</li>';
            }

        }
        $('#admin-menu-manager').append(packagedAdminMenuManager);
        
          
    }
    
    //render the menu on load using the current saved settings
    renderAdminMenuManager($('#wp_custom_admin_interface_top_level_menu').val(), $('#wp_custom_admin_interface_sub_level_menu').val()); 
    
    
    
    
    
    
    
    
    
    
   //lets create our capabilities select
    function adminCampailitiesSelect(existingCapability) {
        
        var adminCapabilities = adminCapabilitiesArray();
        var adminCapabilitiesLength = adminCapabilities.length;
        
        var capabilitySelect = '<select style="margin-left:20px; width: 180px;" disabled="true" class="restricted-advanced-functionality menu-capability">';
        
        for (var i=0; i<adminCapabilitiesLength; i++) {
            
            if(existingCapability == adminCapabilities[i]) {
                capabilitySelect += '<option selected="selected">'+adminCapabilities[i]+'</option>';      
            } else {
                capabilitySelect += '<option>'+adminCapabilities[i]+'</option>';    
            }    
            
        }
        
        capabilitySelect += '</select><i class="restricted-advanced-functionality fa fa-lock edit-menu-capability" title="Edit menu access" aria-hidden="true"></i>';

        return capabilitySelect;    

    }
             
    
    
    
//restore menu to WordPress default
    $('#restore-default-menu').click(function (event) {
    event.preventDefault();  
    
    var confirmation = confirm('Are you sure you want to restore the admin menu to the default WordPress menu? This will delete any customisations made to the menu.');    
    
        if(confirmation == true) {    

            //get variables from button        
            var menu = $('#restore-default-menu').attr('menudata');
            var submenu = $('#restore-default-menu').attr('submenudata');
                        
            // var myNewObject = JSON.parse(menu);
            
            //lets set the setting input with the default WordPress values
            $('#wp_custom_admin_interface_top_level_menu').val(menu);
            $('#wp_custom_admin_interface_sub_level_menu').val(submenu);
            $('#wp_custom_admin_interface_remove_menu_item').val('');


            //now lets render the admin menu manager with the original values
            renderAdminMenuManager(menu,submenu);
            
            //re-assign labels appropriate classes
            assignLabelsAppropriateClasses();
            
            //maintain advanced functionality where appropriate
            setAdvancedFunctionality();

            //lets render a success message
            $('<div class="notice notice-info is-dismissible restore-menu-message"><p>The menu has been successfully restored to the default WordPress menu. Please press "Save All Settings" to save the changes.</p></div>').insertAfter('#admin-menu-manager-buttons');
            
            setTimeout(function() {
                $('.restore-menu-message').slideUp();
            }, 5500);
            
        } 
    });
    
    //restore menu to last save
    $('#restore-last-save').click(function (event) {
    event.preventDefault();  
    
    var confirmation = confirm('Are you sure you want to restore the admin menu to the last save you did? This will delete any edits you have just done.');    
    
        if(confirmation == true) {    

            //get variables from button        
            var menu = $('#restore-last-save').attr('menudata');
            var submenu = $('#restore-last-save').attr('submenudata');
            var removedItems = $('#restore-last-save').attr('removeditems');

            //lets set the setting input with the default WordPress values
            $('#wp_custom_admin_interface_top_level_menu').val(menu);
            $('#wp_custom_admin_interface_sub_level_menu').val(submenu);
            $('#wp_custom_admin_interface_remove_menu_item').val(removedItems);


            //now lets render the admin menu manager with the original values
            renderAdminMenuManager(menu,submenu);
            
            //re-assign labels appropriate classes
            assignLabelsAppropriateClasses();
            
            //maintain advanced functionality where appropriate
            setAdvancedFunctionality();

            //lets render a success message
            $('<div class="notice notice-info is-dismissible restore-menu-message"><p>The menu has been successfully restored to the previous save. Please press "Save All Settings" to save the changes.</p></div>').insertAfter('#admin-menu-manager-buttons');
            
            setTimeout(function() {
                $('.restore-menu-message').slideUp();
            }, 5500);
            
        } 
    });    
    
    
    
    
    
        //add menu item
    $('#poststuff').on("click", "#add-menu-item", function (event) {
        event.preventDefault(); 
        

        $('#admin-menu-manager').prepend('<li class="menu-item menu-item-custom"><div><span data="dashicons-admin-generic" class="menu-item-icon dashicons-before dashicons-admin-generic"></span><input readonly="readonly" type="text" data="" class="menu-label" value="" placeholder="Enter menu label"><i class="fa fa-pencil-square-o edit-menu-item" title="Edit menu label" aria-hidden="true"></i><input readonly="readonly" type="text" data="" class="menu-url" style="margin-left:20px;" value="" placeholder="Enter menu link"><i class="fa fa-link edit-menu-item-link" title="Edit menu link" aria-hidden="true"></i><input readonly="readonly" type="text" data="menu-top added-custom-menu-item" class="menu-classes restricted-advanced-functionality" style="margin-left:20px;" value="menu-top added-custom-menu-item"><i class="restricted-advanced-functionality fa fa-code edit-menu-item-classes" title="Edit menu classes" aria-hidden="true"></i>'+adminCampailitiesSelect('read')+'<input readonly="readonly" type="text" data="" class="menu-third-value" style="margin-left:20px;" value=""><input readonly="readonly" type="text" data="" class="menu-fifth-value" style="margin-left:20px;" value=""><i class="fa fa-eye-slash remove-menu-item" title="Hide menu item" aria-hidden="true"></i><i class="fa fa-trash-o delete-menu-item delete-custom-menu-item" title="Remove menu item" aria-hidden="true"></i></div></li>'); 
        
        //maintain advanced functionality where appropriate
        setAdvancedFunctionality();
        
        
    });
    
    
    //add delete menu item icon to custom icons
    function addTrashIconToCustomMenuItems(){
     
        var targetElements = $('#admin-menu-manager .menu-item div');

        for (var i = 0; i < targetElements.length; ++i) {

            var currentItem = targetElements[i];

            var menuItemClassValue = $(currentItem).find('.menu-classes').val() || "";

            if(menuItemClassValue.indexOf('added-custom-menu-item') !== -1){
                $(currentItem).append('<i class="fa fa-trash-o delete-menu-item delete-custom-menu-item" title="Remove menu item" aria-hidden="true"></i>');
            }
        }    
    }
    //execute on load
    addTrashIconToCustomMenuItems();
    
    
    
    
        //add separator
    $('.wrap').on("click", "#add-separator", function (event) {
        
        event.preventDefault(); 
        
        $('#admin-menu-manager').prepend('<li class="mjs-nestedSortable-no-nesting menu-item"><div class="menu-item-separator"><span class="hr-container"><hr class="separator-rule"></span><i class="fa fa-trash-o delete-menu-item delete-separator" title="Remove separator" aria-hidden="true"></i></div></li>');
        
    });
    
    
    
    
    
    //advanced functionality
    $('.wrap').on("click", "#advanced-menu-functionality", function (event) {
        
        event.preventDefault(); 
        
        if( $('.restricted-advanced-functionality').css('display') == 'inline-block') {
            
            $('.restricted-advanced-functionality').css({"display":"none"});  
            $('#advanced-menu-functionality').html('<i class="fa fa-superpowers" aria-hidden="true"></i> Advanced functionality');
            
        } else {
        
            new ClipboardJS('#advanced-menu-functionality');

            var confirmation = confirm('With great power comes great responsibility! With this option enabled you have the potential to do edits on the default WordPress menu options. But this also means that you may not be able to find your way back here if you start hiding all the standard menus! As a precaution we have copied an emergency URL to your clipboard. So if you get stuck just paste this into the browser and all settings related to this custom admin menu will be deleted so you can start again. This URL can also be found in the FAQ section of the Wordpress plugin website.');    

            if(confirmation == true) {
                $('.restricted-advanced-functionality').css({"display":"inline-block"});
                $('#advanced-menu-functionality').html('<i class="fa fa-universal-access" aria-hidden="true"></i> Simple functionality');
            }
        
        }
        
        
    });
    
    
    
    
    
    
    
    
        //function to check current status of advanced functionality and continue this setting through procedures like restoration and adding of new menus
    function setAdvancedFunctionality(){
        
        if( $('.restricted-advanced-functionality').css('display') == "none") {
            
            $('.restricted-advanced-functionality').css({"display":"none"});  
            
        } else {
            
             $('.restricted-advanced-functionality').css({"display":"inline-block"});     
            
        }
 
    }
    
    
    
    //function to set the default of the advanced functionality to hidden
    function setDefaultStyleForAdvancedFunctionality(){
        $('.restricted-advanced-functionality').css({"display":"none"});       
    }
    setDefaultStyleForAdvancedFunctionality();
    
    
    
    
    //function to force advanced functionality
    function forceAdvancedFunctionality(){
        
        if( $('.restricted-advanced-functionality').css('display') == "none") {
            $('.restricted-advanced-functionality').css({"display":"inline-block"});
            $('#advanced-menu-functionality').html('<i class="fa fa-universal-access" aria-hidden="true"></i> Simple functionality');     
        }
        
    }
    
    
    

    
    
    //remove a menu item
    $('.wrap').on("click", ".delete-menu-item", function () {
        
        var confirmation = confirm('Are you sure you want to delete this menu item?');    
    
        if(confirmation == true) {  
            
            $(this).parent().parent().remove(); 

        }
    });
    
    
    
    
        //make input field editable
    $('.wrap').on("click", ".edit-menu-item", function () {
    
        var currentStateReadOnly = $(this).prev().prop('readonly');
        
        if(currentStateReadOnly == true) {
            $(this).prev().prop('readonly',false);
            $(this).removeClass("fa-pencil-square-o");
            $(this).addClass("fa-check");
            
        } else {
            $(this).prev().prop('readonly',true);
            $(this).addClass("fa-pencil-square-o");
            $(this).removeClass("fa-check");
        }
    });
    
    
    //make input field url editable
    $('.wrap').on("click", ".edit-menu-item-link", function () {
    
        var currentStateReadOnly = $(this).prev().prop('readonly');
        
        if(currentStateReadOnly == true) {
            $(this).prev().prop('readonly',false);
            $(this).removeClass("fa-link");
            $(this).addClass("fa-check");
            
        } else {
            $(this).prev().prop('readonly',true);
            $(this).addClass("fa-link");
            $(this).removeClass("fa-check");
        }
    });
    
    
    //make input field classes editable
    $('.wrap').on("click", ".edit-menu-item-classes", function () {
    
        var currentStateReadOnly = $(this).prev().prop('readonly');
        
        if(currentStateReadOnly == true) {
            $(this).prev().prop('readonly',false);
            $(this).removeClass("fa-code");
            $(this).addClass("fa-check");
            
        } else {
            $(this).prev().prop('readonly',true);
            $(this).addClass("fa-code");
            $(this).removeClass("fa-check");
        }
    });
    
    //make input field capability editable
    $('.wrap').on("click", ".edit-menu-capability", function () {
    
        var currentStateReadOnly = $(this).prev().prop('disabled');
        
        if(currentStateReadOnly == true) {
            $(this).prev().prop('disabled',false);
            $(this).removeClass("fa-lock");
            $(this).addClass("fa-check");
            
        } else {
            $(this).prev().prop('disabled',true);
            $(this).addClass("fa-lock");
            $(this).removeClass("fa-check");
        }
    });
    
    
    
    
        //code to add and remove items from input when clicking the hide icon

    $('.wrap').on("click", ".remove-menu-item", function () {
        
        //get the name of the menu item
        var menuItemContainer = $(this).parent().parent();
        
        if($(menuItemContainer).hasClass('removed-menu-item')){
            $(menuItemContainer).removeClass("removed-menu-item");    
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
        } else {
            $(menuItemContainer).addClass("removed-menu-item");
            $(this).addClass("fa-eye");
            $(this).removeClass("fa-eye-slash");       
        }
        
    });
    
    
    //on load assign appropriate classes
    //for each menu item check if in array, and if in array add class
    function assignLabelsAppropriateClasses() {
        
        var removeMenuItems = $('#wp_custom_admin_interface_remove_menu_item').val();

        if (removeMenuItems != null) {
            var removeMenuItemsArray = removeMenuItems.split(',');
        }
        
        $('.menu-label').each(function( index ) {
            var menuItemName = $(this).attr('data'); 
            var menuItemContainer = $(this).parent().parent();
            var menuIcon = $(this).parent().find('.remove-menu-item');
            
//            if(menuItemName.length < 1){} else {
                if ($.inArray(menuItemName, removeMenuItemsArray) != -1) {
                    $(menuItemContainer).addClass("removed-menu-item");
                    $(menuIcon).addClass("fa-eye");
                    $(menuIcon).removeClass("fa-eye-slash");
                } else {
                    $(menuItemContainer).removeClass("removed-menu-item");
                    $(this).removeClass("fa-eye");
                    $(this).addClass("fa-eye-slash");      
                } 
//            }
        });
    }
    //execute function on load
    assignLabelsAppropriateClasses();

    
    
      //make icon show a tooltip
    //on click show the dialog, if already open close it
    $('.wrap').on("click", ".menu-item-icon", function () { 
                
        var originalIcon = this;
        
        
        if($('#custom-icon-dialog').hasClass('ui-dialog-content') &&  $('#custom-icon-dialog').dialog('isOpen')) {
            
            $( "#custom-icon-dialog" ).dialog("close");
            
        } else {
        
        $( "#custom-icon-dialog" ).dialog({
            
            modal: true,
            draggagle: true,
            width: 700,
            open: function ()
            {
            $('.ui-dialog-titlebar-close').blur();
            $('.wp_custom_admin_interface_media_upload_button').blur();
            $(this).unbind('click');
            }
            }); 
        
            

            //when selecting a new icon replace the existing icon and close the dialog
            $('#custom-icon-dialog').on("click", ".icon-for-selection", function () { 
                
                var selectedIconData = $(this).attr('data');
                
                if(selectedIconData.indexOf('dashicons-') !== -1) {
                    //if icon is a dashicon remove existing classes and add new classes
                    $(originalIcon).parent().prepend('<span data="'+selectedIconData+'" class="menu-item-icon dashicons-before '+selectedIconData+'"></span>');     
                    $(originalIcon).remove();
   
                } else {
                    $(originalIcon).parent().prepend('<span data="'+selectedIconData+'" class="svg svg-menu-icon menu-item-icon" style="background-image: url(&quot;'+selectedIconData+'&quot;)"></span>');     
                    $(originalIcon).remove();
                }
                
                
                $( "#custom-icon-dialog" ).dialog("close");

            });
            
            
            
            //when uploading a custom icon
            $('#custom-icon-dialog').on("click",".wp_custom_admin_interface_media_upload_button", function(e){
                e.preventDefault();


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

                    $(originalIcon).parent().prepend('<span data="'+image_url+'" class="svg svg-menu-icon menu-item-icon" style="background-image: url(&quot;'+image_url+'&quot;)"></span>');     
                    $(originalIcon).remove();
                    $( "#custom-icon-dialog" ).dialog("close");
                        

                });
            });
            

            
        }
        

    });


    //add sortable functionality
    $('#admin-menu-manager').nestedSortable({
			handle: 'div',
			items: 'li',
			toleranceElement: '> div',
            maxLevels: 2,
            listType: 'ul',
            isTree: true
	});  
    
    
    
    
       //function to create an array containing admin capabilities
    function adminCapabilitiesArray(){
        
       var adminCapabilities = $('#admin-capabilities').text(); 
                
        if (adminCapabilities != null) {
            var adminCapabilitiesArray = adminCapabilities.split(',');
        }
                
        return adminCapabilitiesArray;
        
    }
     
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        // ******************************* PRESAVE ROUTINE ***************************//
    $('#custom_admin_interface_settings_form').submit(function(event) { 
    
    event.preventDefault();
    $('.settings-loading-message').remove();
        
    //show loading message
    $('<div class="notice notice-warning is-dismissible settings-loading-message"><p><i class="fa fa-circle-o-notch wp-custom-admin-interface-loading" aria-hidden="true"></i> Please wait while we save the settings...</p></div>').insertAfter('.wp-custom-admin-interface-save-button');
        
        
    //OPERATION ONE, LETS RELABEL THE DATA ATTRIBUTES OF HIDDEN MENU ITEMS AND ADD THE ITEMS TO THE ITEMS TO BE HIDDEN SETTING    
    //lets declare a variable that will hold all our new values
    var itemsToBeHidden = '';    
       
    //first lets target the top level data attributes which need to be relabeled
    $('#admin-menu-manager > .removed-menu-item > div').each(function(index) {
        var removedItemsURL = $(this).find('.menu-url').val(); 
        
        $(this).find('.menu-label').attr('data',removedItemsURL);
        itemsToBeHidden += removedItemsURL+',';
        
    });
                                                       
    //second lets target the sub level data attributes which need to be relabeled
    $('#admin-menu-manager > li > ul > .removed-menu-item').each(function(index) {
        var removedItemsURL = $(this).find('.menu-url').val(); 
        var parentItemsURL = $(this).parent().prev().find('.menu-label').attr('data');
        var newDataValue = parentItemsURL+'['+removedItemsURL+']';
        $(this).find('.menu-label').attr('data',newDataValue); 
        itemsToBeHidden += newDataValue+',';
    });
    
    //let's set the new value
    $('#wp_custom_admin_interface_remove_menu_item').val(itemsToBeHidden); 
         
        
     
        
     
        
    //OPERATION TWO, HERE WE ARE GOING TO CHECK FOR DUPLICATES IN THE TOP LEVEL MENU
    //lets remove any previous error classes
    $('.duplication-error').removeClass('duplication-error');     
        
    //lets create an array whcih will hold our top level data attributes
    var topLevelMenuURLArray = [];  
        
    //lets cycle through all top level menu items
    $('#admin-menu-manager > .menu-item > div').each(function() {
        var removedItemsURL = $(this).find('.menu-url').val(); 

        topLevelMenuURLArray.push(removedItemsURL);
        
    });
    

    //now lets check for duplicates in array    
    var topLevelMenuURLSortedArray = topLevelMenuURLArray.slice().sort();
    
    //create an array to hold duplicates    
    var topLevelMenuURLDuplicates = [];
    
    //for each item in the original array push the duplicates into the new array    
    for (var i=0; i < topLevelMenuURLArray.length -1; i++) {
        
        if (topLevelMenuURLSortedArray[i + 1] == topLevelMenuURLSortedArray[i]) {
            
        if(topLevelMenuURLSortedArray[i] != null){    
        topLevelMenuURLDuplicates.push(topLevelMenuURLSortedArray[i]);
        }
        }    
        
    }   
        
    if(topLevelMenuURLDuplicates.length > 0) {
        
        var errors = true;
        
        alert('We found there were 2 or more items in the top level of your menu that have the same destination URL. This can cause unexpected results. As a result we won\'t save the settings until the issue is corrected. We have highlighted these items red. Please change one of the URL\'s or delete one of the menu items.');
        
        $.each(topLevelMenuURLDuplicates,function(key,value) {
        
            var duplicatedItem = value;
            
            $('#admin-menu-manager > .menu-item > div').each(function() {
                
                var removedItemsURL = $(this).find('.menu-url').val();
                var removedItemsURLField = $(this).find('.menu-url');
                
                if (removedItemsURL == duplicatedItem) {
                    //add a class to highlight the errors
                    $(removedItemsURLField).addClass('duplication-error');
                    //force the advanced functionality so people can actually see the URL field
                    forceAdvancedFunctionality();
                }
                
             });
            
        });
        
        
    } else {

        var errors = false;
        
    }    
        

        

    //OPERATION THREE, MAKE SURE EVERY MENU ITEM HAS A URL    
        
    //lets remove any previous error classes
    $('.no-url-value').removeClass('no-url-value');    
    
    //lets declare a variable which will contain the error count    
    var noURLCount = 0;      
        
    $('#admin-menu-manager .menu-url').each(function() {
        
        var urlValue = $(this).val(); 
        
        if(urlValue == ""){
            
            $(this).addClass('no-url-value');
            noURLCount++;
        }
         
    });   
    
    if(noURLCount >0){
        
        alert('We found that some of your menu items have no URL. Please make sure every item has a URL. As a result we won\'t save the settings until the issue is corrected. We have highlighted these items red.');
        
        errors = true;
        forceAdvancedFunctionality();    
    }    
        

        
        
        
        
        
        
    //OPERATION FOUR, CREATE ARRAY WHICH WILL SET THE SETTING FOR THE TOP LEVEL MENU
    

    //lets do the top menu    
    var topLevelMenuArray = [];
    
        
    //variable to hold our random numbers which is used as part of the id for separators    
    var startCount = 0;
       
        
    $('#admin-menu-manager > li').each(function( index ) {
        

        
        
        //for normal menu items
        //item 0
        var topLevelMenuItemLabel = $(this).find('.menu-label').val();
        //item 1
        var topLevelMenuItemCapability = $(this).find('.menu-capability').val();
        //item 2
        var topLevelMenuItemLink = $(this).find('.menu-url').val();
        //item 3
        var topLevelMenuItemThird = encodeURIComponent($(this).find('.menu-third-value').val()).replace(/%20/g, " ");
        //item 4
        var topLevelMenuItemClasses = $(this).find('.menu-classes').val();
        //item 5    
        var topLevelMenuItemFifth = encodeURIComponent($(this).find('.menu-fifth-value').val()).replace(/%20/g, " ");
        //item 6
        var topLevelMenuItemIcon = $(this).find('.menu-item-icon').attr('data');
        
        
        //for separators
        //item 0
        var separatorMenuItemZero = '';
        //item 1
        var separatorMenuItemOne = 'read';
        //item 2
        var separatorMenuItemTwo = 'separator-'+startCount;
        startCount ++;
        //item 3
        var separatorMenuItemThree = '';
        //item 4
        var separatorMenuItemFour = 'wp-menu-separator';
        
        
        
        if(topLevelMenuItemLabel == null) {
            
            var topLevelMenuItemArray = [separatorMenuItemZero,separatorMenuItemOne,separatorMenuItemTwo,separatorMenuItemThree,separatorMenuItemFour];
            
            
        } else {
            
            var topLevelMenuItemArray = [topLevelMenuItemLabel,topLevelMenuItemCapability,topLevelMenuItemLink,topLevelMenuItemThird,topLevelMenuItemClasses,topLevelMenuItemFifth,topLevelMenuItemIcon];
                        
        }
        
        topLevelMenuArray.push(topLevelMenuItemArray);
        
    });
    
    var stringifiedAndEncodedTopLevelMenuArray = JSON.stringify(topLevelMenuArray);    
    $('#wp_custom_admin_interface_top_level_menu').val(stringifiedAndEncodedTopLevelMenuArray);    
        
//    console.log(stringifiedAndEncodedTopLevelMenuArray);
        
    
    
        
    //OPERATION FIVE, REMOVE ANY HIDDEN SEPARATORS IN THE THE SUB MENU    
        
    //lets delete any sneaky separators which may be hidden amongst the sub items     
    $('#admin-menu-manager > li > ul > .mjs-nestedSortable-no-nesting').remove();    
        
        
        
    //OPERATION SIX, CREATE ARRAY WHICH WILL SET THE SETTING FOR THE SUB LEVEL MENU     
    //lets do the sub menu     
    var subLevelMenuObjectContainer = {};    
        
    $('#admin-menu-manager > li > ul').each(function( index ) {
        
        
        
        
        var associatedTopLevelMenuItemLabel = $(this).parent().find('.menu-url').val();
        
        var $this = $(this);
        var $subLevelUl = $(this).find("li");
        
        var subLevelMenuObject = {};
        
        $($subLevelUl).each(function( index ) {
            
            //item 0 -label
            var subLevelMenuItemLabel = $(this).find('.menu-label').val(); 
            //item 1 - permissions
            var subLevelMenuItemCapability = $(this).find('.menu-capability').val();
            //item 2 - url
            var subLevelMenuItemLink = $(this).find('.menu-url').val();
            //item 3 - unknown
            var subLevelMenuItemThird = encodeURIComponent($(this).find('.menu-third-value').val()).replace(/%20/g, " ");
            
            
            if(subLevelMenuItemThird == "undefined") {
                
                subLevelMenuItemArray = [subLevelMenuItemLabel,subLevelMenuItemCapability,subLevelMenuItemLink];
                  
            } else {
                
                subLevelMenuItemArray = [subLevelMenuItemLabel,subLevelMenuItemCapability,subLevelMenuItemLink,subLevelMenuItemThird];
                
            }
            
            subLevelMenuObject[index] = subLevelMenuItemArray; 
            
        }); 
        
        subLevelMenuObjectContainer[associatedTopLevelMenuItemLabel] = subLevelMenuObject;
        
    });    
    
        
    var stringifiedAndEncodedSubLevelMenuObject = JSON.stringify(subLevelMenuObjectContainer);    
    $('#wp_custom_admin_interface_sub_level_menu').val(stringifiedAndEncodedSubLevelMenuObject);     
        
//     console.log(subLevelMenuObjectContainer);   
        
     
      
  
    //OPERATION SEVEN, GRAB ALL EXCEPTIONS/INCLUSIONS AND ADD THEM TO THE SETTING FIELD     
    //grab all exceptions/inclusions and add them to the exclusion setting field
           
    $('.userAndRoleSelection').each(function() {
        
        
        var newExceptions = '';

        var nextContainer = $(this).next().next();
        
        $.each(nextContainer.find('select'),function() {
        
            var exceptionCaseValue = $(this).val();

            newExceptions += exceptionCaseValue+',';

        });
        
        nextContainer.find('.saved_exception_cases').val(newExceptions);
        
          
        
    });
        
    
        
        
    
        
        
        if(errors == false){
        
        //run ajax to clear the transients
        var data = {
            'action': 'delete_transients'
        };

        jQuery.post(ajaxurl, data, function (response) {
            //we don't need to do anything
        });
        
        
        
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
        
        } 

        
        
        

        });
    
    
    
    
    
    
    
        
  
    
    
    
    
});