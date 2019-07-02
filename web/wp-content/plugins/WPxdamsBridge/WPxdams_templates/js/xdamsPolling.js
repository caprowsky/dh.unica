

$(document).ready(function(){

  $('.pulsante').on( 'click', function(e){
  
    var my_archId       = $('#c_archiveId_WPxdamsBridge'). val();
    var testmsg         = $('#c_status2_WPxdamsBridge').val();
    var status2         = $('.status2');
    var checkresume     = $('#c_resume_check_WPxdamsBridge');   
    
        $.ajax(
            {  
            type: "POST",
            url: my_vars.ajaxurl, //	// sottoparametro ajaxurl di my vars
            data: {
                action          : 'polling', 
                nonce           : my_vars.nonce, // action da eseguire
                archId          : my_archId

            },    
            success: function(){
            
                var status = $('.status'),
                poll = function(b) {
                    $.ajax({
                        url: '../wp-content/plugins/WPxdamsBridge/WPxdams_messages/status.json',
                        dataType: 'json',
                        type: 'get',
                
                        success: function(data) { // check if available
                            status.text(data.info);
                            if ( data.live ) { // get and check data value
                            status.text(data.info); // get and print data string
                            clearInterval(pollInterval); // optional: stop poll function
                        }
                    },
                    error: function() { // error logging
                        status.text('ERRORE!');
                        console.log('Error!');  
                    }
                });
            },
            pollInterval = setInterval(function() { // run function every 2000 ms
                poll();
                }, 2000);
            poll(); // also run function on init         
        }
    }
            
    );     
  
 } )
} ) ;





        var status = $('.status'),
        poll = function(b) {
          $.ajax({
            url: '../wp-content/plugins/WPxdamsBridge/WPxdams_messages/status.json',
            dataType: 'json',
            type: 'get',
            success: function(data) { // check if available
              status.text(data.info);
              if ( data.live ) { // get and check data value
                status.text(data.info); // get and print data string
                clearInterval(pollInterval); // optional: stop poll function
              }
            },
            error: function() { // error logging
              status.text('ERRORE!');
              console.log('Error!');
              
            }
          });
        },
        pollInterval = setInterval(function() { // run function every 2000 ms
          poll();
          }, 1000);
        poll(); // also run function on init

