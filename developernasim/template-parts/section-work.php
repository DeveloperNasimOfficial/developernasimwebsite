<?php
/**
 * Selected work.
 *
 * @package DeveloperNasim
 */

$projects = dn_get_projects( 4 );
$has_real = ! $projects[0]['concept'];
?>
<section class="section work" id="work">
	<div class="container">
		<header class="section-head">
			<div>
				<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'Selected work', 'developernasim' ); ?></p>
				<h2 class="h2" data-reveal><?php echo dn_rich( __( 'Websites built to *perform*, not just look good.', 'developernasim' ) ); // phpcs:ignore ?></h2>
			</div>
			<?php if ( $has_real ) : ?>
				<a class="link-arrow" href="<?php echo esc_url( get_post_type_archive_link( 'dn_project' ) ); ?>" data-reveal><?php esc_html_e( 'All projects', 'developernasim' ); ?> <?php echo dn_icon( 'arrow' ); // phpcs:ignore ?></a>
			<?php endif; ?>
		</header>

		<div class="work__grid">
			<?php foreach ( $projects as $i => $project ) : ?>
				<?php get_template_part( 'template-parts/card', 'project', array( 'project' => $project, 'index' => $i ) ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
