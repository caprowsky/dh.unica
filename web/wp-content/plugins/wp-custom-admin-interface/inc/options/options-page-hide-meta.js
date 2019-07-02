jQuery(document).ready(function ($) {
    
    
    
    //select/deselect all functionality
    $('.wrap').on("click", "#select-all-items", function (event) {
        event.preventDefault();
        
        var allItems = '';
        
        
        $('.meta-item').each(function(index) {
            
            var hiddenmetas = $('#wp_custom_admin_interface_hide_this_meta').val('');
            
            var metaPath = $(this).find('#meta-name').attr('data');
            
            allItems += ','+metaPath;
            
            
            $(this).addClass("hidden-meta-item");
            $(this).find('.remove-meta-item').addClass("fa-eye");
            $(this).find('.remove-meta-item').removeClass("fa-eye-slash");   
 
        });
        
        $('#wp_custom_admin_interface_hide_this_meta').val(allItems);
        
        
    });
    
    $('.wrap').on("click", "#deselect-all-items", function (event) {
        event.preventDefault();

        $('.meta-item').each(function(index) {
            
            var hiddenmetas = $('#wp_custom_admin_interface_hide_this_meta').val('');
            
            $(this).removeClass("hidden-meta-item");
            $(this).find('.remove-meta-item').removeClass("fa-eye");
            $(this).find('.remove-meta-item').addClass("fa-eye-slash");   
 
        });
    });
    
    

    //code to add and remove items from input when clicking the hide icon

    function createListingOfMetaBoxes(){
        
        
        var hiddenMeta = $('#wp_custom_admin_interface_hide_this_meta').val();
        
        var hiddenMetaRemoveFirstCharacter = hiddenMeta.substring(1);
        
        if (hiddenMeta != null) {
            var hiddenMetaArray = hiddenMetaRemoveFirstCharacter.split(',');
        }

        
        var postTypesAndIds = $('#post-types-and-ids').attr('data');
        
        var postTypesAndIdsSplit = postTypesAndIds.split(',');
        
        postTypesAndIdsSplit.unshift('dashboard|dashboard');
        
                
        $.each(postTypesAndIdsSplit,function(index,value) {
            
            var typeAndId = value;
                        
            var positionOfPipe = typeAndId.indexOf("|");
            
            var postType = typeAndId.substr(0,positionOfPipe);
            
            
            function ucwords(str,force){
              str=force ? str.toLowerCase() : str;  
              return str.replace(/(\b)([a-zA-Z])/g,
                   function(firstLetter){
                      return firstLetter.toUpperCase();
                   });
            }
            
            var removeUnderScoresFromPostType = postType.replace(/_/g, " ");
            
            
            var fullLength = typeAndId.length;
            
            var postID = typeAndId.substr(positionOfPipe+1,fullLength);
            
            var currentPageUrl = window.location.href;
            
            
            
            var positionOfAdmin = currentPageUrl.indexOf('admin.php?');
            
            var firstPartOfUrl = currentPageUrl.substr(0,positionOfAdmin);
            
            
            if(postID == 'dashboard'){
                var href = firstPartOfUrl+'index.php';    
            } else {
                var href = firstPartOfUrl+'post.php?post='+postID+'&action=edit';    
            }
            
            
        
            $.ajax({
                url: href,
                type:'GET',
//                async: false,
                success: function(data){
                    
                    var outputData = '';
                    outputData += '<h3>'+ucwords(removeUnderScoresFromPostType)+' Meta Boxes</h3>';
                    outputData += '<ul style="margin-bottom: 45px;">';
                    
                    var content = $(data).find('#adv-settings').html();

                    var contentParsed = $.parseHTML(content);

                    var justMetaBoxPrefs = contentParsed[1].innerHTML;

                    var justMetaBoxPrefsParsed = $.parseHTML(justMetaBoxPrefs); 
                    
                    
                
                    
                    //here we are cycling through our hidden items we can no longer attain through an ajax request
                    $.each(hiddenMetaArray,function(index,value) {
                        
                        
                        var lengthOfPostType = postType.length;
                        
                        var firstSectionOfValue = value.substr(0,lengthOfPostType);            
                        
                        if(postType == firstSectionOfValue) {
            
                            var positionOfSinglePipe = value.indexOf("|");
                            var positionOfDoublePipe = value.indexOf("||");
                            var lengthOfValue = value.length;


                            var addedId = value.substr(positionOfSinglePipe+1,positionOfDoublePipe-positionOfSinglePipe-1);
                            var addedType = value.substr(0,positionOfSinglePipe);
                            var addedName = value.substr(positionOfDoublePipe+2,lengthOfValue);

                            outputData += '<li class="meta-item"><div><i class="fa fa-eye-slash remove-meta-item" title="Hide meta" aria-hidden="true"></i><span id="meta-name" style="font-weight: bold;" data="'+addedType+'|'+addedId+'||'+addedName+'">'+addedName+'</span></div></li>';
            

                        }

                    });

                    
                    //here we are cycling through the ajax items
                    $.each(justMetaBoxPrefsParsed,function(key,value) {


                        var itemType = value.toString();


                        if(itemType == '[object HTMLLabelElement]'){

                            var metaId = $(value).find('input').val(); 
                            var metaName = $(value).text();
                            
                            outputData += '<li class="meta-item"><div><i class="fa fa-eye-slash remove-meta-item" title="Hide meta" aria-hidden="true"></i><span id="meta-name" style="font-weight: bold;" data="'+postType+'|'+metaId+'||'+metaName+'">'+metaName+'</span></div></li>';

                        }

                    });
                    outputData += '</ul>';
                    $('#post-types-and-ids').append(outputData);
                    assignInitialHideMetaClasses();
               }
            });
            
            
            
        });
        
        

    }
    //run the function initially    
    createListingOfMetaBoxes();    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //code to add and remove items from input when clicking the hide icon
    $('.wrap').on("click", ".remove-meta-item", function () {

        var hiddenMeta = $('#wp_custom_admin_interface_hide_this_meta').val();

        if (hiddenMeta != null) {
            var hiddenMetaArray = hiddenMeta.split(',');
        }
        
        var metaPath = $(this).parent().find('#meta-name').attr('data');
        
        
        if ($.inArray(metaPath, hiddenMetaArray) != -1) {
            //it is in array i.e. we need to remove it  
            $(this).parent().parent().removeClass("hidden-meta-item");    
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
            
            hiddenMetaArray.splice($.inArray(metaPath, hiddenMetaArray), 1);
            $('#wp_custom_admin_interface_hide_this_meta').val(hiddenMetaArray.join());
            
        } else {
            //its not in the array i.e. we need to add it
            $(this).parent().parent().addClass("hidden-meta-item");
            $(this).addClass("fa-eye");
            $(this).removeClass("fa-eye-slash"); 
            
            hiddenMetaArray.push(metaPath);
            $('#wp_custom_admin_interface_hide_this_meta').val(hiddenMetaArray.join());

        }

    });
        
        

    
    
    
    
    //code to assign the appropriate classes initially
    
    function assignInitialHideMetaClasses(){
        
        $('.meta-item').each(function(index) {
            
            var metaPath = $(this).find('#meta-name').attr('data');
            var hiddenMeta = $('#wp_custom_admin_interface_hide_this_meta').val();

            if (hiddenMeta != null) {
                var hiddenMetaArray = hiddenMeta.split(',');
            }
            
            if ($.inArray(metaPath, hiddenMetaArray) != -1) {
                $(this).addClass("hidden-meta-item");
                $(this).find('.remove-meta-item').addClass("fa-eye");
                $(this).find('.remove-meta-item').removeClass("fa-eye-slash");   
            }
            
        });
        
        
    }
    //lets run this function initially
    assignInitialHideMetaClasses();
    
    
    
    
    
    

    
    
    
    
    
});