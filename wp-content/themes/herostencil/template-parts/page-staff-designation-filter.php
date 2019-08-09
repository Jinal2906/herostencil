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
?>
<?php 
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
?>

<div class="content">
   <?php 
    if ( function_exists('yoast_breadcrumb') ) {
          yoast_breadcrumb( '<div id="breadcrumbs " class="breadcrumbs"><div class="wrapper"><div class="inner-bc"','</div></div></div>' );
        } 
    ?>
    <div class="wrapper">
        <div class="mid <?php  echo ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ); ?> ">
            <h1><?php the_title(); ?></h1>

            <?php
            $terms = get_terms('staff_category');
            ?>

            <!-- PANEL 1 -->
            <div class="container">
                <!-- Filter menu -->
                <ul class="masonary-list">
                    <li><a href="#" data-filter="*" class="current read-more" id="all"><span><?php esc_attr_e('View all', 'bodygears');?></span></a></li>
                    <?php
                    foreach ($terms as $term) {
                        echo '<li><a class="read-more" href="javascript:;" data-filter=".' . $term->slug . '" id="' .    $term->slug . '"><span>' . ucfirst($term->name) . '</span></a></li>';
                    }
                    ?>
                </ul>
                <!-- Filter menu end -->

            </div>
            <?php
            echo (
                $contentBanner == 'true'
                ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                : ''
            );
            ?>
            <ul class="staff-list">
                <?php $terms = get_terms('staff_category');

                foreach ($terms as $term) {
                    $do_not_duplicate[] = $term->ID;
                    $wpqnew = array('taxonomy' => 'staff_category', 'term' => $term->slug , 'post__not_in' => $do_not_duplicate, 'orderby' => 'menu_order' ,'order' => 'ASC', 'posts_per_page' => -1);
                    $myquery = new WP_Query($wpqnew);
                    $article_count = $myquery->post_count;
                    if ($article_count) {
                        $unique_terms = array();
                        $i = 1;while ($myquery->have_posts()): $myquery->the_post();
                        $do_not_duplicate[] = $post->ID;


                        //print_r($do_not_duplicate);exit;
                        if (!in_array($post->ID, $unique_terms)):
                        array_push($unique_terms, $post->ID);
                        //  print_r($unique_terms);
                        //if( ! in_array( $city, $unique_cities ) )
                        //

                        if ($post->ID == $do_not_duplicate) {
                            continue;
                        }
                        $categories = array();
                        $terms = wp_get_post_terms($post->ID, 'staff_category');
                        foreach ($terms as $term) {$categories[] = $term->slug;}
                        //echo "test" . print_r($categories);
                        $stafflist = implode(" ", $categories); 
                ?>
                <li class="element-item <?php echo $stafflist; ?>"> 
                    <div class="in">
                        <a class="stflink" href="<?php the_permalink();?>">
                            <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('staff-thumb');
                        } else { ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/defaultUser.jpg" alt="Staff Image" >
                            <?php }?>
                        </a>
                        <div class="staff-short">
                            <h5><a class="" href="<?php the_permalink();?>">
                                <?php the_title();?>
                                </a></h5>
                            <span>
                                <?php the_field('staff_designation');?>
                            </span>
                            <?php /*
                                    $string_fav = get_the_content('the_content', $post_id);
                                    $string_fav = wordwrap($string_fav, 115);
                                    $i_fav = strpos($string_fav, "\n");
                                    if ($i_fav) {
                                        $string_fav = substr($string_fav, 0, $i_fav);
                                    }
                                        */ ?>
                            <?php /*?><p><?php echo rtrim($string_fav);?>....</p><?php */?>
                        </div>
                    </div>
                </li>
                <?php   $i++; endif; endwhile;?>

                <?php }?>
                <?php }?>
            </ul>

        </div>
    </div>
</div>
<?php get_footer();?>

