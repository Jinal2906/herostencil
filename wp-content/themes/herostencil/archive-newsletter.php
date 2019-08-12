<?php
wp_enqueue_style( 'archive-newsletter-page' );
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();

global $contentBanner;
wp_reset_query();wp_reset_postdata();
$post_type_obj = get_post_type_object( get_post_type() );
$archive_title = apply_filters('post_type_archive_title', $post_type_obj->labels->name);
$page = get_page_by_path( $archive_title );
if ( has_post_thumbnail($page->ID) ){
    if( 'Top' == get_field( 'banner_position_new',$page->ID ) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
    } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', $page->ID) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
    } else {
        $contentBanner = 'true';
    }
}

echo
'<div class="content">' ;
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    }
    echo
    '<div class="wrapper">' .
        '<div class="mid">' ;           
            if ( have_posts() ) :
            echo '<div class="post" id="post-'.get_the_ID().'">';           
                $post_type_obj = get_post_type_object( get_post_type() );
                $title = apply_filters('post_type_archive_title', $post_type_obj->labels->name );        
                $archive_title = apply_filters('post_type_archive_title', $post_type_obj->labels->all_items); 
                echo '<h1>' . $title . '</h1>' .
                (
                    $contentBanner == 'true'
                    ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail( $page->ID ) . '</div>'
                    : ''
                ) .
                '<ul class="news-listing">' ;
                    while (  have_posts() ) :the_post();
                    echo '<li>' .
                        '<div class="news-img">' ;
                            if ( has_post_thumbnail() ) { the_post_thumbnail('news-thumb'); }
                        echo '</div>' .
                        '<div class="news-detail">' ;
                            $valuepdf = get_field( "newsletter_pdf" );
                            $valuelink = get_field( "newsletter_link" );
                            if($valuepdf != ''){ 
                                echo '<h3><a target="_blank" href="' . $valuepdf . '">' . get_the_title() . '</a></h3>' ;
                            } else {
                                echo '<h3><a target="_blank" href="' . $valuelink . '">' . get_the_title() . '</a></h3>' ;
                            }
                            echo '<div class="post-meta"><strong>Date: </strong>' . get_the_time('F j, Y') . '</div>' .
                        '</div>' .
                    '</li>' ;
                    endwhile;
                echo ' </ul>' ;
                twentynineteen_the_posts_navigation();
            echo '</div>' ;
            endif;
        echo '</div>' ;
        get_sidebar();
    echo '</div>' .
'</div>' ;
get_footer(); 
?>