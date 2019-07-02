(function($){
var string_hash = window.location.hash;
var token = string_hash.substring(14);

var client_id='44a5744739304a48af362318108030bc';

// set the access token to their respective inputs.
$(function () {  
    if(string_hash){
		var eif_access_token=  $('#eif_access_token');
		eif_access_token.val(token);
	}
});

})(jQuery);