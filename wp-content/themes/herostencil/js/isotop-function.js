jQuery(document).ready(function($){
    /* ==========================================================================
       Isotope activation (staff templates)
       ========================================================================== */
    setTimeout(function(){
        $('ul.staff-list li').matchHeight();
    },500);
    var $ul = $(".staff-list").isotope({
        itemSelector: '.element-item',
        layoutMode: 'fitRows',
        getSortData: {
          number: '.number parseInt',
        }
    });
    setTimeout(function(){
        $(".staff-list").isotope({
            itemSelector: '.element-item',
            layoutMode: 'fitRows',
            getSortData: {
              number: '.number parseInt',
            }
        });
    },1000);

    $(document).on( 'click', '.masonary-list li a', function() {
        var filterValue = $( this ).attr('data-filter');
        var sortByValue = $(this).attr('data-sort-by');
        $(".masonary-list li a.current").removeClass("current");
        $(this).addClass("current");
        // use filterFn if matches value
        // filterValue = filterFns[ filterValue ] || filterValue;
        $ul.isotope({ filter: filterValue, sortBy: sortByValue });
        setTimeout(function(){
            $('.staff-list .staff-short').matchHeight();
            $('ul.staff-list li').matchHeight();
        },500);
    });
}); 