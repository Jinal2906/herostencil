$headerHeight = '';
$headerHeight = '';
$headerHeightscroll = '';

jQuery(document).ready(function($){
    var nav_clone = jQuery(".nav_menu").clone().addClass("");
    jQuery(".mobile_menu .inner").append(nav_clone);
    $(".navbar-toggle").click(function(){
        if($(this).hasClass("active")){
            $(this).removeClass("active");
            $('.mobile_menu').animate({'right':'-100%'},500);
        }else{
            $(this).addClass("active");
            $('.mobile_menu').animate({'right':'0'},500);
        }
    });
    $(".mobile_menu ul li").find("ul").parents("li").prepend("<span></span>");
    $(".mobile_menu ul li ul").addClass("first-sub");
    $(".mobile_menu ul li ul").prev().prev("span").addClass("first-em");
    $(".mobile_menu ul li ul ul").removeClass("first-sub");
    $(".mobile_menu ul li ul ul").addClass("second-sub");
    $(".mobile_menu ul li ul ul").prev().prev("span").addClass("second-em");
    $(".mobile_menu ul li ul ul").prev().prev("span").removeClass("first-em");
    $(".mobile_menu ul li span.first-em").click(function(e) {
        $(".mobile_menu ul li span.first-em").removeClass('active');
        $(".mobile_menu ul li span.second-em").removeClass('active');
        if($(this).parent("li").hasClass("active")){
            $(this).parent("li").removeClass("active");
            $(this).next().next("ul.first-sub").slideUp();
            $(".mobile_menu ul li ul.second-sub li").removeClass("active");
            $(".mobile_menu ul li ul.second-sub").slideUp();
        }else{
            $(this).addClass('active');
            $(".mobile_menu ul li").removeClass("active");
            $(this).parent("li").addClass("active");
            $(".mobile_menu ul li ul.first-sub").slideUp();
            $(this).next().next("ul.first-sub").slideDown();
            $(".mobile_menu ul li ul.second-sub li").removeClass("active");
            $(".mobile_menu ul li ul.second-sub").slideUp();
        }
    });
    $(".mobile_menu ul li ul.first-sub li span.second-em").click(function(e) {
        $(".mobile_menu ul li span.second-em").removeClass('active');
        if($(this).parent("li").hasClass("active")){
            $(this).parent("li").removeClass("active");
            $(this).next().next("ul.second-sub").slideUp();
        }else{
            $(this).addClass('active');
            $(".mobile_menu ul li ul li").removeClass("active");
            $(this).parent("li").addClass("active");
            $(".mobile_menu ul li ul.second-sub").slideUp();
            $(this).next().next("ul.second-sub").slideDown();
        }
    });
    $(".close-btn").click(function(){
        $('.mobile_menu').animate({'right':'-100%'},500);
        $(" .navbar-toggle").removeClass("active");
    });
    $('.company-list-wrapper').slick({
        arrows: false,
        dots:true,
    });
    $('.testimonials-section .slider-wrapper').slick({
        arrows: false,
        dots:true,
    });




    /* Condition */
    var part = $(".search-condition .body-part h4").attr("class");
    var partWrap = $("#"+part).attr("class");
    $(".search-condition").addClass(partWrap+"wrap");
    $("#"+part).addClass("active");
    if($(window).width() > 767){
        //Menu
        $(".top-menu ul").css("display", "");
        $(".top-menu span.drop-down").removeClass("drop");
        /*Condition*/
        $(".body-part-list li a").attr("href","javascript:void(0)");
        $(".body-part-list li a").click(function(){
            $(".body-content").show();
            $(".search-condition .body-content .con").hide();
            $(".body-part-list li a").removeClass("active");
            $(this).addClass("active");
            var con = $(this).attr("rel");
            $(con).show();
        });
    }else{
        $('.fancybox3').fancybox({
            padding : 0,
            nextEffect : 'fade',
            nextSpeed  : 250,
            nextEasing : 'swing',
            nextMethod : 'changeIn',
            prevEffect : 'fade',
            prevSpeed  : 250,
            prevEasing : 'swing',
            prevMethod : 'changeOut',
            fitToView: 'false',
            maxWidth: '90%',
            close: function() {
                $('html').removeClass("fancybox-lock").removeClass('fancybox-margin');
            },
            beforeShow: function(e, t) {
                $('html').addClass("fancybox-lock").addClass('fancybox-margin');
            },
        });
    };
    /* theme popup */
    /*setTimeout(function() {
        $('#theme-popup').fancybox().trigger('click');
    }, 5000);*/

    /* faq */
    $(".faq-menu a.list, .conditions-menu a.list").click(function(e){
        e.stopPropagation();
        $(this).parent().find("ul").slideToggle('fast');
        $(this).toggleClass("active");
    });
    $('ul.faq_section li h6 a').click(function (e) {
        if($(this).hasClass("active")){
            $(this).removeClass("active");
            $(this).parents("h6").next(".faq_content").slideUp(300);
        }else{
            $('ul.faq_section li h6 a').removeClass("active")
            $('ul.faq_section li .faq_content').slideUp(300);
            $(this).addClass("active");
            $(this).parents("h6").next(".faq_content").slideDown(300);
        }
        return false;
    });
    $('.location-therapists-section ul.staff-list').slick({
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        autoplay: true,
        adaptiveHeight: true,
        nextArrow:'<span class="slick-next"> &#10095; </span>',
        prevArrow:'<span class="slick-prev"> &#10094; </span>',
        responsive: [
            {
                breakpoint: 580,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    /*Location Templatae TestimoniaL*/
    $('.testimonial-slide').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        dots: false,
        arrows: true,
        adaptiveHeight: true,
        nextArrow:'<span class="slick-next"> &#10095; </span>',
        prevArrow:'<span class="slick-prev"> &#10094; </span>',
    });
    /* services pages testimonials slider */
    $('.testimonial-post .slider-post').slick({
        infinite: false,
        slidesToShow: 1,
        dots: true,
        autoplay: false,
        responsiveClass:true,
        arrows: false,
    });
    $('#searchform').submit(function(){
        if($('#s').val() == ''){
            return false;
        }
    });
    $('.help-block .ebook-block h2').matchHeight();
});
jQuery( window ).on( 'load resize ready', function($){
    stickyHeader();
    $headerHeight = jQuery( 'header' ).outerHeight();
    jQuery('#wrapper').css('padding-top',$headerHeight);
});
jQuery(window).scroll(function (event) {
    stickyHeader();
});
(function($){
    $(window).on("load",function(){
        /* custom scroll function for review sidebar */
        if( $('.review-sidebar').length > 0 ){
            var v_feed_fun = setInterval(function(){
                var v_feed = $('.v-feed').length
                if(v_feed > 0 ){
                    myStopFunction();
                    $(".review-sidebar").mCustomScrollbar({
                        theme:"rounded-dark"
                    });
                }
            },2000);
            function myStopFunction() {
                clearInterval(v_feed_fun);
            }
        }
        // $scroll_count = '';
        // setTimeout(function(){
        //     if( jQuery( this ).scrollTop() > 50 && $scroll_count == '' ){
        //         $headerHeightscroll = jQuery( 'header' ).outerHeight();
        //         console.log( $headerHeightscroll );
        //         $scroll_count = 'true';
        //     }
        // },500);

        // jQuery(window).scroll(function (event) {
        //     if( jQuery( this ).scrollTop() > 50 && $scroll_count == '' ){
        //         $headerHeightscroll = jQuery( 'header' ).outerHeight();
        //         console.log( $headerHeightscroll );
        //         $scroll_count = 'true';
        //     }
        // });
    });
})(jQuery);
//----- sticky header script -----//
function stickyHeader() {
    var sticky = jQuery('header'),
        scroll = jQuery(window).scrollTop();

    if (scroll >= 50) {
        sticky.addClass('sticky');
            $headerHeightscroll = jQuery( 'header.sticky' ).outerHeight();
            console.log( $headerHeightscroll );
        }
    else sticky.removeClass('sticky');
}
/* function for Lazyload and set image to background in InternetExplorer 11 Only */
var userAgent, ieReg, ie;
userAgent = window.navigator.userAgent;
ieReg = /msie|Trident.*rv[ :]*11\./gi;
ie = ieReg.test(userAgent);
if( ie ) {
    jQuery(".innbaner").each(function () {
        var $container = jQuery(this),
            imgUrl = $container.find("img").prop("src");
        if (imgUrl) {
            $container.css({"background-image": 'url(' + imgUrl + ')', "background-size": "cover", "background-position": "center center"}).addClass("custom-object-fit");
            jQuery(".innbaner img").css("display", "none");
        }
    });
}
// custom Location maps
jQuery(document).ready(function($) {
    var i = 1;
    var siteurl = frontend_ajax_object.siteurl;
    $('.location-map').each(function(index, currentElement) {
        $(this).attr('id', 'map'+i); // add id for map in location
        var load_id = 'map'+i;
        var lat  = $(this).attr('loc_lat');
        var long = $(this).attr('loc_long');
        var address = $(this).attr('loc_address');
        var mapURL = $(this).attr('loc_map-url');
        var latlng = new google.maps.LatLng(lat,long);
        var options = {
            zoom: 16, // This number can be set to define the initial zoom level of the map
            center: latlng,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.TERRAIN, // This value can be set to define the map type ROADMAP/SATELLITE/HYBRID/TERRAIN
        };
        var map = new google.maps.Map(document.getElementById(load_id), options);
        // Define Marker properties
        var image = new google.maps.MarkerImage(siteurl+'/images/map-pin.png',
        // This marker is 129 pixels wide by 42 pixels tall.
        new google.maps.Size(50,67),
        // The origin for this image is 0,0.
        new google.maps.Point(0,0),
        // The anchor for this image is the base of the flagpole at 18,42.
        new google.maps.Point(25,67)
       );
        // Add Marker
        var marker1 = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: image // This path is the custom pin to be shown. Remove this line and the proceeding comma to use default pin
        });
        // Create information window
        function createInfo(title, content) {
            return '<div class="infowindow"><a target="_blank" href="'+mapURL+'"><strong>' + address + '</strong></a></div>';
        }
        var infowindow1 = new google.maps.InfoWindow({
            content:  createInfo('Get Direction')
        });
        // Add listener for a click on the pin
        google.maps.event.addListener(marker1, 'click', function() {
            infowindow1.open(map, marker1);
        });
        //infowindow.open(map, marker1);
        $(window).resize(function() {
            google.maps.event.trigger(map, "resize");
        });
        i++;
    });
});
