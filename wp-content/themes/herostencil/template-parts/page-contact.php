<?php
wp_enqueue_style( 'page-contact' );
/**
* @package WordPress
* @subpackage Default_Theme
template name: Contact Page
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
    };
    echo '<div class="wrapper">' .
         '<div class="mid ' . ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) . ' ">' .
           	'<div class="post" id="post-' . get_the_ID() .'">' .
                '<h1>' . get_the_title() . '</h1>' .
                (
                    $contentBanner == 'true'
                    ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                    : ''
                ) .
                '<div class="entry">';
                    while (have_posts()) : the_post();
                    	get_the_content('<p class="serif">Read the rest of this page &raquo;</p>');
                    endwhile;
                    wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
                echo '</div>';
                $wpq = array (
                    'post_type'       =>'location',
                    'orderby'         => 'ID',
                    'order'           => 'ASC',
                    'posts_per_page'  => -1
                );
                $myquery = new WP_Query ($wpq);
                echo '<div class="block-section">';
                        $map_no=1; while ($myquery->have_posts()) : $myquery->the_post();
                      	echo '<div class="contatblock">' .
                            	'<div class="map-block">' .                              
                                	'<div class="location-map contact-map" loc_lat="' . get_field('location_latitude') . '" loc_long="'. get_field('location_longitude') .'" loc_address="'. get_field('location_address_for_map') .'"  loc_map-url="' . get_field('location_map_link') . '"></div>'.
                            	'</div>' .
	                        	'<h5>'. get_field('custom_title') . '</h5>' .
	                        	get_field('location_address') .
	                        	'<br>'.
	                        	(
	                        		(get_field('phone_number'))
	                        		?'<div class="location-contact"><strong>Phone:</strong><a href="tel:'. preg_replace('/[^0-9]/', '', get_field('phone_number') ) .'">' . get_field('phone_number') . '</a></div>'
	                        		: ''
	                        	) .
	                        	(
	                        		(get_field('fax_number'))
	                        		?'<div class="location-contact"><strong>Fax:</strong>' . get_field('fax_number') . '</div>'
	                        		: ''
	                        	) . 
	                        	(
	                        		(get_field('location_email'))
	                        		?'<div class="location-contact"><strong>Email:</strong><a href="mailto:' . get_field('location_email') . '">' . get_field('location_email') . '</a></div>'
	                        		: ''
	                        	) . 
	                        	(
	                        		(get_field('working_hour'))
	                        		?'<div class="wrk-hours"><h5>Business hours</h5>' . get_field('working_hour') . '</div>'
	                        		: ''
	                        	) . 
                        	'</div>' ;
                        $map_no++; endwhile; wp_reset_query();
                echo '</div>'.     
            '</div>';
         	edit_post_link('Edit this entry.', '<p>', '</p>');
        echo '</div>';
     	get_sidebar();
    echo '</div>'.
'</div>'.
get_footer();
?>