<?php 
    wp_enqueue_style( 'parts-front-blog' );
    echo '<div class="blog-section">' .
        '<div class="wrapper">' .
        (
            get_field('left_blog_content')
            ? '<div class="left-content">' . get_field('left_blog_content') . ( get_field('subscribe_form') ? '<div class="subscribe-form-block"> ' . ( get_field('subscribe_form_title') ? '<h3>' . get_field('subscribe_form_title') . '</h3>' : '' ) . do_shortcode( get_field('subscribe_form') ) . ' </div>' : '' ) . '</div>'
            : ''
        );
        query_posts( array('post_type' => 'post','posts_per_page' => 2, 'orderby' => 'date', 'order' => 'DESC', 'post_status' => array('publish','future'), ) );
        if ( have_posts() ){
            echo '<div class="latest-blog">' .
                '<ul>';
                while ( have_posts() ) : the_post();
                    echo '<li>' .
                            (
                                has_post_thumbnail()
                                ? '<div class="blog-image innbaner">' . get_the_post_thumbnail() . '<span class="date">' . get_the_time('j M') . '</span></div>'
                                : '<div class="blog-image innbaner"><img src="' . get_template_directory_uri() .'/images/placeholder-image.jpg" alt="Placeholder Image" ></div>'
                            ) .
                            '<div class="blog-content">' .
                            '<h3>' . get_the_title() . '</h3>' .
                            '<p>' . get_the_excerpt() . '</p>' .
                            '<a class="read-full-post" href="' . get_the_permalink() . '"> Read more >> </a>' .
                            '</div>' .
                        '</li>' ;
                endwhile; wp_reset_query();
            echo '</ul>' .
             '</div>';
        }
        echo '</div>' .
        '</div>';
   
    