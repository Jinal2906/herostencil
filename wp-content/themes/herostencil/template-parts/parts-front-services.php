<?php

wp_enqueue_style( 'parts-front-services' );
$ServicesGroup = get_field('services');
$ServicesSecTitle = $ServicesGroup['services_title'];
$ServicesSecDesc = $ServicesGroup['services_subtitle'];
$ServicesSecBG = $ServicesGroup['services_bg_image']['url'];
$CTAText = $ServicesGroup['services_cta'];

if(have_rows('services')){
    while( have_rows('services') ) :
    the_row();

    echo '<section class="services-section"';
        if( !empty( $ServicesSecBG ) ) {
            echo 'style="background-image: url(' . $ServicesSecBG . ')"';
        }
        echo '>' .
        '<div class="wrapper">' .
        '<h2>' . $ServicesSecTitle . '</h2>' .
        '<p>' . $ServicesSecDesc . '</p>';
            if( have_rows('services_list') ){
            echo '<ul>';
            while ( have_rows('services_list') ) :
                the_row();
                $serviceIcon = get_sub_field('services_icon');
                $serviceTitle = get_sub_field('service_title');
                $serviceUrl = get_sub_field('service_url');
                $serviceDesc = get_sub_field('service_desc');

                $img_html = get_image( $serviceIcon, 'large', true );

                echo '<li>' .
                        '<div class="service-image innbaner">' .
                            (
                                get_sub_field('services_icon')
                                ? $img_html
                                : ''
                            ) .
                            '<div class="service-content">' .
                                (
                                    get_sub_field('service_title')
                                    ? '<h3>' . get_sub_field('service_title') . '</h3>'
                                    : ''
                                ) .
                                (
                                    get_sub_field('service_desc')
                                    ? '<p>' . get_sub_field('service_desc') . '</p>'
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
                            ? '<h2>' . get_sub_field('service_title') . '</h2>'
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
