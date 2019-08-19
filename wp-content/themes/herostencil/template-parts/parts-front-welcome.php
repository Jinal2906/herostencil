<?php
wp_enqueue_style( 'front-welcome' );

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

echo '<section class="welcome-section py-50">' .
    '<div class="wrapper d-flex align-items-center row-15">' .
		'<div class="welcome-desc px-15 cell-5 ">';
			while ( have_posts() ) : the_post();
                echo '<h1 class="text-secondary hover-text-primary">' . get_the_title() . '</h1>';
				the_content();
			endwhile;
    echo '</div>';
		$welcomeSection = get_field('welcome_section');
		if( have_rows('welcome_section') ) :
            echo '<div class="welcome-services-div cell-7 px-15 ">';
                while ( have_rows('welcome_section') ) : the_row();
                    if ( have_rows( 'welcome_services' ) ) :
                        echo '<ul class="welcome-services-list d-flex row-10 list-none">';
                            while ( have_rows( 'welcome_services' ) ) : the_row();
                                $serviceIcon = get_sub_field('service_icon');
                                $serviceTitle = get_sub_field('service_title');
                                $serviceLink = get_sub_field('service_link');
                                echo '<li class=" cell-4 p-10 ">' .
                                    '<div class="icon-part innbaner image-src pt-100 border-radius-full mb-20 ">' .
                                    (
                                        get_sub_field('service_icon')
                                        ? wp_get_attachment_image( get_sub_field('service_icon'), 'small' )
                                        : ''
                                    ) .
                                    '</div>' .
                                    '<div class="content-part">' .
                                        ( !empty( $serviceLink ) ? '<a href="' . $serviceLink . '">' : '' ) .
                                        '<h5 class="text-20 text-767-18 text-480-16 text-center">' .
                                            $serviceTitle .
                                        '</h5>' .
                                        ( !empty( $serviceLink ) ? '</a>' : '' ) .
                                    '</div>'.
                                '</li>';
                            endwhile;
                        echo '</ul>';
                    endif;
                    if (get_field('appointment_cta_text', 'options')) :
                        echo '<div class="text-right"><a class="read-more" href="' . get_field('appointment_cta_url', 'options') . '"><span>' .
                        get_field('appointment_cta_text', 'options') .
                        '</span></a></div>';
                    endif;
                endwhile;
            echo '</div>';
		endif;
	echo '</div>' .
'</section>';
?>
