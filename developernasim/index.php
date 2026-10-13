<?php
/**
 * Blog / fallback index.
 *
 * @package DeveloperNasim
 */

get_header();
?>
<section class="page-hero">
	<div class="container">
		<p class="eyebrow" data-reveal><span class="dot"></span><?php echo is_home() ? esc_html__( 'Journal', 'developernasim' ) : esc_html__( 'Archive', 'developernasim' ); ?></p>
		<h1 class="h1" data-reveal>
			<?php
			if ( is_home() ) {
				echo dn_rich( __( 'Notes on WordPress, *design & growth.*', 'developernasim' ) ); // phpcs:ignore
			} elseif ( is_search() ) {
				/* translators: %s: search query. */
				printf( esc_html__( 'Results for “%s”', 'developernasim' ), esc_html( get_search_query() ) );
			} else {
				the_archive_title();
			}
			?>
		</h1>
	</div>
</section>

<section class="section section--tight">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="posts">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'post-card' ); ?> data-reveal>
						<a href="<?php the_permalink(); ?>" class="post-card__link">
							<div class="post-card__media">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'dn-card', array( 'loading' => 'lazy' ) ); ?>
								<?php else : ?>
									<span class="post-card__ph" aria-hidden="true"><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span>
								<?php endif; ?>
							</div>
							<p class="post-card__meta"><?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( max( 1, round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 220 ) ) ); ?> min read</p>
							<h2 class="post-card__title"><?php the_title(); ?></h2>
							<p class="post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
						</a>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="pagination"><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?></div>
		<?php else : ?>
			<p class="lead"><?php esc_html_e( 'Nothing here yet.', 'developernasim' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
