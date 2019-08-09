<?php
wp_enqueue_style( 'parts-front-feature-testimonials' );
$featureTesti = get_field('feature_testimonials_section');
if(have_rows('feature_testimonials_section')){
    while(have_rows('feature_testimonials_section')) {
        the_row();
        echo '<section class="feature-testimonials"><div class="wrapper">';
            if($featureTesti['section_title']){
                echo '<h2>' . $featureTesti['section_title'] . '</h2>';
            }
            if($featureTesti['section_image']){
                echo '<div class="left-image">' .
                '<img src="' . $featureTesti['section_image']['sizes']['large'] . '" width="' . $featureTesti['section_image']['width'] . '" alt="' . $featureTesti['section_image']['alt'] . '"/>' .
                '</div>';
            }
            if( $featureTesti['testimonials_title'] || $featureTesti['testimonials_desc'] || $featureTesti['testimonials_by'] ){
                echo '<div class="right-content">';
                    if($featureTesti['testimonials_title']){
                        echo '<h3>' . $featureTesti['testimonials_title'] . 
                        '<span class="title-icon"><img src="' . $featureTesti['testimonials_title_icon']['url'] . '"/></span></h3>';
                    }
                    if($featureTesti['testimonials_desc']){
                        echo '<p>' . $featureTesti['testimonials_desc'] . '</p>';
                    }
                    if($featureTesti['testimonials_by']){
                        echo '<h4>' . $featureTesti['testimonials_by'] . '</h4>';
                    }
                    if($featureTesti['testimonials_page_url']){
                        echo '<div class="btn-center"><a class="read-more" href="' . $featureTesti['testimonials_page_url'] . '">' . 
                            $featureTesti['testimonials_cta_text'] . 
                            '</a></div>';
                    }
                echo '</div>';
            }
        echo '</div></section>';
    }
}
?>