<?php
    //wp_enqueue_style( 'parts-front-blog' );
    echo '<div class="blog-section">' .
        '<div class="wrapper">' .
			'<div class="d-flex ">' .
	        (
	            get_field('left_blog_content')
	            ? '<div class="blog-desc cell-4 cell-992-12 pr-20 ">' . get_field('left_blog_content') . ( get_field('subscribe_form') ? '<div class="subscribe-form-block"> ' . ( get_field('subscribe_form_title') ? '<h3 class="text-24">' . get_field('subscribe_form_title') . '</h3>' : '' ) . do_shortcode( get_field('subscribe_form') ) . ' </div>' : '' ) . '</div>'
	            : ''
	        );
	        query_posts( array('post_type' => 'post','posts_per_page' => 2, 'orderby' => 'date', 'order' => 'DESC', 'post_status' => array('publish','future'), ) );
	        if ( have_posts() ){
	            echo '<div class="latest-blog cell-8 cell-992-12">' .
	                '<ul class="list-none">';
	                while ( have_posts() ) : the_post();
	                    echo '<li class="d-flex mb-20">' .
	                            (
	                                has_post_thumbnail()
	                                ? '<div class="blog-image cell-5 cell-480-12">' . '<div class="innbaner image-src">' . get_the_post_thumbnail() . '<span class="date">' . get_the_time('j M') . '</span></div></div>'
	                                : '<div class="blog-image cell-5 cell-480-12">' . '<div class="innbaner image-src">' . '<img src="' . get_template_directory_uri() .'/images/placeholder-image.jpg" alt="Placeholder Image" ></div>'
	                            ) .
	                            '<div class="blog-content cell-7 cell-480-12">' .
                                    '<div class="bg-primary p-20 position-relative">' .
                                        '<h3 class="text-white text-20 ">' . get_the_title() . '</h3>' .
                                        (
                                            has_excerpt()
                                            ? apply_filters( 'the_content', get_the_excerpt() )
                                            : apply_filters( 'the_content', wp_trim_words( get_the_content(), 20 ) )
                                        ) .
                                        '<a class="position-absolute link text-white hover-text-secondary-light" href="' . get_the_permalink() . '"> Read more >> </a>' .
                                   '</div>' .
	                            '</div>' .
	                        '</li>' ;
	                endwhile; wp_reset_query();
	            echo '</ul>' .
	             '</div>';
	        }
        echo '</div>' .
		'</div>' .
        '</div>';
