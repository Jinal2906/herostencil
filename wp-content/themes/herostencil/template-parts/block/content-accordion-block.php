<?php wp_enqueue_style( 'content-accordion-block' ); 

echo '<section class="accordion-part">' .
    
    (
        get_field('accordion_title')
        ? '<h3>' . get_field('accordion_title') . '</h3>' 
        : ''
    ) ;
    
    if(have_rows('accordion_list')) {
      echo '<ul class="faq_section">' ;
          while(have_rows('accordion_list')): the_row(); 
          $title = get_sub_field('title');
          $description = get_sub_field('description');
            echo '<li>' .
                '<h6>' .
                    '<a href="javascript:;">' . $title . '</a>' .
                '</h6>' .
                '<div class="faq_content">' .
                     $description . 
                '</div>' .
            '</li>' ;    
          endwhile; wp_reset_query();
      echo '</ul>' ;  
    }
    
echo '</section>' ;

?>
