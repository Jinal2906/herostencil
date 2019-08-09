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


?>
    <!--content start-->
    <div class="content">
        <div class="wrapper">
            <div class="mid">
                <?php the_content(); ?>
                <div class="page-content">
                    <div class="container">
                        <?php
                        while ( have_posts() ) : the_post(); ?>
                            <h1><?php the_title(); ?></h1>
                            <?php
                            echo (
                                $contentBanner == 'true'
                                ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                                : ''
                            );
                            ?>
                                <ul class="patient_results">
                                    <?php //wp_reset_query();
                                    $cp2 = get_the_id();
                                    $args = array( 'post_type' => 'testimonial', 'posts_per_page' => -1,'orderby' => 'DESC');
                                    $wp_query = new WP_Query($args);
                        // The Loop
                                    while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                                        <li>

                                            <div class="result-detail">
                                                <?php echo  (   has_post_thumbnail() 
                                                    ? '<div class="testimonials-thumb">' . get_the_post_thumbnail() . '</div>'
                                                    : ''
                                                ) ; ?>
                                                <div class="testimonials-content">
                                                    <?php the_content(); ?>
                                                    <h5><i><?php the_title();?></i></h5>
                                                    <p><strong><?php echo get_post_meta( get_the_ID(), '_cite', true );  ?></strong></p>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                    <?php wp_reset_query(); ?>
                                </ul>
                                <!-- .page-sidebar -->
                            <?php endwhile; ?>
                        </div><!-- .container -->
                    </div>
                </div>
            </div>
        </div>
        <!--content end-->
        <?php get_footer(); ?>