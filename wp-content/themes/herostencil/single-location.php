<?php
wp_enqueue_style( 'single-location' );
/**
* @package WordPress
* @subpackage Default_Theme
template name: Location Template
*/
get_header();

global $contentBanner;
if ( has_post_thumbnail('4141') ){
    if( 'Top' == get_field( 'banner_position_new', '4141' ) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail('4141') . '</div>';
    } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', '4141') ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail('4141') . '</div>';
    } else {
        $contentBanner = 'true';
    }
}
?>

<?php

echo '<div class="content pb-0">' ;
     if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
     }

        echo '<div class="wrapper">' .
            '<div class="mid p-0">' .

                    '<div class="location-contents">' ;

                                //Location Banner
                                if(get_field('location_banner_image')) {
                                echo '<div class="location-banner position-relative mb-20">' .
                                    '<img src="' . get_field('location_banner_image') . '" alt="">' .
                                     (
                                         get_field('location_banner_title')
                                        ? '<h1 class="position-absolute pos-top-50pt pos-left-50pt transform-center text-center text-36 text-capitalize">' . get_field('location_banner_title') . '</h1>'
                                        : ''
                                     ) .
                                '</div>' ;
                                }


                                echo (
                                     get_field('custom_title')
                                    ? '<h2 class="center-text text-center">' . get_field('custom_title') . '</h2>'
                                    : ''
                                ) ;
                                if (have_posts()){ while (have_posts()) : the_post();
                                    echo '<div class="location-content text-center">' . get_the_content() .  '</div>' ;
                                endwhile; }

                                //Location Info
                                echo '<div class="location-info-part width-full height-auto position-relative d-flex justify-content-center row-10">' .
                                        '<div class="location-info cell-4 p-10 text-16 font-normal">' .
                                            (
                                                 esc_html__( 'Address', 'Hero' )
                                                ? '<h4 class="mb-15">' . esc_html__( 'Address', 'Hero' ) . '</h4>'
                                                : ''
                                             ) .
                                            '<div class="address">' . get_field('location_address') . '</div>' .
                                            (
                                                get_field('phone_number')
                                                ? '<div>P:' .
                                                      '<a href="tel:' . preg_replace('/[^0-9]/', '', get_field('phone_number') ) . '">' . get_field('phone_number'). '</a>' .
                                                   '</div>'
                                                : ''
                                            ) .
                                            (
                                                 get_field('fax_number')
                                                ? '<div>F:' . get_field('fax_number') . '</div>'
                                                : ''
                                             ) .
                                        '</div>' .
                                        (
                                            get_field( "working_hour" )
                                            ? '<div class="business-hours location-info cell-4 p-10">' .
                                                '<h4 class="mb-15">' . esc_html__( 'Business Hours', 'Hero' ) . '</h4>' .
                                                get_field('working_hour')
                                            : ''
                                         ) .
                                         /* if( have_rows('gallery') ){

                                                } else {
                                                if( have_rows('social_media') ){
                                                    echo '<div class="location-info cell-4 p-10">' .
                                                        '<h4 class="mb-15">' . esc_html__( 'Address', 'Hero' ) . '</h4>' .
                                                        '<div class="socialmedialinks">' .
                                                        '<ul class="d-flex justify-content-center">';
                                                    global $facebook;
                                                    global $insta;
                                                    global $twitter;
                                                    global $google;
                                                    global $youtube;
                                                    global $linkedin;
                                                    global $yelp;
                                                    global $google;
                                                    while ( have_rows('social_media') ) : the_row();
                                                    $icon = get_sub_field('social_media_name');
                                                    echo '<li>' .
                                                        '<a href="' . get_sub_field('social_media_link') . '" target="_blank" class="' . get_sub_field('social_media_name') . '">';
                                                    if($icon == "facebook"){
                                                        echo $facebook;
                                                    } else if($icon == "insta") {
                                                        echo $insta;
                                                    } else if($icon == "twitter") {
                                                        echo $twitter;
                                                    } else if($icon == "google+") {
                                                        echo $google;
                                                    } else if($icon == "youtube") {
                                                        echo $youtube;
                                                    } else if($icon == "linkedin") {
                                                        echo $linkedin;
                                                    } else if($icon == "yelp") {
                                                        echo $yelp;
                                                    } else if($icon == "google+") {
                                                        echo $google;
                                                    }
                                                    echo '</a>' .
                                                        '</li>';
                                                    endwhile;
                                                    echo '</ul>' .
                                                        '</div>' .
                                                        '</div>';
                                                }
                                            }
                                        */
                                '</div>' .

                    '</div>' .

            '</div>' ;

        echo '</div>' ;


            if(have_rows('gallery')) {
                echo '<div class="sidebar border-radius-0">' .
                    '<div class="side-gallery-main p-15">' .
                            '<div class="side-gallery">' .
                                '<h5 class="text-brand-primary text-16 font-bold pb-10 mb-10">' . get_field('gallery_title') . '</h5>' ;
                                $gallery = get_field('gallery');
                                echo '<div class="gallery">' ;
                                    foreach($gallery as $gallery_image):
                                      echo '<a href="' . $gallery_image['url'] . '" data-fancybox="gallery" class="galleryitem mb-20" >' .
                                           '<span class="innbaner image-src pt-70 mb-15">' .
                                                '<img src="'. $gallery_image['sizes']['thumbnail'] . '">' .
                                           '</span>' .
                                      '</a>' ;
                                     endforeach;
                                  echo '</div>' .

                            '</div>' ;
                            if(have_rows('social_media')) {
                                echo '<div class="socialmedialinks">' .
                                    '<ul>';
                                global $facebook;
                                global $insta;
                                global $twitter;
                                global $google;
                                global $youtube;
                                global $linkedin;
                                global $yelp;
                                global $google;
                                while ( have_rows('social_media') ) : the_row();
                                $icon = get_sub_field('social_media_name');
                                echo '<li>' .
                                    '<a href="' . get_sub_field('social_media_link') . '" target="_blank" class="' . get_sub_field('social_media_name') . '">';
                                    if($icon == "facebook") {
                                        echo $facebook;
                                    } else if($icon == "insta") {
                                        echo $insta;
                                    } else if($icon == "twitter") {
                                        echo $twitter;
                                    } else if($icon == "google+") {
                                        echo $google;
                                    } else if($icon == "youtube") {
                                        echo $youtube;
                                    } else if($icon == "linkedin") {
                                        echo $linkedin;
                                    } else if($icon == "yelp") {
                                        echo $yelp;
                                    } else if($icon == "google+") {
                                        echo $google;
                                    }
                                    echo '</a>' .
                                '</li>';
                                endwhile;
                                echo '</ul>' .
                                '</div>';
                            }
                echo '</div></div>' ;
                }
            echo '</div>' ; //wrapper close


        //Location Service
        if( have_rows('location_service')) {
        echo '<div class="location-service width-full height-auto position-relative pt-50 pb-20">' .
            '<div class="wrapper">' .
                '<ul class="m-0 p-0 list-none d-flex row-10">' ;
                    while( have_rows('location_service') ): the_row();
					$do_you_want_to_add_image = get_sub_field( 'do_you_want_to_add_image' );
                    $image = get_sub_field('icon');
                    $title = get_sub_field('title');
                    $content = get_sub_field('content');
                    $serviceImage = get_sub_field('service_image');

                   echo '<li class="cell-4 p-10 text-center">' .
                        (
                            $do_you_want_to_add_image == 'no'
                            ? '<div class="image width-full d-flex justify-content-center align-items-end mb-20">' . file_get_contents($image) . '</div>'
                            : '<div class="image image-src innbaner width-full d-flex justify-content-center align-items-end mb-20">' . wp_get_attachment_image( $serviceImage , 'medium') . '</div>'
                        ) .
                        (
                            $title
                            ? '<h3>' . $title . '</h3>'
                            : ''
                        ) .
                       (
                            $content
                            ? '<p>' . $content . '</p>'
                            : ''
                        ) .
                    '</li>' ;
                     endwhile;
                echo '</ul>' .
            '</div>' .
        '</div>' ;
        }

        //Location Therapist
        if(get_field('locations_therpist')) {
        echo '<div class="location-therapists-section width-full height-auto d-block position-relative">' .
            '<div class="wrapper bg-offwhite">' ;
                $posts = get_field('locations_therpist');
                if($posts) {

                    echo '<h3 class="brand-primary text-center mb-35">' . get_field('location_staff_main_title') . '</h3>' .
                    '<div class="location-staff-section">' .
                        '<div class="location-staff-text">' .
                            get_field('location_staff_text') .
                        '</div>' .
                        '<ul class="staff-list cell-8">' ;
                           $i=1; foreach( $posts as $p ): // variable must NOT be called $post (IMPORTANT)
                            echo '<li class="m-25">' .
                               '<div class="innbaner image-src">' .
                                    (
                                        has_post_thumbnail( $p->ID )
                                        ? get_the_post_thumbnail( $p->ID , 'staff-thumb', array( 'class' => '' ) )
                                        : '<img src="' . get_stylesheet_directory_uri() . '/images/defaultUser.jpg' . '">'
                                    ) .
                                '</div>' .
                                '<div class="staff-short equal-height brand-primary text-center">' .
                                    '<h5 class="text-white font-normal m-0">' . get_the_title( $p->ID ) . '</h5>' .
                                    '<a class="text-white" href="' . get_permalink( $p->ID ) . '" title="Read More">Read More</a>' .
                                '</div>' .
                            '</li>' ;
                            $i++; endforeach;
                        echo '</ul>' .
                    '</div>' ;

                }
           echo '</div>' .
        '</div>' ;
        }

        //Text Block
        if(get_field('text_block_image') || get_field('text_block_content')) {
        echo '<div class="image-content-block">' .
            '<div class="wrapper">' .
                (
                    get_field('text_block_image')
                    ? '<div class="image-block ">' .
                            '<div class="inn-image image-src innbaner">' .
                                wp_get_attachment_image( get_field('text_block_image'), 'full' ) .
                            '</div>' .
                        '</div>'
                    : ''
                ) .
                (
                    get_field('text_block_content')
                    ? '<div class="content-block">' .
                            get_field('text_block_content') .
                      '</div>'
                    : ''
                ) .
            '</div>' .
        '</div>' ;
        }

        //Testimonial Start
        if(get_field('location_testimonial')) {
           echo '<div class="location-testimonial">' .
                '<div class="wrapper">' .
                    '<div class="view_tesi">' .
                        (
                            get_field('location_testimonial_title')
                            ? '<h2>' . get_field('location_testimonial_title') . '</h2>'
                            : ''
                        ) .
                        '<div class="testimonial-slide cf">' ;
                            //$cp = get_the_id();
                            $posts = get_field('location_testimonial');
                            if( $posts ) {
                                foreach( $posts as $post):
                                setup_postdata($post);
                                echo '<div class="testimonial-items">' .
                                    '<div class="testimonial-content">' .
                                        '<p>' . get_the_content() . '</p>'.
                                    '</div>' .
                                    '<h5>' . get_the_title() . '</h5>' .
                                '</div>' ;
                                endforeach;
                            } wp_reset_query();
                        echo '</div>' .
                   '</div>' .
                '</div>' .
            '</div>' ;
        }

        //Location Map Start
        echo '<div class="location-maps">' .
            '<div class="location-map contact-map" loc_lat="' . get_field('location_latitude') . '" loc_long="' . get_field('location_longitude') . '" loc_address="' . get_field('location_address_for_map') . '" loc_map-url="' . get_field('location_map_link') . '"></div>' .
        '</div>' ;

        //Request Form Start-->
        if(get_field('request_form')) {
        echo '<div class="request-appointment">' .
            '<div class="wrapper cf">' .
                '<div class="req-content">' .
                    (
                        get_field('request_title')
                        ? '<h4>' . get_field('request_title') . '</h4>'
                        : ''
                    ) .
                    (
                        get_field('request_content')
                        ? '<p>' . get_field('request_content') . '</p>'
                        : ''
                    ) .
                '</div>' .
                '<div class="req-form">' .
                    do_shortcode(get_field('request_form')) .
                '</div>' .
            '</div>' .
        '</div>' ;
        }

 '</div>' ;
?>

<?php get_footer();?>
