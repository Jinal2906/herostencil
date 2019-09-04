<?php
wp_enqueue_style( 'page-staff' );
get_header();
global $contentBanner;
if ( has_post_thumbnail('4142') ){
    if( 'Top' == get_field( 'banner_position_new', '4142' ) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail('4142') . '</div>';
    } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', '4142') ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail('4142') . '</div>';
    } else {
        $contentBanner = 'true';
    }
}
while ( have_posts() ) : the_post();
echo
'<div class="content">' ;
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    } 
    echo
    '<div class="wrapper">' .
        '<div class="mid ' . ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) . ' ">' ;
            $postObj = get_post_type_object( get_post_type() );
            if ($postObj) {
                $rewriteSlug = $postObj->rewrite['slug'];
                $pageObj = get_page_by_path( $rewriteSlug );
                echo '<h1>'. $pageObj->post_title .'</h1>';
            }
            echo 
            '<div class="staff-single d-flex">' .
                '<div class="staff-left mb-640-20">' .
                    (
                        has_post_thumbnail(get_the_ID())
                        ? get_the_post_thumbnail(get_the_ID(), 'staff-thumb', array( 'class' => '' ) )
                        : '<img src="' . get_template_directory_uri() .'/images/defaultUser.jpg" alt="Staff Image">'
                    );
                    if( have_rows('certifications_images') ){
                        echo '<div class="certifications-images">';
                            while( have_rows('certifications_images') ) : the_row();
                                echo  '<img src="' . get_sub_field('certifications_image')['url'] . '" alt="' . get_sub_field('certifications_image')['alt'] . '" />';
                            endwhile; wp_reset_query();
                        echo '</div>';
                    } 
                echo '</div>' .
                '<div class="staff-right ml-25 ml-640-0">' .
                    '<h3 class="mb-15 pb-15 text-24 mt-0">' .
                        get_the_title() ;
                        $sdesi = get_field('staff_designation');
                        echo
                        (
                            $sdesi
                            ? ', <span class="text-16 font-normal ml-5">' . get_field('staff_designation') .'</span>'
                            :''
                        ) .
                    '</h3>' .
                    get_the_content() .
                '</div>' .
            '</div>' .
        '</div>' .
    '</div>' .
'</div>' ;
endwhile;
get_footer(); 
?>