<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
global $contentBanner;
$postID = get_option('page_for_posts', true);
global $contentBanner;
if ( has_post_thumbnail($postID) ){
    if( 'Top' == get_field( 'banner_position_new', $postID ) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($postID) . '</div>';
    } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', $postID ) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($postID) . '</div>';
    } else {
        $contentBanner = 'true';
    }
} 
    echo '<div class="content">';
        if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
        }
	    echo '<div class="wrapper">' .
        '<div class="mid blog-listing ' . ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) . ' ">' .
        '<h1> Search Result: ' . get_search_query() . '</h1>'; 
        get_header('blog'); 
		if ( have_posts() ) :
        echo (
            $contentBanner == 'true'
            ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail($postID) . '</div>'
            : ''
        );
        
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				//get_template_part( 'template-parts/content/content', 'excerpt' );
             if ( has_post_thumbnail() ) {	the_post_thumbnail('full'); }
                echo '<div class="post" id="post-'. get_the_ID() .'">' .
                    '<h3><a href="' . get_the_permalink() . '" rel="bookmark" title="Permanent Link to '. get_the_title() .'">' . get_the_title() . '</a></h3>' .
                    '<span class="date">' . get_the_time('F jS, Y') . '</span>' .
	            	'<div class="entry"><p>' .  get_the_excerpt() . '</p></div>' .
                '</div>' ;

				// End the loop.
			endwhile;

			// Previous/next page navigation.
			twentynineteen_the_posts_navigation();
           
        
            
           
			// If no content, include the "No posts found" template.
		else :
			//get_template_part( 'template-parts/content/content', 'none' );
            echo 'No Post Found for "' . get_search_query() . '" please try another keyword';
        
		endif;
		
		echo '</div>';
if ( is_active_sidebar( 'posts_widgets' ) ) :
                echo '<div id="sidebar"  class="sidebar">' .
                    '<ul>';
                            dynamic_sidebar( 'posts_widgets' ); 
                    echo '</ul>' .
                 '</div>';
            endif;
		echo '</div>' .
		'</div>';


get_footer();
