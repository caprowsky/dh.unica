jQuery(document).ready(function ($) {
    

    
       // ******************************* CUSTOMISE TOOLBAR MENU PAGE ***************************//
    

    
    //function to render the admin menu manager taking the menu and submenu parameters given to it to build out the menu
    function renderToolbarMenuManager (menu) {
        
        //lets remove all items inside existing div (if they should exist), this is used when restoring the menu from the last save or loading the default WordPress menu
        $('#toolbar-menu-manager').empty();
        
        //get the inputs and put it into JSON format so we can play with it later


        if (menu.indexOf("{") != -1) {
            var toolbarMenuSettingDecodedAndParsed = JSON.parse(menu);
        } else {
            var toolbarMenuSettingDecodedAndParsed = JSON.parse(atob(menu));    
        }


        
        
        console.log(toolbarMenuSettingDecodedAndParsed);
        
        var listArray = [];
        
        do {
            
            processNodes(toolbarMenuSettingDecodedAndParsed);
            
        var countOfNodesInData = 0;
        var countOfItemsInArray = 0;
        

        for(node in toolbarMenuSettingDecodedAndParsed){
            
            countOfNodesInData++; 
            
            var nodeId = toolbarMenuSettingDecodedAndParsed[node]['id'];

            if($.inArray(nodeId,listArray) >= 0){

                countOfItemsInArray++;    

            }
            
        }
              
        } while (countOfNodesInData !== countOfItemsInArray);
        
        
        
        
        
        var listOutput = listArray.join('');

        $('#toolbar-menu-manager').append(listOutput);

        function processNodes(data){

                    
            for(node in data){
                //declare standard variables
                var nodeId = data[node]['id'];
                var nodeTitleOriginal = data[node]['title'];
                var nodeTitle = (""+nodeTitleOriginal).replace(/\'/g, "\"");
                var noteTitleString = nodeTitle;
                if(nodeTitle.indexOf('<') !== -1){
                    //it contains HTML elements so we need to strip the elements    
                    var nodeTitle = $("<div/>").html(nodeTitle).text()+'<title-not-editable>';   
                }   
                
                var nodeParent = data[node]['parent'];
                var nodeHref = data[node]['href'];
                var nodeGroup = data[node]['group'];
                var nodeMeta = data[node]['meta'];
                
                
                var titleInput = '<input style="font-weight:bold;" title="'+nodeId+'" readonly="readonly" type="text" class="node-title" value=\''+nodeTitle+'\'>';
                
                if(noteTitleString.indexOf('<') !== -1){} else { 
                    titleInput += '<i class="fa fa-pencil-square-o edit-node-title" title="Edit menu title" aria-hidden="true"></i>';  
                }
                
                var hrefInput = '<input style="margin-left: 20px;" readonly="readonly" type="text" class="node-href" value="'+nodeHref+'"><i class="fa fa-link edit-node-link" title="Edit menu link" aria-hidden="true" style="display: inline-block;"></i>';
                var removeItem = '<i class="fa fa-eye-slash remove-node-item" title="Hide menu item" aria-hidden="true"></i>';
                
                
                
                //check if the item isn't already in the array
                if(listArray.indexOf(nodeId) == -1) {
                    //check if item is a parent and if so add the item to the array
                    if(nodeParent == false) {
                        listArray.push('<li><div data-group="'+nodeGroup+'"><span data="'+nodeId+'" class="node-id" style="display:none;">');
                        listArray.push(nodeId);
                        listArray.push('</span>'+titleInput+hrefInput+removeItem+'</div>');
                        listArray.push('</li>');
                    } else {
                        //item isnt a parent
                        //check if the items parent is in the array and if so add it to the array
                        if(listArray.indexOf(nodeParent) != -1){
                                                        
                            var positionInArray = listArray.indexOf(nodeParent);
                            //we need to find the position of the closing ul for when appending list items to existing uls
                            var positionOfClosingUl = listArray.indexOf('</ul>',positionInArray);

                            //we need to check if the parent item already has a ul container i.e. it already has a child list item
                            if(listArray[positionInArray+2]=='<ul>'){
                                //item already has a ul container
                                listArray.splice(positionOfClosingUl+0,0,'<li><div data-group="'+nodeGroup+'"><span class="node-id" data="'+nodeId+'" style="display:none;">');
                                listArray.splice(positionOfClosingUl+1,0,nodeId);
                                listArray.splice(positionOfClosingUl+2,0,'</span>'+titleInput+hrefInput+removeItem+'</div>');
                                listArray.splice(positionOfClosingUl+3,0,'</li>');
                            } else {
                                //item doesn't have a ul container so lets create it 
                                listArray.splice(positionInArray+2,0,'<ul>');
                                listArray.splice(positionInArray+3,0,'<li><div data-group="'+nodeGroup+'"><span class="node-id" data="'+nodeId+'" style="display:none;">');
                                listArray.splice(positionInArray+4,0,nodeId);
                                listArray.splice(positionInArray+5,0,'</span>'+titleInput+hrefInput+removeItem+'</div>');
                                listArray.splice(positionInArray+6,0,'</li>');
                                listArray.splice(positionInArray+7,0,'</ul>');
                            }

                        } 

                    }
                
                }
                
            }
             
        }
    
    }
    
    //render the menu on load using the current saved settings
    renderToolbarMenuManager($('#wp_custom_admin_interface_primary_toolbar_menu').val()); 
    
    
    //add sortable functionality
    $('#toolbar-menu-manager').nestedSortable({
			handle: 'div',
			items: 'li',
			toleranceElement: '> div',
            listType: 'ul',
            isTree: true
	});
    
    
    //make input field editable
    $('.wrap').on("click", ".edit-node-title", function () {
    
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
    $('.wrap').on("click", ".edit-node-link", function () {
    
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //code to add and remove items from input when clicking the hide icon

    $('.wrap').on("click", ".remove-node-item", function () {
        
        //get the name of the menu item
        var menuItemContainer = $(this).parent();
        
        if($(menuItemContainer).hasClass('removed-node-item')){
            $(menuItemContainer).removeClass("removed-node-item");    
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
        } else {
            $(menuItemContainer).addClass("removed-node-item");
            $(this).addClass("fa-eye");
            $(this).removeClass("fa-eye-slash");       
        }
        
    });
    
    
    //on load assign appropriate classes
    //for each menu item check if in array, and if in array add class
    function assignNodesAppropriateClasses() {
        
        var removeNodeItems = $('#wp_custom_admin_interface_remove_toolbar_item').val();

        if (removeNodeItems != null) {
            var removeMenuNodesArray = removeNodeItems.split(',');
        }
        
        $('#toolbar-menu-manager li > div').each(function( index ) {
            
            var menuNodeContainer = $(this);
            var menuNodeName = $(this).find('.node-id').attr('data'); 
            var menuNodeIcon = $(this).parent().find('.remove-node-item');
            

                if ($.inArray(menuNodeName, removeMenuNodesArray) != -1) {
                    $(menuNodeContainer).addClass("removed-node-item");
                    $(menuNodeIcon).addClass("fa-eye");
                    $(menuNodeIcon).removeClass("fa-eye-slash");
                } else {
                    $(menuNodeContainer).removeClass("removed-node-item");
                    $(menuNodeIcon).removeClass("fa-eye");
                    $(menuNodeIcon).addClass("fa-eye-slash");      
                } 

        });
    }
    //execute function on load
    assignNodesAppropriateClasses();
    
    
    
    
    //add node item
    $('#poststuff').on("click", "#add-node-item", function (event) {
        event.preventDefault(); 
        
        function newNodeIdGenerator(){
            
            var prefix = 'unique-node-';
            var prefixLength = prefix.length;
            
            
            var existingNodes = [];
            
            $('#toolbar-menu-manager .node-id').each(function( index ) {
                
                var nodeId = $(this).attr('data');
                var nodeIdLength = nodeId.length;
                
                
                if(nodeId.indexOf(prefix) !== -1) {
                    var numberComponentOfNodeId = nodeId.substr(prefixLength, nodeIdLength-prefixLength);
                    
                    existingNodes.push(parseInt(numberComponentOfNodeId)); 
                }
                
            });
            
            
            if(existingNodes.length == 0){
                var largestNumber = 1;    
            } else {
                
                var largestNumber = existingNodes[0];
                
                for (var i = 0; i < existingNodes.length; i++) {
                    if (largestNumber < existingNodes[i] ) {
                        largestNumber = existingNodes[i];
                    }
                }
                
                largestNumber++;
  
            }
   
            return prefix+largestNumber;    
        }
        
        var uniqueNodeId = newNodeIdGenerator();
        
        
        $('#toolbar-menu-manager').prepend('<li class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"><div data-group="false" class="ui-sortable-handle"><span class="node-id" data="'+uniqueNodeId+'" style="display:none;">'+uniqueNodeId+'</span><input style="font-weight:bold;" title="" readonly="readonly" type="text" class="node-title" value=""><i class="fa fa-pencil-square-o edit-node-title" title="Edit menu title" aria-hidden="true"></i><input style="margin-left: 20px;" readonly="readonly" type="text" class="node-href" value=""><i class="fa fa-link edit-node-link" title="Edit menu link" aria-hidden="true" style="display: inline-block;"></i><i class="fa fa-eye-slash remove-node-item" title="Hide menu item" aria-hidden="true"></i><i class="fa fa-trash-o delete-node-item delete-custom-node-item" title="Remove menu item" aria-hidden="true"></i></div></li>'); 
    
    });
    
    
    //remove a node item
    $('.wrap').on("click", ".delete-node-item", function () {
        
        var confirmation = confirm('Are you sure you want to delete this menu item?');    
    
        if(confirmation == true) {  
            
            $(this).parent().parent().remove(); 

        }
    });
    
    
    //add trash icon on load
    //add delete menu item icon to custom icons
    function addTrashIconToCustomMenuNodes(){
     
        var targetElements = $('#toolbar-menu-manager .node-id');

        for (var i = 0; i < targetElements.length; ++i) {

            var currentItem = targetElements[i];
            var currentItemParent = $(currentItem).parent();

            var nodeIdValue = $(currentItem).attr('data');

            if(nodeIdValue.indexOf('unique-node-') !== -1){
                $(currentItemParent).append('<i class="fa fa-trash-o delete-node-item delete-custom-node-item" title="Remove menu item" aria-hidden="true"></i>');
            }
        }    
    }
    //execute on load
    addTrashIconToCustomMenuNodes();
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //restore menu to WordPress default toolbar
    $('#restore-default-toolbar').click(function (event) {
    event.preventDefault();  
    
    var confirmation = confirm('Are you sure you want to restore the toolbar menu to the default WordPress toolbar? This will delete any customisations made to the menu.');    
    
        if(confirmation == true) {    

            //get variables from button        
            var menu = $('#restore-default-toolbar').attr('toolbardata');
                    
            //lets set the setting input with the default WordPress values
            $('#wp_custom_admin_interface_primary_toolbar_menu').val(menu);
            $('#wp_custom_admin_interface_remove_toolbar_item').val('');


            //now lets render the admin menu manager with the original values
            renderToolbarMenuManager(menu);
            
            //re-assign labels appropriate classes
            assignNodesAppropriateClasses();
            

            //lets render a success message
            $('<div class="notice notice-info is-dismissible restore-menu-message"><p>The toolbar has been successfully restored to the default WordPress toolbar. Please press "Save All Settings" to save the changes.</p></div>').insertAfter('#admin-toolbar-manager-buttons');
            
            setTimeout(function() {
                $('.restore-menu-message').slideUp();
            }, 5500);
            
        } 
    });
    
    //restore menu to last save
    $('#restore-last-save-toolbar').click(function (event) {
    event.preventDefault();  
    
    var confirmation = confirm('Are you sure you want to restore the toolbar menu to the last save you did? This will delete any edits you have just done.');    
    
        if(confirmation == true) {    

            //get variables from button        
            var menu = $('#restore-last-save-toolbar').attr('toolbardata');
            var removedItems = $('#restore-last-save-toolbar').attr('removeditems');

            //lets set the setting input with the default WordPress values
            $('#wp_custom_admin_interface_primary_toolbar_menu').val(menu);
            $('#wp_custom_admin_interface_remove_toolbar_item').val(removedItems);


            //now lets render the admin menu manager with the original values
            renderToolbarMenuManager(menu);
            
            //re-assign labels appropriate classes
            assignNodesAppropriateClasses();

            //lets render a success message
            $('<div class="notice notice-info is-dismissible restore-menu-message"><p>The toolbar has been successfully restored to the previous save. Please press "Save All Settings" to save the changes.</p></div>').insertAfter('#admin-toolbar-manager-buttons');
            
            setTimeout(function() {
                $('.restore-menu-message').slideUp();
            }, 5500);
            
        } 
    });   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        // ******************************* PRESAVE ROUTINE ***************************//
    $('#custom_admin_interface_settings_form').submit(function(event) { 
    
    event.preventDefault();
    $('.settings-loading-message').remove();
    
    //show loading message
    $('<div class="notice notice-warning is-dismissible settings-loading-message"><p><i class="fa fa-circle-o-notch wp-custom-admin-interface-loading" aria-hidden="true"></i> Please wait while we save the settings...</p></div>').insertAfter('.wp-custom-admin-interface-save-button');
        
        
  
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
        
    
        

        
    //OPERATION EIGHT, LETS GET THE HIDDEN NODES FOR THE TOOLBAR AND ADD THEM TO THE SETTING   
    //lets declare a variable that will hold all our new values
    var nodesToBeHidden = '';    
       
    $('#toolbar-menu-manager li > div').each(function(index) {
        
        
        if($(this).hasClass('removed-node-item')){
        
        var removedNodeId = $(this).find('.node-id').attr('data'); 
                
        nodesToBeHidden += removedNodeId+',';
            
        }
        
    });
                                                       
    //let's set the new value
    $('#wp_custom_admin_interface_remove_toolbar_item').val(nodesToBeHidden);     
        
        
        
        
        
        
        
        
        
        //OPERATION NINE - LES SAVE THE TOOLBAR MENU AND PUT THE VALUE INTO THE SETTING
        var nodeObjects = {};

        //for each list item create the objects

        $('#toolbar-menu-manager li > div').each(function( index ) {

            var containerDiv = $(this);

            var nodeGroup = (containerDiv.attr('data-group') === "true");
            var nodeHref = containerDiv.find('.node-href').val();
            
            if(nodeHref == ""){
               nodeHref = false; 
            }
            
            
            var nodeId = containerDiv.find('.node-id').attr('data');
            var nodeMeta = [];
            var nodeParent = containerDiv.parent().parent().prev().find('.node-id').attr('data');
            if(nodeParent == null){
               nodeParent = false;   
            }
            
            var nodeTitle = containerDiv.find('.node-title').val();
            if(nodeTitle == ""){
               nodeTitle = false; 
            }
            
            
            var nodeObject = {group: nodeGroup, href: nodeHref, id: nodeId, meta: nodeMeta, parent: nodeParent, title: nodeTitle}
            
            //add the items to the object
            nodeObjects[nodeId] = nodeObject;
            
        });
        
//        console.log(nodeObjects);
        
        var stringifiedAndEncodedToolbarMenuObject = JSON.stringify(nodeObjects);    
        $('#wp_custom_admin_interface_primary_toolbar_menu').val(stringifiedAndEncodedToolbarMenuObject);   
        
        
        
        
        
        
        
        
        
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

        
 
        
        
        

        });
    
    
    
    
});