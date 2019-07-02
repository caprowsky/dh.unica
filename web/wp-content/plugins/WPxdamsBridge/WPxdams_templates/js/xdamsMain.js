

	
        
      

$(document).ready(function(){
$('.pulsante').on( 'click', function(e){
     $(this).prop("disabled",true);
    e.preventDefault();
    // non usati
    var txt_testo       = $('.testo'). val(); 
    var txt_color       = $('#colore').val();
    // non usati
    
  //  var my_level        = $('#c_levelIndex_WPxdamsBridge'). val();   
    var my_itemsNum     = $('#c_itemsNum_WPxdamsBridge'). val();	
    var my_queryNum     = $('#c_queryNum_WPxdamsBridge'). val();
    var my_perPage      = $('#c_perPage_WPxdamsBridge'). val();   
    var my_archId       = $('#c_archiveId_WPxdamsBridge'). val();
 //   var my_itemID       = $('#c_fieldIndex_WPxdamsBridge_1'). val();
    var my_fieldsNumber = $('#c_fieldsNumber_WPxdamsBridge'). val();
    var my_resumeQuery  = $('#c_resumeQuery_WPxdamsBridge').val();
    var my_noresume     = $('#c_noresume_WPxdamsBridge').val();
    var checkresume     = $('#c_resume_check_WPxdamsBridge');
    
    
    var my_itemID       = [];
    var my_level        = [];
    for (i = 1; i <= my_fieldsNumber; i++)
        {
        my_level [i]    = $('#c_levelIndex_WPxdamsBridge_' + i). val();  
        my_itemID[i]    = $('#c_fieldIndex_WPxdamsBridge_' + i).val();
    }
    
    var my_remainingrec = my_itemsNum -( (my_resumeQuery - 1) * my_perPage )
;    
     $('#sottotitolo').html('<h4>Process started - number of elements to import: ' + my_itemsNum + ' Archive: ' + my_archId   + '</h4>');
    
   // if (checkresume.checked==true){ 
        if (($("#c_resume_check_WPxdamsBridge").is(":not(:checked)"))|| (my_noresume==1)) {     
             $('#sottotitolo').html('<h4>New process started - number of elements to import: ' + my_itemsNum + ' Archive: ' + my_archId   + '</h4>');
        } else {
             my_queryNum = my_resumeQuery;
             $('#sottotitolo').html('<h4>Process started from the block n. ' + my_resumeQuery + ' - number of elements to import: ' + my_remainingrec + ' - Archive: ' + my_archId   + '</h4>');
        } 

    // chiamata ajax
    
$.ajax(
        {
            
    type: "POST",
    url: my_vars.ajaxurl, //	// sottoparametro ajaxurl di my vars
    data: {
        action          : 'import_tree', 
        _nonce          : my_vars.nonce, // action da eseguire
        level           : my_level,
        itemsNum        : my_itemsNum,
        queryNum        : my_queryNum,
        perPage         : my_perPage,
        archId          : my_archId,
        itemID          : my_itemID,
        fieldsNumber    : my_fieldsNumber,
        colore          : txt_color,
        testo           : 'prima parte '
    },    
    success: function(){
        $('#sottotitolo').html(my_vars.ajaxurl);
          $('#sottotitolo').html('<h4>Process completed - Hierarchy created for archive ID ' + my_archId   + ' -> processed records  ' + my_itemsNum +  '</h4>');
       //printmsg('fone', my_level,my_itemsNum,my_queryNum,my_perPage,my_archId,my_itemID,my_fieldsNumber)
        }
    }
            
    );     

 });    
});

