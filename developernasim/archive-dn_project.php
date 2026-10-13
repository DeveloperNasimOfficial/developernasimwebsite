<?php
/**
 * Work archive.
 *
 * @package DeveloperNasim
 */

get_header();
?>
<section class="page-hero">
	<div class="container">
		<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'Work', 'developernasim' ); ?></p>
		<h1 class="h1" data-reveal><?php echo dn_rich( __( 'Selected projects & *case studies.*', 'developernasim' ) ); // phpcs:ignore ?></h1>
		<?php
		$types = get_terms( array( 'taxonomy' => 'dn_project_type', 'hide_empty' => true ) );
		if ( $types && ! is_wp_error( $types ) ) :
			?>
			<ul class="chips chips--filter" data-reveal>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'dn_project' ) ); ?>" class="<?php echo is_tax() ? '' : 'is-active'; ?>"><?php esc_html_e( 'All', 'developernasim' ); ?></a></li>
				<?php foreach ( $types as $type ) : ?>
					<li><a href="<?php echo esc_url( get_term_link( $type ) ); ?>" class="<?php echo is_tax( 'dn_project_type', $type->term_id ) ? 'is-active' : ''; ?>"><?php echo esc_html( $type->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
<section class="section section--tight">
	<div class="container">
		<div class="work__grid">
			<?php
			$i = 0;
			while ( have_posts() ) :
				the_post();
				$terms = get_the_terms( get_the_ID(), 'dn_project_type' );
				get_template_part(
					'template-parts/card',
					'project',
					array(
						'index'   => $i++,
						'project' => array(
							'title'   => get_the_title(),
							'type'    => get_post_meta( get_the_ID(), '_dn_industry', true ) ?: ( $terms && ! is_wp_error( $terms ) ? $terms[0]->name : '' ),
							'year'    => get_post_meta( get_the_ID(), '_dn_year', true ),
							'excerpt' => get_the_excerpt(),
							'url'     => get_permalink(),
							'image'   => get_the_post_thumbnail( null, 'dn-card', array( 'loading' => 'lazy' ) ),
							'mockup'  => 'service',
							'palette' => array( '#111111', dn_mod( 'brand_color' ), '#F4F4F2' ),
							'concept' => false,
						),
					)
				);
			endwhile;
			?>
		</div>
		<div class="pagination"><?php the_posts_pagination(); ?></div>
	</div>
</section>
<?php
get_footer();
