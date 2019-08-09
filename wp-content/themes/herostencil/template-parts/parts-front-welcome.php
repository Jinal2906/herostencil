<?php
wp_enqueue_style( 'parts-front-welcome' );

$welcomeInfo = get_field('welcome_informatics');

if(have_rows('welcome_informatics')){
    while ( have_rows('welcome_informatics') ) : the_row();
        echo '<section class="welcome-informatics"><div class="wrapper">';

            if( have_rows('accepted_insurance_list') || !empty( $welcomeInfo['insurance_title'] ) ){
                echo '<div class="group-1 group">';
                    if( !empty( $welcomeInfo['insurance_title'] ) ){
                        echo '<h4>' . $welcomeInfo['insurance_title'] . '</h4>';
                    }
                    echo '<div class="company-list-wrapper"><div>';
                    $counterList = 0;
                    while( have_rows('accepted_insurance_list') ) : the_row();
                        $companyTitle = get_sub_field('insurance_company_title');
                        $companyURL = get_sub_field('insurance_company_url');
                        if($counterList % 5 == 0 && $counterList != 0){ echo '</div><div>'; }
                        if($companyURL) {
                            echo '<a href="' . $companyURL . '">' . $companyTitle . '</a>';
                        }else
                            echo '<p>' . $companyTitle . '</p>';
                    $counterList++;
                    endwhile;
                echo '</div></div></div>';
            }

            if( !empty( $welcomeInfo['appointment_title'] || $welcomeInfo['appointment_desc'] || $welcomeInfo['appointment_cta_url'] ) ){
                echo '<div class="group-2 group">';
                    if( !empty( $welcomeInfo['appointment_title'] ) ){
                        echo '<h3>' . $welcomeInfo['appointment_title'] . '</h3>';
                    }
                    if( !empty( $welcomeInfo['appointment_desc'] ) ){
                        echo '<p>' . $welcomeInfo['appointment_desc'] . '</p>';
                    }
                    if( !empty( $welcomeInfo['appointment_cta_url'] ) ){
                        echo '<a class="read-more" href="' . $welcomeInfo['appointment_cta_url'] . '"><span>' . $welcomeInfo['appointment_cta_text'] . '</span></a>';
                    }
                echo '</div>';
            }

            if( !empty( $welcomeInfo['location_title'] || $welcomeInfo['location_details'] ) ){
                echo '<div class="group-3 group">';
                    if( !empty( $welcomeInfo['location_title'] ) ){
                        echo '<h4>' . $welcomeInfo['location_title'] . '</h4>';
                    }
                    if( !empty( $welcomeInfo['location_details'] ) ){
                        echo '<p>' . $welcomeInfo['location_details'] . '</p>';
                    }
                echo '</div>';
            }
        echo '</div></section>';
    endwhile;
}

echo '<section class="welcome-section">' .
    '<div class="wrapper">' .
		'<div class="home-left">';

			while ( have_posts() ) : the_post();
                echo '<h1>' . get_the_title() . '</h1>';
				the_content();
			endwhile;

    echo '</div>';


		$welcomeSection = get_field('welcome_section');
		if(have_rows('welcome_section')) :
            echo '<div class="right-section">';
                while (have_rows('welcome_section')) : the_row();
                    if ( have_rows( 'welcome_services' ) ) :

                        echo '<ul class="welcome-services">';

                            while ( have_rows( 'welcome_services' ) ) : the_row();
                                $serviceIcon = get_sub_field('service_icon');
                                $serviceTitle = get_sub_field('service_title');
                                $serviceLink = get_sub_field('service_link');


                                $img_html = get_image( get_sub_field('service_icon'), 'small', true, false, array( 'class' => 'abc' ) );

                                echo '<li>' .
                                    '<div class="icon-part innbaner">' .
                                    (
                                        get_sub_field('service_icon')
                                        ? $img_html
                                        : ''
                                    ) .
                                    '</div>' .
                                    '<div class="content-part">' .
                                        '<h5>' .
                                            ( !empty( $serviceLink ) ? '<a href="' . $serviceLink . '">' : '' ) .
                                                $serviceTitle .
                                            ( !empty( $serviceLink ) ? '</a>' : '' ) .
                                        '</h5>' .
                                    '</div>'.
                                '</li>';
                            endwhile;

                        echo '</ul>';
                    endif;
                    if (get_field('appointment_cta_text', 'options')) :
                        echo '<div class="btn-center"><a class="read-more" href="' . get_field('appointment_cta_url', 'options') . '"><span>' .
                        get_field('appointment_cta_text', 'options') .
                        '</span></a></div>';
                    endif;
                endwhile;
            echo '</div>';
		endif;
	echo '</div>' .
'</section>';
?>
