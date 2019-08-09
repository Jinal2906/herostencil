<?php
wp_enqueue_style( 'archive-workshop-page' );
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();

if(have_posts()){
    global $contentBanner;
    wp_reset_query();wp_reset_postdata();
    $post_type_obj = get_post_type_object( get_post_type() );
    $archive_title = apply_filters('post_type_archive_title', $post_type_obj->labels->name);
    $page = get_page_by_path( $archive_title );

    if ( has_post_thumbnail($page->ID) ){
        if( 'Top' == get_field( 'banner_position_new', $page->ID ) ) {
            echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
        } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', $page->ID ) ) {
            echo '<div class="innbaner test">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
        } else {
            $contentBanner = 'true';
        }
    }
}

?>
<!--content start-->
<div class="content">
    <?php if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    } ?>
    <div class="wrapper">
        <div class="post mid">
            <?php 
            if(have_posts()){
            $post_type_obj = get_post_type_object( get_post_type() );
            $title = apply_filters('post_type_archive_title', $post_type_obj->labels->name );        
            $archive_title = apply_filters('post_type_archive_title', $post_type_obj->labels->all_items);
            ?> 
            <h1><?php echo $title; ?></h1>
            <?php
            echo (
                $contentBanner == 'true'
                ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail( $page->ID ) . '</div>'
                : ''
            );
            }
            ?>
            <div class="workshop-list">
                <?php wp_reset_query();
                if(have_posts()){

                // The Loop
                while (have_posts() ) : the_post(); ?>
                <div class="workshop">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="thumb_small"><?php echo the_post_thumbnail('full'); ?></div>
                    <?php endif; ?>
                    <h4>
                        <?php the_title(); ?>
                    </h4> 
                    <?php $date = get_field('date');
                    $date = new DateTime($date);
                    ?>
                    <div class="date"><strong>Date:</strong> <?php echo $date->format('j M Y'); ?></div>                
                    <?php if(get_field('reservation_link')) { ?>
                    <a href="<?php the_field('reservation_link'); ?>" class="read-more" target="_blank"><span>read more</span></a> 
                    <?php } else { ?>
                    <a href="<?php the_permalink(); ?>" class="read-more"><span>read more</span></a> 
                    <?php } ?>
                </div>
                <?php endwhile; ?>
                <?php 
                } else {
                    echo '<h3> We are coming soon with new workshops ... </h3>';
                }
                ?>
            </div>
            <?php twentynineteen_the_posts_navigation(); ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>
<!--content end-->
<?php get_footer(); ?>

