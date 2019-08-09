<?php
wp_enqueue_style( 'archive-newsletter-page' );
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();

global $contentBanner;
wp_reset_query();wp_reset_postdata();
$post_type_obj = get_post_type_object( get_post_type() );
$archive_title = apply_filters('post_type_archive_title', $post_type_obj->labels->name);
$page = get_page_by_path( $archive_title );
if ( has_post_thumbnail($page->ID) ){
    if( 'Top' == get_field( 'banner_position_new',$page->ID ) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
    } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', $page->ID) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail($page->ID) . '</div>';
    } else {
        $contentBanner = 'true';
    }
}

?>
<div class="content">
   <?php if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    } ?>
    <div class="wrapper">
        <div class="mid">            
            <?php if ( have_posts() ) : ?>
            <div class="post" id="post-<?php the_ID(); ?>">                
                <?php
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
                ?>
                <ul class="news-listing">
                    <?php 
                    // The Loop
                    while (  have_posts() ) :the_post(); ?>
                    <li>
                        <div class="news-img">
                            <?php if ( has_post_thumbnail() ) { the_post_thumbnail('news-thumb'); } ?>
                        </div>
                        <div class="news-detail">
                            <?php $valuepdf = get_field( "newsletter_pdf" );
                            $valuelink = get_field( "newsletter_link" );
                            if($valuepdf != ''){ ?>
                            <h3><a target="_blank" href="<?php echo $valuepdf; ?>"><?php the_title(); ?></a></h3>
                            <?php }else{ ?>
                            <h3><a target="_blank" href="<?php echo $valuelink; ?>"><?php the_title(); ?></a></h3>
                            <?php } ?>
                            <div class="post-meta"><strong>Date: </strong><?php the_time('F j, Y'); ?></div>
                        </div>
                    </li>
                    <?php endwhile; ?>
                </ul>
                <?php twentynineteen_the_posts_navigation(); ?>
            </div>
            <?php endif; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<!-- #main-content -->
<?php get_footer(); ?>