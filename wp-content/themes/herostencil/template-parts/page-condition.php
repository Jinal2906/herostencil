<?php
/**
 * Template Name: Condition Page
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

?>

<!--content start-->
<div class="content">
    <div class="wrapper">
    	<div class="mid">
			<?php while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php
            echo (
                $contentBanner == 'true'
                ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                : ''
            );
            ?>
            <?php the_content(); ?>
            <?php $args = array('post_type' => 'condition', 'taxonomy' => 'body_parts', 'order' => 'asc', 'orderby' => 'menu_order'); ?>
            <?php $tax_menu_items = get_categories( $args ); ?>
            <div class="human-body">
                <?php $i=1; foreach ( $tax_menu_items as $tax_menu_item ):?>
                    <a class="part<?php echo $i++;?>" title="<?php echo $tax_menu_item->name; ?>" href="<?php echo get_term_link($tax_menu_item,$tax_menu_item->taxonomy); ?>"></a>
                <?php endforeach; ?>
            </div>        
            <?php endwhile; wp_reset_query(); ?>
        </div>
        <?php get_sidebar(); ?>

            <?php /*          
                $menuLocations = get_nav_menu_locations(); 
                $menuID = $menuLocations['body-condition']; 
                $primaryNav = wp_get_nav_menu_items($menuID); 
            ?>
            <?php while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php if( get_field('banner_position') == 'Content' ) { ?>
            <?php if (has_post_thumbnail() ) { the_post_thumbnail(array(990,9999)); ?>
            <?php } }?>
            <?php the_content(); ?> 
          
            <div class="human-body">
                <?php $i=1; foreach ( $primaryNav as $navItem ) :?>
                    <a class="part<?php echo $i++;?>" title="<?php echo $navItem->title; ?>" href="<?php echo $navItem->url; ?>"></a>
                <?php endforeach; ?>
            </div>        
            <?php endwhile; wp_reset_query(); */ ?>
            <?php //get_sidebar(); ?>
    </div>
    <?php // get_sidebar(); ?>
</div>

<!-- content end-->
<?php get_footer(); ?>