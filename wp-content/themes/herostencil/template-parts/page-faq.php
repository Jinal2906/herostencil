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

echo '<div class="content">' .
    '<div class="wrapper">' .
        '<div class="mid">' .
            '<div class="post">' .
                '<h1>' . get_the_title() . '</h1>' .
                (
                    $contentBanner == 'true'
                    ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                    : ''
                ) .
                get_the_content() .
                '<ul class="faq_section">';
                    wp_reset_query();
                    $paged= (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array( 'post_type' => 'faq', 'posts_per_page' => -1, 'order' => 'asc', 'orderby' => 'menu_order', 'paged' => $paged );
                    $wp_query = new WP_Query($args);
                    while ( $wp_query->have_posts() ) : $wp_query->the_post();
                    echo '<li>' .
                        '<h6><a href="'. get_the_permalink() .'">' . get_the_title() .'</a></h6>' .
                        '<div class="faq_content">' . get_the_Content() . '</div>' .
                    '</li>';
                    endwhile;
                    wp_reset_query();
                echo '</ul>' .
			'</div>' .
		'</div>' .
    '</div>'.
'</div>';
get_footer(); 
?>