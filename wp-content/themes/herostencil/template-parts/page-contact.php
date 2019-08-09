<?php
wp_enqueue_style( 'page-contact' );

/**
* @package WordPress
* @subpackage Default_Theme
template name: Contact Page
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
   <?php if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    } ?> 
    <div class="wrapper">
        <div class="mid <?php echo ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ) ?> ">
           
            <div class="post" id="post-<?php the_ID(); ?>">
                <h1><?php the_title(); ?></h1>
                
                <?php
                echo (
                    $contentBanner == 'true'
                    ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                    : ''
                );
                ?>
                <div class="entry">
                    <?php while (have_posts()) : the_post(); ?> 
                    <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
                    <?php endwhile; ?>
                    <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                </div>
                <?php
                    $wpq = array (
                        'post_type'       =>'location',
                        'orderby'         => 'ID',
                        'order'           => 'ASC',
                        'posts_per_page'  => -1
                    );
                    $myquery = new WP_Query ($wpq);?>
                <div class="block-section">
                        <?php $map_no=1; while ($myquery->have_posts()) : $myquery->the_post(); ?>
                        <div class="contatblock">
                            <div class="map-block">                                 
                                <div class="location-map contact-map" loc_lat="<?php the_field('location_latitude'); ?>" loc_long="<?php the_field('location_longitude'); ?>" loc_address="<?php the_field('location_address_for_map'); ?>"  loc_map-url=" <?php  the_field('location_map_link') ?>"  ></div>
                            </div>
                            <?php
                            echo '<h5>'. get_field('custom_title') . '</h5>';
                            echo  get_field('location_address');
                            echo '<br>'?>
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
                            <div class="wrk-hours">
                                <h5>Business hours</h5>
                                <?php the_field('working_hour');?>
                            </div>
                        </div>
                        <?php $map_no++; endwhile; wp_reset_query(); ?>
                </div>
                
            </div>
            
            <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>

<!--content end-->
<?php get_footer(); ?>