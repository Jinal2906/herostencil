<?php
wp_enqueue_style( 'page-patient-testmonial' );
/**
* Template Name: Patient Testmonial Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
get_header(); 


global $contentBanner;
if ( has_post_thumbnail() ){
    if( 'Top' == get_field( 'banner_position_new' ) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail() . '</div>';
    } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new') ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail() . '</div>';
    } else {
        $contentBanner = 'true';
    }
}
echo '<div class="content">' .
        '<div class="wrapper">' .
            '<div class="mid">' .
                get_the_content() .
                '<div class="page-content">' .
                    '<div class="container">' ;
                        while ( have_posts() ) : the_post();
                            echo '<h1>' . get_the_title() . '</h1>' .
                            (
                                $contentBanner == 'true'
                                ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                                : ''
                            ) .
                            '<ul class="patient_results">';
                                $cp2 = get_the_id();
                                $args = array( 'post_type' => 'testimonial', 'posts_per_page' => -1,'orderby' => 'DESC');
                                $wp_query = new WP_Query($args);
                                while ( $wp_query->have_posts() ) : $wp_query->the_post();
                                    echo '<li>' .
                                        '<div class="result-detail">' .
                                            (   has_post_thumbnail() 
                                                ? '<div class="testimonials-thumb">' . get_the_post_thumbnail() . '</div>'
                                                : ''
                                            ) .
                                            '<div class="testimonials-content">' .
                                                get_the_content() .
                                                '<h5><i>' . get_the_title() . '</i></h5>' .
                                            '</div>' .
                                        '</div>' .
                                    '</li>' ;
                                endwhile;
                                wp_reset_query();
                            echo '</ul>' ;
                        endwhile; 
                    echo '</div>' .
                '</div>' .
            '</div>' .
        '</div>' .
'</div>' ;
get_footer(); 
?>