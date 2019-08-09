<?php
wp_enqueue_style( 'page-pt-wired-app' );
/**
* Template Name: PT Wired App
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

$introLogo = get_field( 'intro_logo' );

echo '<section class="intro-section">'.
    '<div class="wrapper">'.
        (
            $contentBanner == 'true'
            ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
            : ''
        ).

        '<div class="top-block">'.
            ( 
                $introLogo
                ? '<div class="left-part"><img src="'. $introLogo['url'] .'" alt="'. $introLogo['alt'] .'" /></div>'
                : ''
            ).
            (
                get_field( 'intro_title' )
                ? '<div class="right-part"><h1>'. get_field( 'intro_title' ) .'</h1></div>'
                : ''
            ).
        '</div>'.
        '<div class="middle-block">';
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
        echo '</div>'.
        '<div class="bottom-block">'.
            (
                get_field( 'member_login_button_link' )
                ? '<a href="'. get_field( 'member_login_button_link' ) .'" class="read-more btn-login" target="_blank">'. get_field( 'member_login_button_text' ) .'</a>'
                : ''
            ).
            (
                get_field( 'ios_button_link' )
                ? '<a href="'. get_field( 'ios_button_link' ) .'" class="read-more btn-ios" target="_blank">'. get_field( 'ios_button_text' ) .'</a>'
                : ''
            ).
            (
                get_field( 'play_store_button_link' )
                ? '<a href="'. get_field( 'play_store_button_link' ) .'" class="read-more btn-google" target="_blank">'. get_field( 'play_store_button_text' ) .'</a>'
                : ''
            ).
        '</div>'.
    '</div>'.
'</section>'.

'<section class="feature-section">'.
    '<div class="wrapper">'.
        '<div class="feature-block">'.
            (
                get_field('features_image')
                ? '<div class="feature-image">'. wp_get_attachment_image( get_field('features_image') , 'full' ) .'</div>'
                : ''
            ).
            
            '<div class="feature-content">'.
                (
                    get_field( 'features_title' )
                    ? '<h3>'. get_field( 'features_title' ) .'</h3>'
                    : ''
                );
                
                if( have_rows( 'features_list' ) ) {
                    echo '<div class="text-block">';
                        while( have_rows( 'features_list' ) ) : the_row();
                            $heading = get_sub_field( 'heading' );
                            $content = get_sub_field( 'content' );
                            if( $heading || $content ) :
                                echo (
                                    $heading
                                    ? '<h4>'. $heading .'</h4>'
                                    : ''
                                ).
                                (
                                    $content
                                    ? '<ul><li>'. $content .'</li></ul>'
                                    : ''
                                );
                            endif;
                        endwhile;
                    echo '</div>';
                }
            echo '</div>'.
        '</div>'.
    '</div>'.
'</section>'.

'<section class="exercise-section">'.
    '<div class="wrapper">'.
        (
            get_field( 'exercises_title' )
            ? '<h2>'. get_field( 'exercises_title' ) .'</h2>'
            : ''
        ).
        (
            get_field( 'exercises_content' )
            ? '<div class="description">'. get_field( 'exercises_content' ) .'</div>'
            : ''
        ).
    '</div>'.
'</section>';

get_footer(); ?>
