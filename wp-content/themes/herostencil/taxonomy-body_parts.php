<?php get_header();
wp_enqueue_style( 'taxonomy-body_parts' );

echo
'<div class="content">' .
	'<div class="wrapper">' .
        '<div class="mid">' ;
            $page_id = 4199; 
			$page_data = get_page( $page_id );
			echo '<h1 class="entry-title">'. $page_data->post_title .'</h1>';
			echo apply_filters('the_content', $page_data->post_content);
            $args = array('post_type' => 'condition', 'taxonomy' => 'body_parts', 'order' => 'asc', 'orderby' => 'id');
            $tax_menu_items = get_categories( $args );
			echo '<div class="search-condition">' .
                	'<div class="human-body">' ;
						$x=1; foreach ( $tax_menu_items as $tax_menu_item ):
                        echo '<a class="part' . $x++ .'" id="' . $tax_menu_item->slug .'" title="' . $tax_menu_item->name . '" href="' . get_term_link($tax_menu_item,$tax_menu_item->taxonomy) . '"></a>' ;
                        endforeach;
                    echo '</div>' .
                	'<div class="body-part">';             
    					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                    	$slug = $term->slug;                            
                    	echo '<h4 class="' . $slug . '">' . $term->name . '</h4>' .
                        '<ul class="body-part-list">';                          
						    global $wp_query;
                            $args = array( 
                                'post_type' => 'condition', 
                                'taxonomy' =>'body_parts',
                                'term'=>$slug,
                                'posts_per_page' => -1,
								'order' => 'asc',
								'orderby' => 'menu_order',
                                'paged' => $paged 
                            );
                            $my_query = new WP_Query($args);
							$x=1; $y=1; $a=1; $con="body-con";
                            while ($my_query->have_posts()) : $my_query->the_post();
                                echo '<li><a href="#'. $con.$a++ .'" class="fancybox3" rel="#' . $con.$x++ .'">' . get_the_title() .'</a></li>' ;
                            endwhile;         
                        echo '</ul>' .
                    '</div>' .
                	'<div class="body-content">' ;  
                   		while ($my_query->have_posts()) : $my_query->the_post();
                            echo '<article class="con body-content-fancybox" id="' . $con.$y++ .'">' . get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ) .'</article>' ;
                        endwhile;        
                    echo '</div>' .
         			'<div class="clear"></div>' ;
            echo '</div>' .
		'</div>' .
	'</div>' .
'</div>' ;
 get_footer(); 
 ?>