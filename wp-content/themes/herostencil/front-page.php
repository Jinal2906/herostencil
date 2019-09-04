<?php
/*
Template Name: Front Page
*/
/** header */
get_header();

/** banner */
get_template_part( 'template-parts/parts-front', 'banner' );

/** welcome */
get_template_part( 'template-parts/parts-front', 'welcome' );

/** testimonials */
get_template_part( 'template-parts/parts-front', 'testimonials' );

/** feature teastimonials */
//get_template_part( 'template-parts/parts-front', 'feature-testimonials' );

/** Services */
get_template_part( 'template-parts/parts-front', 'services' );

/** Appointment */
get_template_part( 'template-parts/parts-front', 'appointment' );

/** latest Blog */
get_template_part( 'template-parts/parts-front', 'blog' );

/** footer */
get_footer(); ?>
