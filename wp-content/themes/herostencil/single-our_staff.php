<?php
wp_enqueue_style( 'page-staff' );
get_header();
global $contentBanner;
if ( has_post_thumbnail('4142') ){
    if( 'Top' == get_field( 'banner_position_new', '4142' ) ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail('4142') . '</div>';
    } elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', '4142') ) {
        echo '<div class="innbaner">' . featureImageOverlay() . get_the_post_thumbnail('4142') . '</div>';
    } else {
        $contentBanner = 'true';
    }
}
?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="content">
    <?php if ( function_exists('yoast_breadcrumb') ) {
    yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="wrapper"><div class="inner-bc">','</div></div></div>' );
    } ?>
    <div class="wrapper">
        <div class="mid <?php  echo ( function_exists('yoast_breadcrumb') ? ' no-left-radius' : '' ); ?>">
            <?php
                if ( get_the_title('4142') ) {
                echo '<h1>';
                    echo get_the_title('4142') .
                '</h1>';
                }
            ?>
            <div class="staff-single">
                <div class="staff-left">
                    <?php
                    echo (
                        has_post_thumbnail(get_the_ID())
                        ? get_the_post_thumbnail(get_the_ID(), 'staff-thumb', array( 'class' => '' ) )
                        : '<img src="' . get_template_directory_uri() .'/images/defaultUser.jpg" alt="Staff Image">'
                    );
                    if( have_rows('certifications_images') ){
                        echo '<div class="certifications-images">';
                            while( have_rows('certifications_images') ) : the_row();
                                echo  '<img src="' . get_sub_field('certifications_image')['url'] . '" alt="' . get_sub_field('certifications_image')['alt'] . '" />';
                            endwhile; wp_reset_query();
                        echo '</div>';
                    } ?>
                </div>
                <div class="staff-right">
                    <h3>
                        <?php the_title(); ?>
                        <?php $sdesi = get_field('staff_designation');
                        if($sdesi){ ?>, <span><?php the_field('staff_designation'); ?></span><?php }?>
                    </h3>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php get_footer(); ?>