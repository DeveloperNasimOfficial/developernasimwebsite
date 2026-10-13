<?php
/**
 * Front page — the personal brand landing page.
 *
 * @package DeveloperNasim
 */

get_header();

$sections = array( 'hero', 'marquee', 'work', 'about', 'services', 'process', 'experience', 'testimonials', 'offer', 'faq' );
foreach ( $sections as $section ) {
	get_template_part( 'template-parts/section', $section );
}

get_footer();
