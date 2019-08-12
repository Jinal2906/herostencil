<?php
wp_enqueue_style( 'archive-workshop-page' );
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();

if(have_posts()){
    global $contentBanner;
    wp_reset_query();wp_reset_postdata();
    $post_type_obj = get_post_type_object( get_post_type() );
    $archive_title = apply_filters('post_type_archive_title', $post_type_obj->labels->name);
    $page = get_page_by_path( $archive_title );

    if ( has_post_thumbnail($page->ID) ){
        if( 'Top' == get_field( 'banner_position_new', $page->ID ) ) {
            echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
        } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', $page->ID ) ) {
            echo '<div class="innbaner test">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
        } else {
            $contentBanner = 'true';
        }
    }
}

echo
'<div class="content">' ;
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    } 
    echo
    '<div class="wrapper">' .
        '<div class="post mid">' ;
            if(have_posts()){
                $post_type_obj = get_post_type_object( get_post_type() );
                $title = apply_filters('post_type_archive_title', $post_type_obj->labels->name );        
                $archive_title = apply_filters('post_type_archive_title', $post_type_obj->labels->all_items);
                echo '<h1>' . $title . '</h1>' .
                (
                    $contentBanner == 'true'
                    ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail( $page->ID ) . '</div>'
                    : ''
                );
            }
            echo
            '<div class="workshop-list">' ;
                wp_reset_query();
                if(have_posts()){
                while (have_posts() ) : the_post();
                    echo '<div class="workshop">' ;
                        if ( has_post_thumbnail() ) :
                            echo '<div class="thumb_small">' . get_the_post_thumbnail('full') . '</div>';
                        endif;
                        echo '<h4>' . get_the_title() . '</h4>' ;
                        $date = get_field('date');
                        $date = new DateTime($date);
                        echo '<div class="date"><strong>Date:</strong>' . $date->format('j M Y') . '</div>' ;               
                        if(get_field('reservation_link')) {
                            echo '<a href="' . get_field('reservation_link') . '" class="read-more" target="_blank"><span>read more</span></a>' ;
                        } else {
                            echo '<a href="' .get_the_permalink() . '" class="read-more"><span>read more</span></a>' ;
                        }
                    echo '</div>' ;
                endwhile;
                } else {
                    echo '<h3> We are coming soon with new workshops ... </h3>';
                }
            echo '</div>' ;
            twentynineteen_the_posts_navigation();
        echo '</div>' ;
        get_sidebar();
    echo '</div>' .
'</div>' ;
get_footer(); 
?>

