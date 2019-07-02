

	
        
      

$(document).ready(function(){
$('.pulsante').on( 'click', function(e){
    
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
    
    
    
    var my_itemID       = [];
    var my_level        = [];
    for (i = 1; i <= my_fieldsNumber; i++)
        {
        my_level [i]    = $('#c_levelIndex_WPxdamsBridge_' + i). val();  
        my_itemID[i]    = $('#c_fieldIndex_WPxdamsBridge_' + i).val();
    }
    
  //  $('#sottotitolo').html('<h4>inizio elaborazione - numero di oggetti da trattare per gruppo: ' + my_perPage + ' archivio:' + my_archId  + ' ciclo numero:  ' + my_queryNum + ' totale oggetti:  ' +my_itemsNum + ' livello :  ' + my_level + ' valori :  ' +my_itemID + '</h4>');
    $('#sottotitolo').html('<h4>inizio elaborazione - numero di oggetti da trattare: ' + my_itemsNum + ' archivio: ' + my_archId   + '</h4>');

    // chiamata ajax
$.ajax(
        {
    type: "POST",
    url: my_vars.ajaxurl, //	// sottoparametro ajaxurl di my vars
    data: {
        action          : 'import_tree', 
        _nonce          : my_vars.nonce, // action da eseguire
        level           : my_level,
        itemNum         : my_itemsNum,
        queryNum        : my_queryNum,
        perPage         : my_perPage,
        archId          : my_archId,
        itemID          : my_itemID,
        fieldsNumber    : my_fieldsNumber,
        colore          : txt_color,
        testo           : 'prima parte '
    },    
    success: function(res){
        $('#sottotitolo').html(res);
        $.ajax(
        {
        type: "POST",
    url: my_vars.ajaxurl, //	// sottoparametro ajaxurl di my vars
    data: {
        action          : 'import_tree', 
        _nonce          : my_vars.nonce, // action da eseguire
        level           : my_level,
        itemNum         : my_itemsNum,
        queryNum        : my_queryNum,
        perPage         : my_perPage,
        archId          : my_archId,
        itemID          : my_itemID,
        fieldsNumber    : my_fieldsNumber,
        colore          : txt_color,
        testo           : 'prima parte '
    },        
            
            
         success: function(){   
         $('#sottotitolo').html( 'oooo'); 
         }
        })
        
        
        
        
        
        }
    }
            
    );

 });    
});


function printmsg(messaggio, my_level,my_itemsNum,my_queryNum,my_perPage,my_archId,my_itemID,my_fieldsNumber) {
    $('#sottotitolo').html(my_vars.ajaxurl);
     $('#sottotitolo').html('<h4>Termine elaborazione - archivio: ' + my_archId   + '</h4>');
    $.ajax(
        {
           
    type: "POST",
    url: my_vars.ajaxurl, //	// sottoparametro ajaxurl di my vars
    data: {
        action          : 'import_tree', 
        _nonce          : my_vars.nonce, // action da eseguire
        level           : my_level,
        itemNum         : my_itemsNum,
        queryNum        : my_queryNum,
        perPage         : my_perPage,
        archId          : my_archId,
        itemID          : my_itemID,
        fieldsNumber    : my_fieldsNumber,
        colore          : txt_color,
        testo           : 'ultima parte  '
    },    
    success: function(){
         $('#sottotitolo').html(my_vars.ajaxurl);
       
        },
        error: function(){
         $('#sottotitolo').html(my_vars.ajaxurl);
       
        }    
    }
            
    );
    $('#sottotitolo').html('<h4>Termine elaborazione - archivio: ' + my_archId   + '</h4>');

}