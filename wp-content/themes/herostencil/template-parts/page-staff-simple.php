<?php
wp_enqueue_style( 'page-staff' );
/**
 * Template Name: Staff Page
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
          yoast_breadcrumb( '<div id="breadcrumbs " class="breadcrumbs"><div class="wrapper"><div class="inner-bc"','</div></div></div>' );
        } 
        echo '<div class="wrapper">' .
         '<div class="mid ' . ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) . ' ">' .
            '<h1>' . get_the_title() . '</h1>' ;
            (
              $contentBanner == 'true'
              ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
              : ''
            ) ;
            $terms = get_terms('staff_category');
            foreach ($terms as $term) {
            $wpq = array ('taxonomy'=>'staff_category','term'=>$term->slug, 'orderby' => 'ID', 'order' => 'ASC', 'posts_per_page' => -1);
            $myquery = new WP_Query ($wpq);
            $article_count = $myquery->post_count;
            '<h4 class="staff-head">' . $term->name . '</h4>' ;
            if ($article_count) {
              echo '<ul class="staff-list p-0 d-flex row-10 list-none">' ;
                    $i=1; while ($myquery->have_posts()) : $myquery->the_post();
                    echo '<li class="cell-3 cell-992-4 cell-640-6 cell-480-10 p-10 box-sizing-border-box">' .
                          '<div class="in bg-gray">' .
                              '<a class="d-block" href="' . get_the_permalink() . '">' .
                                  (
                                    has_post_thumbnail($myquery->ID)
                                    ? get_the_post_thumbnail( $myquery->ID,  'staff-thumb', array( 'class' => 'width-full' ) )
                                    : '<img class="width-full" src="' . get_template_directory_uri() .'/images/defaultUser.jpg" alt="Staff Image" >'
                                  ) .
                              '</a>' .
                              '<div class="staff-short width-full p-20"> ' .
                                '<h5 class="m-0 text-16"><a class="" href="' .get_the_permalink() .'">' . get_the_title() . '</a></h5>' .
                                '<span class="d-block">' . get_field('staff_designation') . '</span>' .
                              '</div>' .
                        '</div>' .
                    '</li>' ;
                    $i++; endwhile;
            echo '</ul>' ;
          } }
        echo '</div>' .
      '</div>' ;
echo '</div>' ;
get_footer(); 
?>

