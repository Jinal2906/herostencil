<?php
wp_enqueue_style( 'parts-front-testimonials' );
$testimonials = get_field('testimonials_section');
if( have_rows('testimonials_section') ) {
	while ( have_rows('testimonials_section') ) : the_row();
		echo '<section class="testimonials-section width-full height-auto position-relative d-block py-50 ">' .
		'<div class="wrapper d-flex align-items-center justify-content-between ">';
			if( !empty( $testimonials['testimonial_section_image'] ) ){
				echo '<div class="left-image cell-4 cell-568-8 mx-auto cell-480-10 cell-359-12 mb-568-20 ">' .
					'<div class="testi-image innbaner image-src pt-100 border-radius-full overflow-hidden">' .
						(
							get_sub_field('testimonial_section_image')
							? wp_get_attachment_image( get_sub_field('testimonial_section_image'), 'large', false, array( 'class' => '' ) )
							: ''
						) .
					'</div>' .
				'</div>';
			}
		$posts = get_sub_field('select_testimonials');
		if( $posts ) {
			echo '<div class="testimonials-slider pl-20 cell-8 cell-568-12 ">' .
				'<div class="slider-wrapper ">';
				foreach( $posts as $post):
				setup_postdata($post);
					echo '<div class="single-testimonial text-center">' .
						(
							get_field('testimonial_title')
							? '<h3 class="text-secondary text-24 d-flex flex-nowrap align-items-center justify-content-center">' . '<svg class="icon width-35 height-35 fill-primary mr-10"><use xlink:href="#square-quote-left" /></svg>' . get_field('testimonial_title') . '<svg class="icon width-35 height-35 fill-primary ml-10"><use xlink:href="#square-quote-right" /></svg>' . '</h3>'
							: ''
						) .
						(
							has_excerpt()
							? apply_filters( 'the_content', get_the_excerpt() )
							: apply_filters( 'the_content', wp_trim_words( get_the_content(), 20 ) )
						) .
						'<hr class="cell-6">' .
						(
							get_field('author_name')
							? '<h4>' . get_field('author_name') . '</h4>'
							: ''
						) .
					'</div>';
				endforeach;
			echo '</div>' .
			 '</div>';
		}
		echo '</div>' .
		'</section>';
	endwhile; wp_reset_query();
}
?>
