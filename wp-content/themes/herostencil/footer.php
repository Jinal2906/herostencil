<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
global $facebook;
global $insta;
global $twitter;
global $google;
global $youtube;
global $linkedin;
global $yelp;
global $google;
?>

</div><!-- #content -->
</div><!-- #page -->

<footer id="" class="site-footer">
    <div class="top-footer">
       <div class="wrapper">
          <?php query_posts(array('post_type' => 'location', 'posts_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC'));
           if( have_posts() ) {
                echo '<div class="left-location">';
                while (have_posts()): the_post();
                    echo '<div class="single-location">' .
                        '<div class="location-map contact-map" loc_lat="' . get_field('location_latitude') . '" loc_long="' . get_field('location_longitude') . '" loc_address="' . get_field('location_address_for_map') . '" loc_map-url="' . get_field('location_map_link') . '"></div>' .
                        '<div class="loc-address">' .
                            '<h4><a href="' . get_the_permalink() . '">' . get_field('custom_title') . '</a></h4>' .
                            (
                                get_field('location_address')
                                ? '<p><a href="'. get_field('location_map_link') .'" target="_blank">' . get_field('location_address') . '</a></p>'
                                : ''
                            ) .
                            (
                                get_field('phone_number')
                                ? '<p><strong>Phone : </strong><a href="tel:' . preg_replace('/[^0-9]/', '', get_field('phone_number') ) . '">' . get_field('phone_number') . '</a></p>'
                                : ''
                            ) .
                            (
                                get_field('fax_number')
                                ? '<p><strong>Fax : </strong>' . get_field('fax_number') . '</p>'
                                : ''
                            ) .
                            (
                                get_field('location_email')
                                ? '<p><strong>Email : </strong><a href="mailto:' . get_field('location_email')  . '">' . get_field('location_email') . '</a></p>'
                                : ''
                            );
                            if( have_rows('social_media') ){
                                echo '<div class="socialmedialinks"><ul>';

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
                                echo '</ul></div>';
                            }

                        echo '</div>' .
                            '</div>' ;
                endwhile;
                echo '</div>';

            }
           wp_reset_query();

           echo '<div class="right-navigation">' . footer_sidebar() . '</div>';

           ?>

        </div>
    </div>

    <?php

        echo '<div class="footer-last copyright-block">' .
        '<div class="wrapper">' .
        '<div class="left-part">' .
        (
            get_field('copyright', 'options')
            ? '<p>' . get_field('copyright', 'options') . '</p>'
            : ''
        ) .
        (
            get_field('website_by', 'options')
            ? '<p>' . get_field('website_by', 'options') . '</p>'
            : ''
        ) .
        '</div>';
            if( have_rows('social_media','options') ){
                echo '<div class="socialmedialinks"><ul>';
                    while ( have_rows('social_media','options') ) : the_row();
                    $icon = get_sub_field('social_media_name','options');
                    echo '<li>' .
                            '<a href="' . get_sub_field('social_media_link','options') . '" target="_blank" class="' . get_sub_field('social_media_name','options') . '">';
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
                echo '</ul></div>';
            }
        echo '</div>' .
    '</div>' ; ?>

</footer><!-- #colophon -->

<?php
$popup_content = get_field( 'popup_content', 'options' );
echo (
    $popup_content
    ? '<div id="theme-popup" class="theme-popup" style="display: none;">'.
        '<div class="inner-popup">'.
            $popup_content.
        '</div>'.
    '</div>'
    : ''
);

wp_footer();

function footer_sidebar() {
    ob_start();

    if ( is_active_sidebar( 'footer-services-nav' ) ) {
        echo '<div class="single-menu">';
            dynamic_sidebar( 'footer-services-nav' );
        echo '</div>';
    }
    if ( is_active_sidebar( 'footer-specialties-nav' ) ) {
        echo '<div class="single-menu">';
            dynamic_sidebar( 'footer-specialties-nav' );
        echo '</div>';
    }
    if ( is_active_sidebar( 'footer-about-nav' ) ) {
        echo '<div class="single-menu">';
            dynamic_sidebar( 'footer-about-nav' );
        echo '</div>';
    }
    if ( is_active_sidebar( 'footer-healthtips-nav' ) ) {
        echo '<div class="single-menu">';
            dynamic_sidebar( 'footer-healthtips-nav' );
        echo '</div>';
    }
    if ( is_active_sidebar( 'footer-contact-nav' ) ) {
        echo '<div class="single-menu">';
            dynamic_sidebar( 'footer-contact-nav' );
        echo '</div>';
    }

    return ob_get_clean();
}

?>
</body>
</html>
