<?php
wp_enqueue_style( 'parts-front-testimonials' );
$testimonials = get_field('testimonials_section');
if( have_rows('testimonials_section') ) {
    while ( have_rows('testimonials_section') ) : the_row();
        echo '<section class="testimonials-section"><div class="wrapper">';
            if( !empty( $testimonials['testimonial_section_image'] ) ){
                echo '<div class="left-image">' .
                    '<div class="testi-image innbaner">' .
                     (
                        get_sub_field('testimonial_section_image')
                        ? wp_get_attachment_image( get_sub_field('testimonial_section_image'), 'large', false, array( 'class' => '' ) )
                        : ''
                    ) .
                    '</div>' .
                    '</div>';
            }
        $posts = get_sub_field('select_testimonials');
        if( $posts ) {
            echo '<div class="right-slider">' .
                '<div class="slider-wrapper">';
                foreach( $posts as $post):
                setup_postdata($post);
                    echo '<div class="single-testimonial">';
                        if( get_field('testimonial_title') ){
                            echo '<h3>' . get_field('testimonial_title') . '</h3>';
                        }
                        the_excerpt();
                        echo '<hr>';
                        if( get_field('author_name') ){
                            echo '<h4>' . get_field('author_name') . '</h4>';
                        }
                    echo '</div>';
                endforeach;
            echo '</div>' .
             '</div>';
        }    
        echo '</div></section>';
    endwhile; wp_reset_query();
}
/*echo '<div class="testimonials-section">' .
        '<div class="wrapper">' .
            '<div class="view_tesi">' .
                '<div class="testimonial-slider">';
                    $cp = get_the_id();
                    $posts = get_field('testimonials_list');
                    if( $posts ): 
                        foreach( $posts as $post):
                            setup_postdata($post);
                        echo '<div class="testimonial-items">' .
                            '<div class="testimonial-content">';
                            //the_content();
                            the_excerpt();
                            echo '</div>' .                   
                            '<h5>' . get_the_title() . '</h5>' .
                            '</div>';
                        endforeach;
                     endif;
                    wp_reset_query();
                echo '</div>' .
            '</div>' .
        '</div>' .
    '</div>';*/
?>