<?php
wp_enqueue_style( 'page-location-list' );
/**
* Template Name: Location Page
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
<div class="content">
    <?php if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    } ?>
	<div class="wrapper">
	<div class="mid <?php echo ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ); ?> ">
		<h1><?php the_title(); ?></h1>
		<?php 
        echo (
            $contentBanner == 'true'
            ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
            : ''
        );
        ?>
		<?php
			$wpq = array (
				'post_type'       =>'location',
				'orderby'         => 'ID',
				'order'           => 'ASC',
				'posts_per_page'  => -1
			);
			$myquery = new WP_Query ($wpq);
			$article_count = $myquery->post_count; ?>
			<?php if ($article_count) { ?>
			<div class="locations-list">
				<?php $i=1; while ($myquery->have_posts()) : $myquery->the_post(); ?>
				<div class="loc_list">
					<div class="loc_thumb"><?php if ( has_post_thumbnail() ) { the_post_thumbnail('full'); } ?></div>
					<div class="location_content">							
						<h4><strong><?php the_field('custom_title');?></strong></h4>
						<span class="adrs">Address </span>
						<p>
							<?php echo get_field('location_address'); ?>
						</p>
						<?php if(get_field('phone_number')) { ?>
						<div class="location-contact">
							<strong>Phone:</strong>
							<a href="tel:<?php echo preg_replace('/[^0-9]/', '', get_field('phone_number') ); ?>"><?php the_field('phone_number'); ?></a>
						</div>
						<?php } ?>
						<?php if(get_field('fax_number')) { ?>
						<div class="location-contact">
							<strong>Fax:</strong>
							<?php echo get_field('fax_number'); ?>
						</div>
						<?php } ?>
						<?php if(get_field('location_email')) { ?>
						<div class="location-contact">
						    <strong>Email:</strong>
						    <a href="mailto:<?php echo get_field('location_email'); ?>"><?php echo get_field('location_email'); ?></a>
						</div>
						<?php } ?>
					</div>
					<div class="location_btns">
						<a href="<?php the_permalink(); ?>" class="info_btn">Info</a>
						<a class="map_btn" target="_blank" href="<?php the_field('location_map_link'); ?>"> Map </a>
					</div>
				</div>
				<?php $i++; endwhile; ?>
			</div>
			<?php } ?>				
	</div>
	</div>
</div>
<?php get_footer(); ?>