jQuery(document).ready(function ($) {
    
    //make help area content into an accordion
    $("#accordion").accordion({
        collapsible: true,
        autoHeight: false,
        heightStyle: "content",
        active: false,
        speed: "fast"
    });
    
});