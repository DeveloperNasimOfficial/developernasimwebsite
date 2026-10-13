<?php
/**
 * Page.
 *
 * @package DeveloperNasim
 */

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<header class="page-hero page-hero--narrow">
		<div class="container container--narrow">
			<h1 class="h1" data-reveal><?php the_title(); ?></h1>
		</div>
	</header>
	<div class="container container--narrow">
		<div class="prose"><?php the_content(); ?></div>
	</div>
	<?php
endwhile;
get_footer();
