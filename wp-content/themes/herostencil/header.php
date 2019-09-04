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
        <?php
            if( is_front_page() ){
                echo '<link href="' .  get_template_directory_uri() . '/assets/css/style.css" rel="stylesheet">';
            } else {
                echo '<link href="' .  get_template_directory_uri() . '/assets/css/inner-styles.css" rel="stylesheet">';
            }
        ?>
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

        <!-- SVG files for Icons and Quotes -->
		<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
			<symbol id="square-quote-left" viewBox="0 0 32.422 26.781">
                <g transform="matrix(1, 0, 0, 1, 0, 0)">
                    <path d="M9.6,20.781H0v-6.87a23.417,23.417,0,0,1,.735-6.58A10.038,10.038,0,0,1,3.452,3.008,13.833,13.833,0,0,1,8.511,0l1.88,3.965A8.07,8.07,0,0,0,6.272,6.631a7.876,7.876,0,0,0-1.316,4.546H9.6Zm16.031,0h-9.6v-6.87a23.386,23.386,0,0,1,.735-6.6A9.986,9.986,0,0,1,19.5,3.008,14.046,14.046,0,0,1,24.542,0l1.88,3.965A8.07,8.07,0,0,0,22.3,6.631a7.876,7.876,0,0,0-1.316,4.546h4.649Z" transform="translate(1 1)"/>
                </g>
			</symbol>

            <symbol id="square-quote-right" viewBox="0 0 32.523 26.815">
                <g transform="matrix(1, 0, 0, 1, 0, 0)">
                    <path d="M20.508,12.893h9.6v6.9a23.23,23.23,0,0,1-.735,6.563,10.1,10.1,0,0,1-2.734,4.324A13.914,13.914,0,0,1,21.6,33.708l-1.88-4a8.07,8.07,0,0,0,4.119-2.666A7.706,7.706,0,0,0,25.122,22.5H20.508Zm-16.133,0h9.6v6.9a23.755,23.755,0,0,1-.718,6.563,9.957,9.957,0,0,1-2.717,4.324,13.875,13.875,0,0,1-5.076,3.025l-1.88-4a7.979,7.979,0,0,0,4.136-2.666,7.96,7.96,0,0,0,1.3-4.546H4.375Z" transform="translate(-2.59 -11.89)" />
                </g>
            </symbol>
		</svg>

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


            <header id="myHeader" class=" d-block position-fixed width-full transition <?php echo is_singular() && twentynineteen_can_show_post_thumbnail() ? 'site-header featured-image' : 'site-header'; if( 'yes' == get_field('follow_skew_buttons_layout','options') ) { echo ' skew-btn '; } ?>">
                <div class="wrapper d-flex align-items-center justify-content-between">
                    <?php if ( has_custom_logo() ) : ?>
                    <?php $mainLogo = get_theme_mod( 'custom_logo' );
                    $mainLogoImage = wp_get_attachment_image_src( $mainLogo , 'full' );
                    $stickyLogo = get_theme_mod( 'sticky_logo' );
                    $responsiveLogo = get_theme_mod( 'responsive_logo' );
                    ?>
                    <div class="header-logo position-relative mr-20 height-auto <?php if($stickyLogo){ echo ' has-sticky-logo '; } if($responsiveLogo){ echo ' has-responsive-logo '; } ?>">
                        <?php // the_custom_logo(); ?>
                        <a href="<?php echo get_option('home'); ?>" class="width-full transition position-relative">
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
                        <div class="quick-links d-flex justify-content-end cell-12 height-auto  ">
                            <ul class="contact-links d-flex align-items-center justify-content-end m-0 p-0 list-none ">
                                <!-- call -->
                                <?php if (get_field('header_phone_number', 'options')) {
                                ?>
                                <li class="call position-relative m-0 p-0 pointer-events-none">
                                    <?php
                                    $total = count(get_field('header_phone_number', 'options'));
                                    $i = 1; while (have_rows('header_phone_number', 'options')): the_row();
                                    global $callIcon;
                                    ?>
                                    <?php if ($total == 1) {?>
                                    <a href="tel:<?php echo preg_replace('/[^0-9]/', '', get_sub_field('tel_tag', 'options') ); ?>" class="one text-14 border-radius-10 text-uppercase text-white font-bold transition d-block bg-primary py-10 px-20 position-relative"><span><?php the_sub_field('phone_number', 'options'); ?></span> <span class="call-icon d-none"><?php echo $callIcon; ?></span> </a>
                                    <?php } else {
                                        if ($i == 1) {
                                    ?>
                                    <a href="#" class="calldd text-14 border-radius-10 text-uppercase text-white font-bold transition d-block bg-primary py-10 px-20 position-relative"><span><?php the_field('phone_cta_text', 'options');?></span><span class="call-icon d-none text-14 border-radius-10 text-uppercase text-white font-bold transition d-block bg-primary py-10 px-20 position-relative"><?php echo $callIcon; ?></span></a>
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
                                <li class="review position-relative m-0 p-0 ml-15 ">
                                    <?php
                                    $total2 = count(get_field('reviews', 'options'));
                                    $j = 1;while (have_rows('reviews', 'options')): the_row();?>
                                    <?php if ($total2 == 1) {?>
                                    <a href="<?php the_sub_field('review_url', 'options');?>" target="_blank"><span><?php the_sub_field('review_name', 'options');?></span></a>
                                    <?php } else {
                                        if ($j == 1) {
                                    ?>
                                    <a href="#" class="reviewdd text-14 border-radius-10 text-uppercase text-white hover-text-white bg-primary hover-bg-secondary font-bold transition d-block  py-10 px-20 position-relative"><span><?php the_field('review_cta_text', 'options');?></span></a>
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
                                <?php if (get_field('appointment_cta_text', 'options')) { ?>
                                <li class="appt-btn position-relative m-0 p-0 ml-15"><a href="<?php the_field('appointment_cta_url', 'options');?>" class="text-14 border-radius-10 text-uppercase text-white hover-text-white bg-secondary hover-bg-primary font-bold transition d-block py-10 px-20 position-relative"><span><?php the_field('appointment_cta_text', 'options');?></span></a></li>
                                <?php } ?>
                            </ul>
                            <a class="navbar-toggle" href="javascript:void(0)"><span class="navbar-toggle__icon-bar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </span> </a>
                        </div>
                        <div class="main-navigation width-full height-auto d-block position-relative pt-30 transition">
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
