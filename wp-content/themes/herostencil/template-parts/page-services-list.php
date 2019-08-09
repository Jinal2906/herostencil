<?php
/**
* @package WordPress
* @subpackage Default_Theme
template name: Services Pages List
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
?>

<!--cotent start-->
<div class="content">
   <?php
        if ( function_exists('yoast_breadcrumb') ) {
          yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
        } 
    ?>
    <div class="wrapper">
        <div class="mid <?php  echo ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ); ?> ">

            <div class="post entry" id="post-<?php the_ID(); ?>">
               
                <?php
                   echo (
                        $contentBanner == 'true'
                        ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                        : ''
                    );
                ?>
               
                <h1><?php the_title(); ?></h1>
                <?php // wp_list_pages(); ?>
                
                <?php
                    $args =  array(
                        'child_of' => 4152,
                        'sort_column' => 'post_date',
                        'post_type'    => 'page',
                        'post_status'  => 'publish',
                         'title_li' => '',
                        );
                    wp_list_pages( $args );
                ?>
            </div>

            <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>

<!--content end-->
<?php get_footer(); ?>