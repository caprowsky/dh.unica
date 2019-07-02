jQuery(document).ready(function ($) {
    
    //$('body').hide();
    
    
var img = new Image();
img.onload = function() {
    
    var imageSrc = this.src;

    console.log(imageSrc);

    if(imageSrc.indexOf('wp-admin/images') !== -1){
        // console.log('I was found');
    } else {
        // console.log('I was not found');
        var calculation = this.height/(this.width/320);     
        $("#login h1 a").css("height",calculation);
    }

    

}

var bg = $("#login h1 a").css("background-image");
bg = bg.replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');

img.src = bg;
    
    
});

