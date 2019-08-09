<?php
wp_enqueue_style( 'page-staff' );
/**
 * Template Name: Staff Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
get_header();?>
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
   <?php if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb( '<div id="breadcrumbs " class="breadcrumbs"><div class="wrapper"><div class="inner-bc"','</div></div></div>' );
    } ?>
    <div class="wrapper">
      <div class="mid <?php  echo ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ); ?>">
          <h1><?php the_title(); ?></h1>
          <?php 
            echo (
                $contentBanner == 'true'
                ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                : ''
            );
          ?>
           <?php $terms = get_terms('staff_category');
           foreach ($terms as $term) {
            $wpq = array ('taxonomy'=>'staff_category','term'=>$term->slug, 'orderby' => 'ID', 'order' => 'ASC', 'posts_per_page' => -1);
            $myquery = new WP_Query ($wpq);
            $article_count = $myquery->post_count; ?>
            <h4 class="staff-head"><?php echo $term->name;?></h4>
            <?php if ($article_count) { ?>
              <ul class="staff-list">
                <?php $i=1; while ($myquery->have_posts()) : $myquery->the_post(); ?>
                <li> <a href="<?php the_permalink(); ?>">
                  <?php 
                         echo (
                                has_post_thumbnail($myquery->ID)
                                ? get_the_post_thumbnail( $myquery->ID,  'staff-thumb', array( 'class' => '' ) )
                                : '<img src="' . get_template_directory_uri() .'/images/defaultUser.jpg" alt="Staff Image" >'
                            );
                  ?>
                </a>
                <div class="staff-short">
                  <h5><a class="" href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                  </a></h5>
                  <span>
                    <?php the_field('staff_designation'); ?>
                  </span>
                </div>
              </li>
              <?php $i++; endwhile; ?>
            </ul>
          <?php } ?>
        <?php } ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>

