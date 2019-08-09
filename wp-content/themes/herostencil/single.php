<?php
/**
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>
<script type="text/javascript">
  addthis.layers({
    'recommended' : {},
    // This will disable the Thank You Layer
    'thankyou' : false
  });
</script>
<?php 
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
	   echo '<div class="wrapper">' .
	        '<div class="mid blog-details ' . ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) . ' ">';
	       		if (have_posts()) :
                echo (
                    $contentBanner == 'true'
                    ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail($postID) . '</div>'
                    : ''
                );
	            while (have_posts()) : the_post(); ?>
	             	<div <?php post_class(); ?> id="post-<?php echo get_the_ID(); ?>'">
	             		<?php echo '<h1>' . get_the_title() . '</h1>';
                        echo '<span class="date">' . get_the_time('F jS, Y') . '</span>';
	             		echo '<div class="addthis_toolbox addthis_default_style">' .
	             		    '<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>' .
	             		    '<a class="addthis_button_tweet"></a>' .
	             		    '<a class="addthis_counter addthis_pill_style"></a>' .
	             		'</div>' ;
	             		echo '<div class="post-img">';
	             			if ( has_post_thumbnail() ) { 
	             				the_post_thumbnail('full'); 
	             			} 
	             		echo '</div>';
			            echo '<div class="entry">';
			            	the_content('<p class="serif">Read the rest of this entry </p>');
                     		wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
                    		the_tags( '<p>Tags: ', ', ', '</p>');
			            echo '</div>';
	            	echo '</div>';
	            endwhile; else :
	            	echo '<p>Sorry, no posts matched your criteria.</p>';
	            endif;	
	        echo '</div>';
	        if ( is_active_sidebar( 'posts_widgets' ) ) :
                echo '<div id="sidebar"  class="sidebar">' .
                    '<ul>';
                            dynamic_sidebar( 'posts_widgets' ); 
                    echo '</ul>' .
                 '</div>';
            endif;
	    echo '</div>';
echo '</div>';


get_footer();
