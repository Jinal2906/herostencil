jQuery(document).ready(function($){
    /* ==========================================================================
       Isotope activation (staff templates)
       ========================================================================== */
    setTimeout(function(){
        $('ul.staff-list li').matchHeight();
    },500);
    var $ul = $(".staff-list").isotope({
        itemSelector: '.element-item',
        layoutMode: 'fitRows'
    });
    setTimeout(function(){
        $(".staff-list").isotope({
            itemSelector: '.element-item',
            layoutMode: 'fitRows'
        });
    },1000);

    $(document).on( 'click', '.masonary-list li a', function() {
        var filterValue = $( this ).attr('data-filter');
        $(".masonary-list li a.current").removeClass("current");
        $(this).addClass("current");
        // use filterFn if matches value
        // filterValue = filterFns[ filterValue ] || filterValue;
        $ul.isotope({ filter: filterValue });
        setTimeout(function(){
            $('.staff-list .staff-short').matchHeight();
            $('ul.staff-list li').matchHeight();
        },500);
    });
}); 