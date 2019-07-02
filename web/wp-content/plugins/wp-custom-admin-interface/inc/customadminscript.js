jQuery(document).ready(function ($) {
    
    //unfortunately we need to implement this ugly code so that custom SVGs render over the WordPress icons in the main menu
    $('.wp-menu-image.svg').each(function( index ) {
    
        var myCustomSVG = $(this).css('background-image');
        
        if(myCustomSVG == 'none'){
            
            var myCustomSVGStyle = $(this).attr('style');
            
            var myCustomSVGStyleImportant = myCustomSVGStyle+' !important;';
            
            $(this).attr("style",myCustomSVGStyleImportant);      
        }
        
        
    });
});