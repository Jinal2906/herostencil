<?php get_header();
wp_enqueue_style( 'taxonomy-body_parts' );
?>
<style type="text/css">
ul.nav_menu li.menu-item-3771 a{color:#c2993f;}
</style>
<!---------------content start--------------->
<div class="content">
	<div class="wrapper">
    	<!--<div class="post cf"> old -->
           <div class="mid">
            <?php $page_id = 4199; 
				$page_data = get_page( $page_id );
				echo '<h1 class="entry-title">'. $page_data->post_title .'</h1>';
				echo apply_filters('the_content', $page_data->post_content); ?>
                <?php $args = array('post_type' => 'condition', 'taxonomy' => 'body_parts', 'order' => 'asc', 'orderby' => 'id'); ?>
                <?php $tax_menu_items = get_categories( $args ); ?>
				<div class="search-condition">
                	<div class="human-body">
                    <?php 
						$x=1; 
                        foreach ( $tax_menu_items as $tax_menu_item ):?>
                        <a class="part<?php echo $x++ ?>" id="<?php echo $tax_menu_item->slug; ?>" title="<?php echo $tax_menu_item->name; ?>" href="<?php echo get_term_link($tax_menu_item,$tax_menu_item->taxonomy); ?>"></a>
                        <?php endforeach; ?>
                    </div>                
                	<div class="body-part">                    
    					<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
                        <?php
							$slug = $term->slug;                            
						 ?>
                    	<h4 class="<?php echo $slug; ?>"><?php echo $term->name; ?></h4>
                        <ul class="body-part-list">                              
						<?php
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
							$x=1;
							$y=1;
                            $a=1;
							$con="body-con";
                            while ($my_query->have_posts()) : $my_query->the_post(); ?>
                            <li><a href="#<?php echo $con.$a++ ?>" class="fancybox3" rel="#<?php echo $con.$x++ ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; ?>         
                        </ul> 
                    </div>        
                	<div class="body-content">  
                   		<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>          	
                            <article class="con body-content-fancybox" id="<?php echo $con.$y++ ?>">
                            	 <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
                            </article>
                        <?php endwhile; ?>          
                    </div>
         			<div class="clear"></div>
                </div>
		</div>
	</div>
</div>
<!---------------content end--------------->
<?php get_footer(); ?>