<?php
/**
* @package WordPress
* @subpackage Default_Theme
template name: Sitemap Page
*/
get_header(); ?>
<!--cotent start-->
<div class="content">
    <div class="wrapper">
        <div class="mid">

            <div class="post entry" id="post-<?php the_ID(); ?>">
                <h1><?php the_title(); ?></h1>
                <?php wp_list_pages(); ?>
                
            </div>

            <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>

<!--content end-->
<?php get_footer(); ?>