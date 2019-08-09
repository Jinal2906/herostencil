<?php
wp_enqueue_style( 'page-ebook' );

/**
* @package WordPress
* @subpackage Default_Theme
template name: Ebook Page
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

<div class="content cf">
    <div class="wrapper">
        <div class="mid">
            <div class="post cf">
                <h1><?php the_title(); ?></h1>
                <?php 
                    echo (
                        $contentBanner == 'true'
                        ? '<div class="content-banner ' . $contentBanner . ' ">' . get_the_post_thumbnail() . '</div>'
                        : ''
                    );
                ?>
                <div class="help-block clearfix" id="help-block">
                    <?php $link_title = get_field('download_cta_text'); $id_count = '1'; $CountNumber = '1'; ?>
                    <?php if( have_rows('add_tips_block') ): ?>
                    <div class="ebook-wrapper">
                        <?php while( have_rows('add_tips_block') ): the_row();            
                        $image = get_sub_field('ebook_image');
                        $short_description = get_sub_field('short_description');
                        $showonmobile = get_sub_field('do_you_want_to_show_on_mobile');
                        ?>
                        <div class="ebook-block  <?php if($showonmobile == "No"){echo "hide_ebook";}?>">
                            <?php if( $short_description ): echo '<h2>' . $short_description . '</h2>'; endif; ?>
                            <?php if( $image ): ?><img src="<?php echo $image; ?>" /><?php endif; ?>
                            <?php if(get_field('ebook_cta_text')) { ?>
                            <div class="btn-row">
                                <a data-fancybox href="#ebook-popup<?php echo $CountNumber; ?>" class="read-more"><span><?php the_field('ebook_cta_text'); ?></span></a> 
                            </div>
                            <?php } ?>
                        </div>
                        <?php $CountNumber++; endwhile;  ?>
                    </div>
                    <div style="display:none;">
                        <?php            
                        while( have_rows('add_tips_block') ): the_row();
                        ?>
                        <div id="ebook-popup<?php echo $id_count; ?>" class="pupup_frm">
                            <div class="inner">
                                <?php $subscribe_book_popup_title = get_field('subscribe_book_popup_title'); ?>
                                <?php if($subscribe_book_popup_title) {?>
                                <h2><?php echo $subscribe_book_popup_title; ?></h2>
                                <?php } ?>
                                <?php echo do_shortcode(get_sub_field('form_short_code')); ?>
                            </div>
                        </div>
                        <?php $id_count++; endwhile;  ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>  
        <?php // get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>