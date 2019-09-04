<?php

/**
 * Template Name: Staff Page - Designation Filter
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
wp_enqueue_style( 'page-staff' );
wp_enqueue_script( 'isotop-lib' );
wp_enqueue_script( 'isotop-function' );
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
                $terms = get_terms('staff_category');
                echo '<div class="container">' .
                    '<ul class="masonary-list m-0 mb-20 p-0 d-flex list-none">' .
                        '<li class="ml-5 mr-5 p-0 mb-767-10"><a href="#" data-filter="*" class="current read-more d-inline-block" id="all" data-sort-by="number"><span>' . esc_attr('View all', 'bodygears') . '</span></a></li>' ;
                        foreach ($terms as $term) {
                            echo '<li class="ml-5 mr-5 p-0 mb-767-10"><a class="d-inline-block read-more" href="javascript:;" data-filter=".' . $term->slug . '" id="' .    $term->slug . '" data-sort-by="number"><span>' . ucfirst($term->name) . '</span></a></li>';
                        }
                    echo '</ul>' ;
                echo '</div>' .
                    (
                        $contentBanner == 'true'
                        ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                        : ''
                    ) ;
                    echo '<ul class="staff-list p-0 d-flex row-10 list-none">' ;
                    $args = array(
                        'post_type' => 'our_staff',
                        'posts_per_page'  => -1,
                        'orderby' => 'menu_order', 
                        'order' => 'ASC', 
        
                    );
                    $myquery = new WP_Query($args);
                    $article_count = $myquery->post_count;
                    if ($article_count) {
                        $unique_terms = array();
                        $i = 1;while ($myquery->have_posts()): $myquery->the_post();
                        $do_not_duplicate[] = $post->ID;
                        if (!in_array($post->ID, $unique_terms)):
                        array_push($unique_terms, $post->ID);
                        if ($post->ID == $do_not_duplicate) {
                            continue;
                        }
                        $categories = array();
                        $terms = wp_get_post_terms($post->ID, 'staff_category');
                        foreach ($terms as $term) {$categories[] = $term->slug;}
                        $stafflist = implode(" ", $categories); 
                        echo '<li class="element-item cell-3 cell-992-4 cell-640-6 cell-480-10 p-10 box-sizing-border-box ' . $stafflist . '">' .
                            '<div class="in bg-gray">' .
                                '<a class="stflink d-block" href="' . get_the_permalink() . '">' ;
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('staff-thumb', array('class' => 'width-full'));
                                    } else { 
                                        echo '<img class="width-full" src="' .get_template_directory_uri() .'/images/defaultUser.jpg" alt="Staff Image" >';
                                    }
                                echo '</a> '.
                                '<div class="staff-short width-full p-20">' .
                                    '<h5 class="m-0 text-16"><a class="" href="<?php the_permalink();?>">' . get_the_title() . '</a></h5>'.
                                    '<span class="d-block">' . get_field('staff_designation') .  '</span>' .
                                '</div>' .
                            '</div>' .
                        '</li>' ;
                        $i++; endif; endwhile;
                    }
                    echo '</ul>' ;
            echo '</div>' ;
    echo '</div>' ;
echo '</div>' ;
get_footer();
?>