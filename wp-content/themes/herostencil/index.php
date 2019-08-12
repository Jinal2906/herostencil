<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();

$page_for_posts = get_option( 'page_for_posts' );
/*$new_bannner_pos = get_field('banner_position', $page_for_posts);
if ( have_posts() && has_post_thumbnail($page_for_posts) && 'Top' == $new_bannner_pos ) : 
echo '<div class="innbaner">' .
    get_the_post_thumbnail($page_for_posts) .
 '</div>';
endif;*/

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
            '<div class="mid blog-listing ' . ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) . ' ">';
                if (have_posts()) : 
                    echo '<div class="post">';
                        echo '<h1>' . get_the_title($page_for_posts) . '</h1>';
                    echo '</div>' .
                    (
                        $contentBanner == 'true'
                        ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail($postID) . '</div>'
                        : ''
                    );  
                    
                    get_header('blog');   
                while (have_posts()) : the_post(); 
                     ?> 
                    <div <?php post_class(); ?> id="post-<?php echo get_the_ID(); ?>'">
                        <?php
                        if ( has_post_thumbnail() ) { 
                            echo '<div class="blog-image">';
                                the_post_thumbnail('full');
                            echo '</div>';
                        }
                        ?>
                        <?php echo '<h2><a href=" ' . get_the_permalink() . ' " rel="bookmark" title="Permanent Link to '. get_the_title() .'">' . get_the_title() . '</a></h2>';
                        echo '<span class="date">' . get_the_time('F jS, Y') . '</span>';
                        echo '<div class="entry"><p>' .  get_the_excerpt() . '</p></div>';                      
                    echo '</div>';
                endwhile; 
                twentynineteen_the_posts_navigation();
                else : 
                    echo '<h2 class="center">Not Found</h2>';
                    echo '<p class="center">Sorry, but you are looking for something that isnt here.</p>';
                    get_search_form();
                endif; 
            echo '</div>' ;             
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
