<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
    } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', $postID) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($postID) . '</div>';
    } else {
        $contentBanner = 'true';
    }
} 

echo '<div class="content">';
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    }
	if (have_posts()) : 
	$post = $posts[0]; // Hack. Set $post so that the_date() works.
    $cat = get_query_var('cat');

$current_tag = single_tag_title("", false);
	echo '<div class="wrapper">' .
	    '<div class="mid blog-listing ' . ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) . ' ">';
            $page_for_posts = get_option( 'page_for_posts' ); ?>
            <h1>Category: <?php single_term_title() ;?></h1>
	      	<?php get_header('blog'); 
            if (have_posts()) : 
            echo (
                    $contentBanner == 'true'
                    ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail($postID) . '</div>'
                    : ''
                );	
			while (have_posts()) : the_post(); 
				 if ( has_post_thumbnail() ) {	the_post_thumbnail('full'); }
                echo '<div class="post" id="post-'. get_the_ID() .'">' .

                    '<h3><a href="' . get_the_permalink() . '" rel="bookmark" title="Permanent Link to '. get_the_title() .'">' . get_the_title() . '</a></h3>' .
                    '<span class="date">' . get_the_time('F jS, Y') . '</span>' .
	            	'<div class="entry"><p>' .  get_the_excerpt() . '</p></div>' .
                '</div>' ;
             endwhile; 
        twentynineteen_the_posts_navigation();
	else :
        echo '<h2 class="center">Not Found</h2>';
        echo '<p class="center">Sorry, but you are looking for something that isnt here.</p>'; 
        get_search_form(); 
	endif;
	    echo '</div>';
        if ( is_active_sidebar( 'posts_widgets' ) ) :
            echo '<div id="sidebar"  class="sidebar">' .
                '<ul>';
                        dynamic_sidebar( 'posts_widgets' ); 
                echo '</ul>' .
             '</div>';
        endif;
    
      	/*echo '<div class="navigation">';
        	echo '<div class="alignleft">';
         		next_posts_link('&laquo; Older Entries');
        	echo '</div>';
        	echo '<div class="alignright">';
           		previous_posts_link('Newer Entries &raquo;') ;
    		echo '</div>';
	    echo '</div>';*/
	    else :

			if ( is_category() ) { // If this is a category archive
	            printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
	        } else if ( is_date() ) { // If this is a date archive
	            echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
	        } else if ( is_author() ) { // If this is a category archive
	            $userdata = get_userdatabylogin(get_query_var('author_name'));
	            printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
	        } else {
	          echo("<h2 class='center'>No posts found.</h2>");
	        }
	            //get_search_form();
	endif; 
	echo '</div>';
echo '</div>';

get_footer();
