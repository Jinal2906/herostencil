<?php 
wp_enqueue_style( 'content-servicessources' );

$sourcesTitle = get_field('services_sources_title');
if( have_rows('services_sources_list') ){
    echo '<div class="sources-list-block">';
        if( $sourcesTitle ){
            echo '<h4>' . $sourcesTitle . ' :-</h4>';
        }        
        echo '<ul>';
        while( have_rows('services_sources_list') ) : the_row();                
            $suurcesURL = get_sub_field('services_sources_url');
            if($suurcesURL){
                echo '<li><a href="' . $suurcesURL . '" target="_blank">' . $suurcesURL . '</a></li>';
            }
        endwhile;
        echo '</ul>';      
    echo '</div>';
    }
?>