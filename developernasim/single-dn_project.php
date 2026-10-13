<?php
/**
 * Project case study.
 *
 * @package DeveloperNasim
 */

get_header();
while ( have_posts() ) :
	the_post();
	$id       = get_the_ID();
	$details  = array_filter(
		array(
			__( 'Client', 'developernasim' )   => get_post_meta( $id, '_dn_client', true ),
			__( 'Industry', 'developernasim' ) => get_post_meta( $id, '_dn_industry', true ),
			__( 'Year', 'developernasim' )     => get_post_meta( $id, '_dn_year', true ),
			__( 'Services', 'developernasim' ) => get_post_meta( $id, '_dn_services', true ),
		)
	);
	$live     = get_post_meta( $id, '_dn_live_url', true );
	$result   = get_post_meta( $id, '_dn_result', true );
	$next     = get_adjacent_post( false, '', false ) ?: get_adjacent_post( false, '', true );
	?>
	<article <?php post_class( 'case' ); ?>>
		<header class="page-hero">
			<div class="container">
				<a class="link-arrow link-arrow--back" href="<?php echo esc_url( get_post_type_archive_link( 'dn_project' ) ); ?>" data-reveal>← <?php esc_html_e( 'All work', 'developernasim' ); ?></a>
				<h1 class="h1" data-reveal><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="lead" data-reveal><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
				<dl class="case__details" data-reveal>
					<?php foreach ( $details as $label => $value ) : ?>
						<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div>
					<?php endforeach; ?>
					<?php if ( $live ) : ?>
						<div><dt><?php esc_html_e( 'Live site', 'developernasim' ); ?></dt><dd><a href="<?php echo esc_url( $live ); ?>" target="_blank" rel="noopener"><?php echo esc_html( wp_parse_url( $live, PHP_URL_HOST ) ); ?> ↗</a></dd></div>
					<?php endif; ?>
				</dl>
			</div>
		</header>

		<div class="container">
			<div class="cover" data-reveal>
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'dn-wide' );
				} else {
					echo dn_mockup( 'service', array( '#111111', dn_mod( 'brand_color' ), '#F4F4F2' ), get_the_title() ); // phpcs:ignore
				}
				?>
			</div>
			<?php if ( $result ) : ?>
				<p class="case__result" data-reveal><span><?php esc_html_e( 'Result', 'developernasim' ); ?></span><?php echo esc_html( $result ); ?></p>
			<?php endif; ?>
		</div>

		<div class="container container--narrow">
			<div class="prose"><?php the_content(); ?></div>
		</div>

		<?php if ( $next ) : ?>
			<a class="next-project" href="<?php echo esc_url( get_permalink( $next ) ); ?>" data-cursor="view">
				<div class="container">
					<small><?php esc_html_e( 'Next project', 'developernasim' ); ?></small>
					<span><?php echo esc_html( get_the_title( $next ) ); ?> <?php echo dn_icon( 'arrow' ); // phpcs:ignore ?></span>
				</div>
			</a>
		<?php endif; ?>
	</article>
	<?php
endwhile;
get_footer();
