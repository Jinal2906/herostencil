<?php
wp_enqueue_style( 'content-patientinfo' );
if( have_rows('patient_form_section') ):
    echo '<ul class="patient-form-listing">';
    $formSequence = 1;
    while ( have_rows('patient_form_section') ) : the_row();
    $formImage = get_sub_field('form_image');
    $formTitle = get_sub_field('form_title');
    $formCTAText = get_sub_field('form_button_text');
    $pdfOrLink = get_sub_field('would_you_like_to_add_the_link_or_file_on_button');
    $formPDF = get_sub_field('pdf_file');
    $formURL = get_sub_field('button_link');
    $newTab = get_sub_field('open_in_new_window');
    echo '<li>' . ( $formImage
            ? '<div class="form-image"><span class="form-number">' . $formSequence . '</span>' . wp_get_attachment_image( $formImage , 'full' ) . '</div>'
            : '' ) . ( $formTitle
            ? '<h3>' . $formTitle . '</h3>'
            : '' ) . ( $formPDF || $formURL
            ? '<div class="btn-center"><a class="read-more" ' . ( ( "Yes" == $newTab ? 'target="_Blank"' : '' ) ) . ' href="' . ( ( $formPDF ? $formPDF : $formURL ) ) . '"><span>' . $formCTAText . '</span></a></div>'
            : '' ) .
        '</li>';
    $formSequence++;
    endwhile;
    echo '</ul>';
else :

    // no rows found

endif;

?>