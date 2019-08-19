<?php

wp_enqueue_style( 'front-service' );
$ServicesGroup = get_field('services');
$ServicesSecTitle = $ServicesGroup['services_title'];
$ServicesSecDesc = $ServicesGroup['services_subtitle'];
$ServicesSecBG = $ServicesGroup['services_bg_image']['url'];
$CTAText = $ServicesGroup['services_cta'];

if(have_rows('services')){
    while( have_rows('services') ) :
    the_row();

    echo '<section class="services-section position-relative py-50 text-center"' . ( !empty( $ServicesSecBG ) ?  'style="background-image: url(' . $ServicesSecBG . ')"' : '' ) . '>' .
        '<div class="wrapper">' .
        '<h2>' . $ServicesSecTitle . '</h2>' .
        '<p>' . $ServicesSecDesc . '</p>';
            if( have_rows('services_list') ){
            echo '<ul class=" d-flex list-none row-15 p-0 ">';
            while ( have_rows('services_list') ) :
                the_row();
                $serviceIcon = get_sub_field('services_icon');
                $serviceTitle = get_sub_field('service_title');
                $serviceUrl = get_sub_field('service_url');
                $serviceDesc = get_sub_field('service_desc');

                $img_html = wp_get_attachment_image( $serviceIcon, 'large' );

                echo '<li class=" position-relative d-block cell-4 p-15 cell-992-6 cell-480-12 ">' .
                        '<div class="service-image innbaner image-src pt-75 cell-12 mb-10 position-relative block-animate">' .
                            (
                                $img_html
                                ? $img_html
                                : ''
                            ) .
                            '<div class="service-content bg-white-80 width-full height-full p-15 d-flex justify-content-center align-content-center position-absolute position-top-0-px position-left-0-px transition opacity-0 ">' .
                                (
                                    get_sub_field('service_title')
                                    ? '<h3 class="mb-10 text-24 text-767-20 text-480-18 text-secondary ">' . get_sub_field('service_title') . '</h3>'
                                    : ''
                                ) .
                                (
                                    get_sub_field('service_desc')
                                    ? '<p class="mb-10">' . get_sub_field('service_desc') . '</p>'
                                    : ''
                                ) .
                                (
                                    get_sub_field('service_url')
                                    ? '<a class="read-more" href="' . get_sub_field('service_url') . '"><span>' . $CTAText . '</span></a>'
                                    : ''
                                ) .
                            '</div>' .
                        '</div>' .
                        (
                            get_sub_field('service_title')
                            ? '<h2 class="text-20 text-767-18 text-480-16">' . get_sub_field('service_title') . '</h2>'
                            : ''
                        ) .
                 '</li>';
                endwhile;
            echo '</ul>';
            }
        echo '</div>' .
        '</section>';

    endwhile;
}
?>
