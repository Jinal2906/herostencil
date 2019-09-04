<?php
//wp_enqueue_style( 'parts-front-appointment' );
if( get_field('request_appointment_content') || get_field('request_appointment_form') ){
    echo '<section class="request-appointment">' .
            '<div class="wrapper">' .
				'<div class="d-flex row-10">' .
	                (
	                    get_field('request_appointment_content')
	                    ? '<div class="cell-5 cell-992-12 p-10">' . '<div class="appointment-content p-20 bg-secondary height-full">' . get_field('request_appointment_content') . '</div>' . '</div>'
	                    : ''
	                ) .
	                (
	                    get_field('request_appointment_form')
	                    ? '<div class="cell-7 cell-992-12 p-10">' . '<div class="appointment-form p-20 bg-black-light-80 height-full">' . '<h2 class="text-center text-white">Request Appointment</h2>' . do_shortcode( get_field('request_appointment_form') ) . '</div>' . '</div>'
	                    : ''
	                ) .
				'</div>' .
            '</div>' .
        '</section>';
}
//echo get_field('request_appointment_content');
//echo do_shortcode('[]')
