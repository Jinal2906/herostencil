<?php
/**
 * Template Name: Condition Page
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

echo 
'<div class="content">' .
    '<div class="wrapper">' .
    	'<div class="mid">' ;
			while ( have_posts() ) : the_post();
            echo '<h1>' . get_the_title() . '</h1>' .
            (
                $contentBanner == 'true'
                ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                : ''
            ) .
            get_the_content();
            $args = array('post_type' => 'condition', 'taxonomy' => 'body_parts', 'order' => 'asc', 'orderby' => 'menu_order');
            $tax_menu_items = get_categories( $args );
            echo '<div class="human-body">' ;
                    $i=1; foreach ( $tax_menu_items as $tax_menu_item ): 
                        echo '<a class="part' .$i++.'" title="'. $tax_menu_item->name .'" href="' . get_term_link($tax_menu_item,$tax_menu_item->taxonomy) . '"></a>';
                    endforeach;
            echo '</div>' ;
            endwhile; wp_reset_query();
        echo '</div>' ;
        get_sidebar();
    echo '</div>' .
'</div>' ;
get_footer(); 
?>