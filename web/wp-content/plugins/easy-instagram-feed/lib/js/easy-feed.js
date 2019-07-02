var all_posts='';
var img_sort='';
var image_limit='';
var image_resolution='';
array_index = 0;
var user_name_link = '';
var UserArray = [],UserArraycontent = [],UserArraywidget = [],UserArraywithwidget = [],UserArraywithcontent = [],UserArraymore = [];
var i=0
var test_url=[];
var number_of_user_in_more = '',number_of_user_content = '',number_of_user_in_widget = '',number_of_user_with_content = '',number_of_user_with_widget = '',number_of_user_widget = '';
$ = jQuery;
jQuery(document).ready(function($){

	$.each( eifsetting, function( index, eifsettings ){
	var id  = eifsettings.id;
    var token = eifsettings.eif_access_token;
	
	token = token.toString();
		 token = token.split(',');
	
	
  if(token == '')
	{
		
		var msgdiv = document.createElement("div"); 
		var t = document.createTextNode("Make sure that you have added user id and access token.");
		msgdiv.appendChild(t); 
		msgdiv.setAttribute('id','useridmsg');
		msgdiv.setAttribute('style','color:red;font-family: "Noto Serif", serif;');
		$("#eif_feed").append(msgdiv);
		
	}
		
	
	img_sort = eifsettings.eif_feed_image_sorting;
	image_limit = eifsettings.eif_feed_number_of_images;
	image_resolution = eifsettings.resolution;
	
	// Follow me on instagram button settings variable 
	var show = eifsettings.eif_feed_show_button_status;
  show = show.toLowerCase();
	var follow_btn_back_color = eifsettings.eif_feed_button_background_color;
	var follow_btn_text_color = eifsettings.eif_feed_button_text_color;
	var follow_btn_text  = eifsettings.eif_feed_follow_button_text;
	
	// Load more button settings variable
	var load_show = eifsettings.eif_feed_load_more_button_status;
  load_show = load_show.toLowerCase();
	var load_btn_back_color = eifsettings.eif_feed_load_more_button_back_color;
	var load_btn_text_color = eifsettings.eif_feed_load_more_button_text_color;
	var load_btn_text = eifsettings.eif_feed_load_more_button_text;
	
	// image settings
	var img_border = eifsettings.eif_feed_image_border;
	var img_overlay = eifsettings.eif_feed_image_overlay;
	var img_shadow = eifsettings.eif_feed_image_shadow;
	
	if(img_border == 'yes')
	{
		var img_border_css  = '1px solid #151515'
	} else
	{
	var img_border_css  = '0px solid #021a40'
	}
	if(img_overlay == 'yes'){
	var img_overlay_css  = 'position: absolute';
	}else{
		var img_overlay_css  = '';
	}

	if(img_shadow == 'yes'){
	var img_shadow_css  = '3px 3px 3px #7C7C7C';
	}else{
		var img_shadow_css  = '0px 0px 0px #7C7C7C';
	}


	//var page_feed_url = 'https://api.instagram.com/v1/users/self/feed?access_token=' + token;
    
    //var page_feed_url = 'https://api.instagram.com/v1/media/3?access_token=ACCESS-TOKEN';
	
	var number_of_user = token.length;
	var count_hide = 0;
	$.each(token,function(i,val){
	var url = "https://api.instagram.com/v1/users/"+ val.split(".")[0] +"/media/recent/?access_token="+ val +"&count="+image_limit+"";
    displayImgs(url);
	function displayImgs(url) {
        $.ajax({
        method: "GET",
        url: url,
        dataType: "jsonp",
        success: function(data){
        var posts = data.data;
		//UserArray[val] = posts;
		test_url = data.pagination.next_url;
 		var posts_length = posts.length;
		// create Load more button
		
		if(i==0)
		{
		
			if(load_show == 'yes')
			{
			
				var btn = document.createElement("BUTTON"); 
				var t = document.createTextNode(load_btn_text);
				btn.appendChild(t); 
				btn.setAttribute('id','Load_update'+id);
				btn.setAttribute('name','Load_update');
				//btn.setAttribute('onclick','load_more()');
				btn.setAttribute('class','load_more');
				btn.setAttribute('data-id',id);
				btn.setAttribute('style','background:'+load_btn_back_color+'; float:left;color:'+load_btn_text_color+';border-radius: 5px;padding: 10px 18px 10px;margin-bottom: 10px;margin-left: 10px;font-size: 11px;line-height: 1.5;font-family: "Noto Serif", serif;');
				$(".load"+id).append(btn);
			}
		
			// create follow me button 
			if(show == 'yes')
			{
				var showbtn = document.createElement("BUTTON");
				var stn = document.createTextNode(follow_btn_text);
				showbtn.appendChild(stn);
				showbtn.setAttribute('id','show_button'+id);
				showbtn.setAttribute('name','show_button');
				showbtn.setAttribute('onclick','follow_butn()');
				showbtn.setAttribute('style','border-radius: 5px;margin-left: 11px;margin-bottom: 10px;padding: 10px 18px 10px;color:'+follow_btn_text_color+';background-color:'+follow_btn_back_color+';font-size: 11px;line-height: 1.5;font-family: "Noto Serif", serif;');
				$(".load"+id).append(showbtn);	
			}
		}
		
			if(test_url != undefined)
		{
			 if(id == 1){
					UserArraycontent[val] = test_url;
				 }else if(id == 2){
					UserArraywidget[val] = test_url;
				 }else if(id == 3){
					UserArraywithwidget[val] = test_url;
				 }else if(id == 4){
					UserArraywithcontent[val] = test_url;
				}else if(id == 5){
					UserArraymore[val] = test_url;
				}else{
				UserArray[val] = test_url;
				}
		}
		else
		{
				count_hide++;
		}
		if(count_hide == number_of_user)
		{
		$('#Load_update'+id).css("visibility", "hidden");
		}
		
		
			// check random condition and call function for random images 
					if(img_sort=='random')
					{
					shuffle(posts);
					}
					all_posts=posts;
		
			$.each(posts, function(index){
		
			if(image_resolution== 'low_resolution')
			{
            var post_image_src = this.images.low_resolution.url;
			}
			else if(image_resolution== 'thumbnail')
			{
            var post_image_src = this.images.thumbnail.url;
			}
			else if(image_resolution== 'standard_resolution')
			{
            var post_image_src = this.images.standard_resolution.url;
			}
			var user_name  = this.user.username;
			user_name_link = user_name;
			
            var post_image_link = this.link;
			var post_image_created_time = this.created_time;
            post_image_src = post_image_src.replace(/.*?:\/\//g, "//");
            // create protocol relative instagram page link url
            post_image_link = post_image_link.replace(/.*?:\/\//g, "//");
            //alert(post_image_link);
            var wrapper='<div id="'+ this.id +'" class="eif_item"><div class="image-container"><a href="'+ post_image_link +'" target="_blank"><img src="' + post_image_src + '" style="border:'+img_border_css+'; box-shadow: '+img_shadow_css+';"/><div class="after" style="'+img_overlay_css+';"></div></a></div>';
            
			wrapper += '</div>';
			
            $('.eif_images'+id).append(wrapper);
			if(id == 1){
						 number_of_user_content = Object.keys(UserArraycontent).length;
						 }else if(id == 2){
						 number_of_user_in_widget = Object.keys(UserArraywidget).length;
						 }else if(id == 3){
						 number_of_user_with_content = Object.keys(UserArraywithwidget).length;
						 } else if(id == 4){
						 number_of_user_with_widget = Object.keys(UserArraywithcontent).length;
						 } else if(id == 5){
						 number_of_user_widget = Object.keys(UserArraymore).length;
						 }else{
						 number_of_user_in_more = Object.keys(UserArray).length;
						 }
			
           });
			
           //$('.eif_item:nth-child(4n)').after('<div class="clearfix"></div>'); 
     
		},
		
		
    });// end of ajax request
	}
});
});
});

// load more button function 
var count_hide_secound = 0,count_hide_secound_widget = 0,count_hide_secound_with_widget = 0,count_hide_secound_content = 0,count_hide_secound_with_content = 0,count_hide_secound_with_user = 0;

var count_hide_secound = 0;
$(document).on('click','.load_more',function()
{
id=$(this).attr('data-id');

eifsettings=eifsetting[id];
//console.log(eifsettings)
//var token = eifsettings.eif_access_token;
   // var user_ids = eifsettings.eif_user_id;
 /* if(user_ids == ''|| token == '')
	{
		
		var msgdiv = document.createElement("div"); 
		var t = document.createTextNode("Make sure that you have added user id and access token.");
		msgdiv.appendChild(t); 
		msgdiv.setAttribute('id','useridmsg');
		msgdiv.setAttribute('style','color:red;font-family: "Noto Serif", serif;');
		$("#eif_feed").append(msgdiv);
		
	}*/
		//user_ids = user_ids.toString();
		//user_ids = user_ids.split(',');
	
	img_sort = eifsettings.eif_feed_image_sorting;
	//image_limit = eifsettings.eif_feed_number_of_images;
	image_resolution = eifsettings.resolution;
	
	// Follow me on instagram button settings variable 
	//var show = eifsettings.eif_feed_show_button_status;
  //show = show.toLowerCase();
	//var follow_btn_back_color = eifsettings.eif_feed_button_background_color;
	//var follow_btn_text_color = eifsettings.eif_feed_button_text_color;
	//var follow_btn_text  = eifsettings.eif_feed_follow_button_text;
	
	// Load more button settings variable
	//var load_show = eifsettings.eif_feed_load_more_button_status;
 // load_show = load_show.toLowerCase();
	//var load_btn_back_color = eifsettings.eif_feed_load_more_button_back_color;
	//var load_btn_text_color = eifsettings.eif_feed_load_more_button_text_color;
	//var load_btn_text = eifsettings.eif_feed_load_more_button_text;
	
	// image settings
	var img_border = eifsettings.eif_feed_image_border;
	var img_overlay = eifsettings.eif_feed_image_overlay;
	var img_shadow = eifsettings.eif_feed_image_shadow;
	
	if(img_border == 'yes')
	{
		var img_border_css  = '1px solid #151515'
	} else
	{
	var img_border_css  = '0px solid #021a40'
	}
	if(img_overlay == 'yes'){
	var img_overlay_css  = 'position: absolute';
	}else{
		var img_overlay_css  = '';
	}

	if(img_shadow == 'yes'){
	var img_shadow_css  = '3px 3px 3px #7C7C7C';
	}else{
		var img_shadow_css  = '0px 0px 0px #7C7C7C';
	}

	//var page_feed_url = 'https://api.instagram.com/v1/users/self/feed?access_token=' + token;
    
    //var page_feed_url = 'https://api.instagram.com/v1/media/3?access_token=ACCESS-TOKEN';
	//var number_of_user = user_ids.length;
	var count_hide = 0;

jQuery(document).ready(function($){
	
	
	if(id == 1){
UserArray = UserArraycontent
}else if(id == 2){
UserArray = UserArraywidget
}else if(id == 3){
UserArray = UserArraywithwidget
}else if(id == 4){
UserArray = UserArraywithcontent
}else if(id == 5){
UserArray = UserArraymore
}
	
	
    for (var key in UserArray) {
key = key.split(",")
	$.each(key,function(i,val){
	var url = UserArray[key];
    displayImgs(url);
	function displayImgs(url) {
        $.ajax({
        method: "GET",
        url: url,
        dataType: "jsonp",
        success: function(data){
        var posts = data.data;
		UserArray[val] = posts;
		test_url = data.pagination.next_url;
 		var posts_length = posts.length;
		// create Load more button
		
		
			test_url = data.pagination.next_url;
		
 		var posts_length = posts.length;
		// hide Load more button if no more media
		if(test_url != undefined)
		{
			if(id == 1){
				UserArraycontent[val] = test_url;
				}else if(id == 2){
				UserArraywidget[val] = test_url;
				}else if(id == 3){
				UserArraywithwidget[val] = test_url;
				}else if(id == 4){
				UserArraywithcontent[val] = test_url;
				}else if(id == 5){
				UserArraymore[val] = test_url;
				}else{
				UserArray[val] = test_url;
				}
		}
		else
		{
			if(id == 1){
				count_hide_secound_widget++;
				delete UserArraycontent[val];
				}else if(id == 2){
				count_hide_secound_with_widget++;
				delete UserArraywidget[val];
				}else if(id == 3){
				count_hide_secound_content++;
				delete UserArraywithwidget[val];
				}else if(id == 4){
				count_hide_secound_with_content++;
				delete UserArraywithcontent[val];
				}else if(id == 5){
				count_hide_secound_with_user++;
				delete UserArraymore[val];
				}else{
				count_hide_secound++;
				delete UserArray[val];
				}	
			
		}
		
		if(id == 1){
			if(count_hide_secound_widget == number_of_user_content){
			$('#Load_update'+id).css("visibility", "hidden");
			}
		}else if(id == 2){
			if(count_hide_secound_with_widget == number_of_user_in_widget){
			$('#Load_update'+id).css("visibility", "hidden");
			}
		}else if(id == 3){
			if(count_hide_secound_content == number_of_user_with_content){
			$('#Load_update'+id).css("visibility", "hidden");
			}
		}else if(id == 4){
			if(count_hide_secound_with_content == number_of_user_with_widget){
			$('#Load_update'+id).css("visibility", "hidden");
			}
		}else if(id == 5){
			if(count_hide_secound_with_user == number_of_user_widget){
			$('#Load_update'+id).css("visibility", "hidden");
			}
		}
		
			// check random condition and call function for random images 
					if(img_sort=='random')
					{
					shuffle(posts);
					}
					all_posts=posts;
		
			$.each(posts, function(index){
		
			if(image_resolution== 'low_resolution')
			{
            var post_image_src = this.images.low_resolution.url;
			}
			else if(image_resolution== 'thumbnail')
			{
            var post_image_src = this.images.thumbnail.url;
			}
			else if(image_resolution== 'standard_resolution')
			{
            var post_image_src = this.images.standard_resolution.url;
			}
			var user_name  = this.user.username;
			
			user_name_link = user_name;
            var post_image_link = this.link;
			var post_image_created_time = this.created_time;
            post_image_src = post_image_src.replace(/.*?:\/\//g, "//");
            // create protocol relative instagram page link url
            post_image_link = post_image_link.replace(/.*?:\/\//g, "//");
            //alert(post_image_link);
           var wrapper='<div id="'+ this.id +'" class="eif_item"><div class="image-container"><a href="'+ post_image_link +'" target="_blank"><img src="' + post_image_src + '" style="border:'+img_border_css+'; box-shadow: '+img_shadow_css+';"/><div class="after" style="'+img_overlay_css+';"></div></a></div>';
            
			wrapper += '</div>';
			
            $('.eif_images'+id).append(wrapper);
			
           });
			
           //$('.eif_item:nth-child(4n)').after('<div class="clearfix"></div>'); 
     
		},
		
		
    });// end of ajax request
	}
});
}
});
});
function shuffle(array) 
{
	  var currentIndex = array.length, temporaryValue, randomIndex ;
	  while (0 !== currentIndex) {
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	  }
	return array;
}

// follow on instagram button function 
function follow_butn()
{
	//alert(user_name_link);
 window.open('http://instagram.com/'+user_name_link+'');

}