<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="profile" href="https://gmpg.org/xfn/11" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i|Roboto+Condensed:400,400i,700,700i" rel="stylesheet">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>


       <!-- mobile navigation -->
       <div class="mobile_menu d-none">
            <a class="close-btn" href="#"></a>

          <div class="mob-appntmtn">
                <?php
                    echo '<ul class="main-mobile">' . (
                            get_field('appointment_cta_url', 'options')
                            ? '<li class="req-appt-btn"><a href="' . get_field('appointment_cta_url', 'options') . '"><span>' . get_field('appointment_cta_text', 'options') . '</span></a></li>'
                                : ''
                            );
                            if (get_field('reviews', 'options')) {
                            ?>
                             <!-- review -->
                            <li class="review review-btn">
                                <?php
                                $total2 = count(get_field('reviews', 'options'));
                                $j = 1;while (have_rows('reviews', 'options')): the_row();?>
                                <?php if ($total2 == 1) {?>
                                <a href="<?php the_sub_field('review_url', 'options');?>" target="_blank"><span><?php the_sub_field('review_name', 'options');?></span></a>
                                <?php } else {
                                    if ($j == 1) {
                                ?>
                                <a href="#" class="reviewdd"><span><?php the_field('review_cta_text', 'options');?></span></a>
                                <ul class="reviewddlist quick-dropdown">
                                    <?php }?>
                                    <li><a href="<?php the_sub_field('review_url', 'options');?>" target="_blank"><span><?php the_sub_field('review_name', 'options');?></span></a></li>
                                    <?php if ($j == $total2) {?>
                                </ul>
                                <?php }
                                }
                                $j++;endwhile;?>
                            </li>
                                <?php } ?>
                        <?php echo '</ul>'; ?>



          </div>
          <div class="inner"></div>
       </div>

        <?php
        global $breadcrumb;
        $stickyHeader = get_field('transparent_home_page_header','options');

		?>

        <div id="wrapper" class="<?php
                if( 'yes' == $stickyHeader ){
                    if( is_front_page() ){
                        echo ' sticky-header';
                    }
                    elseif( is_tax('body_parts') ){

                    }
                    elseif ( is_single( 'workshop' ) || is_post_type_archive( 'workshop' ) || is_post_type_archive( 'newsletter' ) && !is_post_type_archive('post') && !is_singular( 'post' ) ) {
						$post_type_obj_header = get_post_type_object( get_post_type() );
                        if( '' != $post_type_obj_header ){
                            $archive_title_header = apply_filters('post_type_archive_title', $post_type_obj_header->labels->name);
                            $page_header = get_page_by_path( $archive_title_header );
                            if( has_post_thumbnail(  $page_header->ID ) ) {
                                if( 'Top' == get_field('banner_position_new', $page_header->ID ) && $post_type_obj_header != '' ) {
                                    echo ' sticky-header 3';
                                }elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', $page_header->ID ) ){
                                    echo ' sticky-header 42';
                                }else{

                                }
                            }
                        }

                    }
                    elseif ( is_singular( array( 'location' ) ) ) {
                        if( has_post_thumbnail('4141') ){
                            if( 'Top' == get_field('banner_position_new', '4141' ) ) {
                                echo ' sticky-header';
                            }elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', '4141' ) ){
                                echo ' sticky-header';
                            }else{

                            }
                        }
                    }
                    elseif ( is_singular( array( 'our_staff' ) ) ) {
                        if( has_post_thumbnail('4142') ){
                            if( 'Top' == get_field('banner_position_new', '4142' ) ) {
                                echo ' sticky-header';
                            }elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', '4142' ) ){
                                echo ' sticky-header';
                            }else{

                            }
                        }
                    }
                    elseif( is_singular('post') || is_home() || is_archive() || is_search() ){
                        if( has_post_thumbnail( get_option( 'page_for_posts' ) ) ){
                            if( 'Top' == get_field('banner_position_new', get_option( 'page_for_posts' ) ) ) {
                                echo ' sticky-header 1';
                            }elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new', get_option( 'page_for_posts' )) ){
                                echo ' sticky-header 2';
                            }else{

                            }
                        }
                    }
                    elseif ( has_post_thumbnail() && !is_home() ){
                        if( 'Top' == get_field( 'banner_position_new' ) ) {
                            echo 'sticky-header';
                        }elseif( 'yes' == get_field('feature_image_placement_globally','options') && 'Content' != get_field('banner_position_new') ){
                            echo ' sticky-header';
                        }else{
                            $breadcrumb = 'true';
                        }
                    }else{
                        $breadcrumb = 'true';
                    }
            } ?>">


            <header id="myHeader" class=" position-fixed <?php echo is_singular() && twentynineteen_can_show_post_thumbnail() ? 'site-header featured-image' : 'site-header'; if( 'yes' == get_field('follow_skew_buttons_layout','options') ) { echo ' skew-btn '; } ?>">
                <div class="wrapper d-flex align-items-center justify-content-between">
                    <?php if ( has_custom_logo() ) : ?>
                    <?php $mainLogo = get_theme_mod( 'custom_logo' );
                    $mainLogoImage = wp_get_attachment_image_src( $mainLogo , 'full' );
                    $stickyLogo = get_theme_mod( 'sticky_logo' );
                    $responsiveLogo = get_theme_mod( 'responsive_logo' );
                    ?>
                    <div class="header-logo mr-20 <?php if($stickyLogo){ echo ' has-sticky-logo '; } if($responsiveLogo){ echo ' has-responsive-logo '; } ?>">
                        <?php // the_custom_logo(); ?>
                        <a href="<?php echo get_option('home'); ?>" class="cell-12">

                            <img class="large-logo" src="<?php echo $mainLogoImage[0]; ?>" alt="<?php bloginfo('name'); ?>" />

                            <?php if( $stickyLogo ) { ?>
                            <img class="sticky-logo" src="<?php echo $stickyLogo; ?>" alt="<?php bloginfo('name'); ?>" />
                            <?php } if( $responsiveLogo ) { ?>
                            <img class="small-logo" src="<?php echo $responsiveLogo; ?>" alt="<?php bloginfo('name'); ?>" />
                            <?php } ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    <div class="header-navigation ">
                        <div class="quick-links d-flex justify-content-end cell-12 ">
                            <ul class="contact-links d-flex align-items-center ">
                                <!-- call -->
                                <?php if (get_field('header_phone_number', 'options')) {
                                ?>
                                <li class="call position-relative">
                                    <?php
                                    $total = count(get_field('header_phone_number', 'options'));
                                    $i = 1;while (have_rows('header_phone_number', 'options')): the_row();
                                    global $callIcon;
                                    ?>
                                    <?php if ($total == 1) {?>
                                    <a href="tel:<?php echo preg_replace('/[^0-9]/', '', get_sub_field('tel_tag', 'options') ); ?>" class="one"><span><?php the_sub_field('phone_number', 'options'); ?></span> <span class="call-icon d-none"><?php echo $callIcon; ?></span> </a>
                                    <?php } else {
                                        if ($i == 1) {
                                    ?>
                                    <a href="#" class="calldd"><span><?php the_field('phone_cta_text', 'options');?></span><span class="call-icon d-none"><?php echo $callIcon; ?></span></a>
                                    <ul class="callddlist quick-dropdown block-hide position-absolute">
                                        <?php }?>
                                        <li><a href="tel:<?php echo preg_replace('/[^0-9]/', '', get_sub_field('tel_tag', 'options') ); ?>" class="one d-block"><span><?php the_sub_field('phone_number', 'options'); ?></span></a></li>
                                        <?php if ($i == $total) {?>
                                    </ul>
                                    <?php }
                                    }
                                    $i++;endwhile;?>
                                </li>
                                <?php }?>
                                <!-- review -->
                                <?php if (get_field('reviews', 'options')) {
                                ?>
                                <li class="review position-relative ">
                                    <?php
                                    $total2 = count(get_field('reviews', 'options'));
                                    $j = 1;while (have_rows('reviews', 'options')): the_row();?>
                                    <?php if ($total2 == 1) {?>
                                    <a href="<?php the_sub_field('review_url', 'options');?>" target="_blank"><span><?php the_sub_field('review_name', 'options');?></span></a>
                                    <?php } else {
                                        if ($j == 1) {
                                    ?>
                                    <a href="#" class="reviewdd"><span><?php the_field('review_cta_text', 'options');?></span></a>
                                    <ul class="reviewddlist quick-dropdown block-hide position-absolute">
                                        <?php }?>
                                        <li><a href="<?php the_sub_field('review_url', 'options');?>"  class="d-block" target="_blank"><span><?php the_sub_field('review_name', 'options');?></span></a></li>
                                        <?php if ($j == $total2) {?>
                                    </ul>
                                    <?php }
                                    }
                                    $j++;endwhile; ?>
                                </li>
                                <?php } ?>
                                <?php if (get_field('appointment_cta_text', 'options')) {?>
                                <li class="appt-btn"><a href="<?php the_field('appointment_cta_url', 'options');?>"><span><?php the_field('appointment_cta_text', 'options');?></span></a></li>
                                <?php } ?>
                            </ul>
                            <a class="navbar-toggle" href="javascript:void(0)"><span class="navbar-toggle__icon-bar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </span> </a>
                        </div>
                        <div class="main-navigation d-none">
                            <?php if ( has_nav_menu( 'main-navigation' ) ) : ?>
                            <nav id="site-navigation" class="" aria-label="<?php esc_attr_e( 'Top Menu', 'twentynineteen' ); ?>">
                                <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'main-navigation',
                                        'menu_class' => 'nav_menu',
                                    )
                                );
                                ?>
                            </nav><!-- #site-navigation -->
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </header>

            <div id="content-area" class="<?php if( 'yes' == get_field('follow_skew_buttons_layout','options') ) { echo ' skew-btn '; } ?>">
