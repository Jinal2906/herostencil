<?php
wp_enqueue_style( 'page-location-list' );
/**
* Template Name: Location Page
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
echo '<div class="content">' ;
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    }
	echo '<div class="wrapper">' .
		'<div class="mid ' . ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) . ' ">' .
			'<h1>' . get_the_title() . '</h1>' .
        	 (
	            $contentBanner == 'true'
	            ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
	            : ''
        	);
			$wpq = array (
				'post_type'       =>'location',
				'orderby'         => 'ID',
				'order'           => 'ASC',
				'posts_per_page'  => -1
			);
			$myquery = new WP_Query ($wpq);
			$article_count = $myquery->post_count;
			if ($article_count) {
			echo '<div class="locations-list">' ;
					$i=1; while ($myquery->have_posts()) : $myquery->the_post();
					echo '<div class="loc_list">' .
						'<div class="loc_thumb">';
							if ( has_post_thumbnail() ) { 
								the_post_thumbnail('full'); 
							} ;
						echo '</div>'.
						'<div class="location_content">' .	
							(
								get_field('custom_title')
								?'<h4><strong>' . get_field('custom_title') . '</strong></h4>'
								: ''
							) .
							(
								get_field('location_address')
								?'<span class="adrs">Address </span><p>' . get_field('location_address') . '</p>'
								: ''
							) .
							(
								get_field('phone_number')
								?'<div class="location-contact"><strong>Phone:</strong><a href="tel:' . preg_replace('/[^0-9]/', '', get_field('phone_number') ) . '">' . get_field('phone_number') . '</a></div>'
								: ''
							) .			
							(
								get_field('fax_number')
								?'<div class="location-contact"><strong>Fax:</strong>' . get_field('fax_number') . '</div>'
								: ''
							) .	
							(
								get_field('location_email')
								? '<div class="location-contact"><strong>Email:</strong><a href="mailto:' . get_field('location_email'). '">' .get_field('location_email') . '</a></div>'
								: ''
							) .
						'</div>' .
						'<div class="location_btns">' .
							'<a href="' .get_the_permalink() . '" class="info_btn">Info</a>' .
							'<a class="map_btn" target="_blank" href="' . get_field('location_map_link') . '"> Map </a>' .
						'</div>' .
					'</div>' ;
					$i++; endwhile;
			echo '</div>' ;
			}			
		echo '</div>' .
	'</div>' .
'</div>';
get_footer(); 
?>