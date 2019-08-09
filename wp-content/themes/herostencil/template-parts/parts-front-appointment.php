<?php 
wp_enqueue_style( 'parts-front-appointment' );
if( get_field('request_appointment_content') || get_field('request_appointment_form') ){
    echo '<section class="request-appointment">' .
            '<div class="wrapper">' .
                (
                    get_field('request_appointment_content')
                    ? '<div class="left-content">' . get_field('request_appointment_content') . '</div>'
                    : ''
                ) .
                (
                    get_field('request_appointment_form')
                    ? '<div class="right-form">' . do_shortcode( get_field('request_appointment_form') ) . '</div>'
                    : ''
                ) .
            '</div>' .
        '</section>';
}
//echo get_field('request_appointment_content');
//echo do_shortcode('[]')