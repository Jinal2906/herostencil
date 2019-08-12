<?php
/**
* @package WordPress
* @subpackage Default_Theme
template name: Services Pages List
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

echo '<div class="content">' ;
        if ( function_exists('yoast_breadcrumb') ) {
          yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
        } 
        echo '<div class="wrapper">' .
            '<div class="mid ' . ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) . ' ">' .
                '<div class="post entry" id="post-' . get_the_ID() .'">' .
                   (
                        $contentBanner == 'true'
                        ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                        : ''
                    );
                    '<h1>' . get_the_title() . '</h1>' ;
                    $args =  array(
                        'child_of' => 4152,
                        'sort_column' => 'post_date',
                        'post_type'    => 'page',
                        'post_status'  => 'publish',
                         'title_li' => '',
                        );
                    wp_list_pages( $args );
                echo '</div>' ;
            edit_post_link('Edit this entry.', '<p>', '</p>');
            echo '</div>' ;
            get_sidebar();
        echo '</div>' .
'</div>' ;
get_footer(); 
?>