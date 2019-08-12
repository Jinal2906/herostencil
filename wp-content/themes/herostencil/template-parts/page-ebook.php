<?php
wp_enqueue_style( 'page-ebook' );

/**
* @package WordPress
* @subpackage Default_Theme
template name: Ebook Page
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
echo '<div class="content">' .
    '<div class="wrapper">' .
        '<div class="mid">' .
            '<div class="post">'.
                '<h1>' . get_the_title() . '</h1>' .
                (
                    $contentBanner == 'true'
                    ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                    : ''
                ).
                '<div class="help-block clearfix" id="help-block">';
                    $link_title = get_field('download_cta_text'); $id_count = '1'; $CountNumber = '1';
                    if( have_rows('add_tips_block') ): 
                    echo '<div class="ebook-wrapper">';
                        while( have_rows('add_tips_block') ): the_row();            
                        $image = get_sub_field('ebook_image');
                        $short_description = get_sub_field('short_description');
                        echo '<div class="ebook-block">'.
                        (
                            ( $short_description )
                            ?'<h2>' . $short_description . '</h2>'
                            :''
                        ) .
                        (
                            ( $image )
                            ?'<img src="'. $image .'" />'
                            :''
                        ) .
                        (
                            (get_field('ebook_cta_text'))
                            ? '<div class="btn-row"><a data-fancybox href="#ebook-popup'.$CountNumber.'" class="read-more"><span>' .get_field('ebook_cta_text') .'</span></a></div>'
                            : ''
                        ).
                        '</div>';
                        $CountNumber++; endwhile;
                    echo '</div>' .
                    '<div style="display:none;">';         
                        while( have_rows('add_tips_block') ): the_row();
                        echo '<div id="ebook-popup'.$id_count.'" class="pupup_frm">'.
                                '<div class="inner">';
                                    $subscribe_book_popup_title = get_field('subscribe_book_popup_title');
                                    echo 
                                    (
                                        $subscribe_book_popup_title
                                        ?'<h2>' . $subscribe_book_popup_title . '</h2>'
                                        :''
                                    );
                                    echo do_shortcode(get_sub_field('form_short_code'));
                            echo '</div>' .
                        '</div>';
                        $id_count++; endwhile;
                    echo '</div>' ;
                    endif;
                echo '</div>'.
            '</div>'.
        '</div>'.
    '</div>'.
'</div>';
get_footer(); 
?>