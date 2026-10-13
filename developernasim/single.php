<?php
/**
 * Single post.
 *
 * @package DeveloperNasim
 */

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class(); ?>>
		<header class="page-hero page-hero--narrow">
			<div class="container container--narrow">
				<p class="eyebrow" data-reveal><span class="dot"></span><?php echo esc_html( get_the_date() ); ?></p>
				<h1 class="h1" data-reveal><?php the_title(); ?></h1>
			</div>
		</header>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="container"><div class="cover" data-reveal><?php the_post_thumbnail( 'dn-wide' ); ?></div></div>
		<?php endif; ?>
		<div class="container container--narrow">
			<div class="prose"><?php the_content(); ?></div>
			<?php
			wp_link_pages();
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>
	<?php
endwhile;
get_footer();
