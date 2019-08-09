<?php
wp_enqueue_style( 'archive-workshop-page' );
/**
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
get_header();

global $contentBanner;
wp_reset_query();wp_reset_postdata();
$post_type_obj = get_post_type_object( get_post_type() );
$archive_title = apply_filters('post_type_archive_title', $post_type_obj->labels->name);
$page = get_page_by_path( $archive_title );
if ( has_post_thumbnail($page->ID) ){
    if( 'Top' == get_field( 'banner_position_new' ) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
    } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new') ) {
        echo '<div class="innbaner test">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
    } else {
        $contentBanner = 'true';
    }
}

?>

<!-- content start -->
<div class="content">
 <?php if ( function_exists('yoast_breadcrumb') ) {
    yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
} ?>
<div class="wrapper">
    <div class="mid">
        <div class="post workshop-details">
            <?php while ( have_posts() ) : the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <?php the_post_thumbnail(); ?>
                <br>

                <?php the_content(); ?>
                <?php if(get_field('date') || get_field('time') || get_field('location')) { ?>
                    <div class="workshop-contact">
                        <span><strong>Date:</strong>
                            <?php
                            $date = get_field('date', false, false);
                            $date = new DateTime($date);
                            ?>
                            <?php echo $date->format('j M Y'); ?>
                        </span>
                        <span><strong>Time:</strong> <?php the_field('time'); ?></span>
                        <span><strong>Address:</strong> <?php echo get_field('location'); ?></span>
                    </div>
                <?php } ?>
                <?php if(get_field('workshop_form')) { ?>
                    <a data-fancybox="workshop_content" data-auto-focus="false" data-src="#workshop_content" href="javascript:;" class="read-more"> Register </a>
                <?php } ?>

                <div id="workshop_content" class="workshop-form" style="display:none;width:100%;max-width:660px;">
                    <h3>RESERVE YOUR SPOT NOW</h3>
                    <?php echo do_shortcode(get_field('workshop_form')); ?>
                </div>
            <?php endwhile; ?>
        </div><!-- #container -->
    </div>
    <?php get_sidebar(); ?>
</div>
</div><!-- #main-content -->
<?php get_footer(); ?>
