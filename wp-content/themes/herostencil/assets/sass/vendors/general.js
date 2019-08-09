jQuery(document).ready(function() {
    
    

});

jQuery(function() {
    jQuery('.matchheight').matchHeight();
});


/**/
jQuery( window ).on( 'load resize ready', function(){
    setTimeout(function(){
        if( jQuery(window).width() > 767 ){
            stickyHeader();
            if(!jQuery('body').hasClass('home')){
                headerTop = jQuery( 'header' ).outerHeight();
                jQuery('#page').css('padding-top',headerTop);               
            }
        } else {

            jQuery('#page').css('padding-top',0);
        }
    }, 400);
});

//----- sticky button - header script -----//
function stickyHeader() {
    jQuery( window ).on('scroll',function(){
        if ( jQuery( window ).scrollTop() > 100 ) {
            jQuery("header").addClass("sticky");
        } else {
            jQuery("header").removeClass("sticky");
        }
    });
}
