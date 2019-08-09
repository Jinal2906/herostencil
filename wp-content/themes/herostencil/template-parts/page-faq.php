<?php
/**
 * Template Name: FAQ Page
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header(); 
wp_enqueue_style( 'page-faq' );

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
<div class="content cf">
    <div class="wrapper">
        <div class="mid">
        	
            <div class="post cf">
                <h1><?php the_title(); ?></h1>
                <?php
                    echo (
                        $contentBanner == 'true'
                        ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                        : ''
                    );
                ?>
                <?php the_content(); ?>
                <ul class="faq_section">
                <?php wp_reset_query(); ?> 
                <?php $paged= (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array( 'post_type' => 'faq', 'posts_per_page' => -1, 'order' => 'asc', 'orderby' => 'menu_order', 'paged' => $paged );
                $wp_query = new WP_Query($args);
                // The Loop
                while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                <li>
                    <h6><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h6>
                    <div class="faq_content">
                        <?php the_content(); ?>
                    </div>
                </li>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?> 
                </ul>
			</div>
		</div>  
        <?php //get_sidebar(); ?>
    </div>
</div>
<!--content end-->
<?php get_footer(); ?>