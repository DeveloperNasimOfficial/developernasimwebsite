<?php
/**
 * 404.
 *
 * @package DeveloperNasim
 */

get_header();
?>
<section class="page-hero page-404">
	<div class="container">
		<p class="giant-404" data-reveal>404</p>
		<h1 class="h2" data-reveal><?php echo dn_rich( __( 'This page took a *wrong turn.*', 'developernasim' ) ); // phpcs:ignore ?></h1>
		<p class="lead" data-reveal><?php esc_html_e( "The structure of this site is solid, but this link isn't part of it.", 'developernasim' ); ?></p>
		<a class="btn btn--brand btn--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>" data-reveal><span><?php esc_html_e( 'Back home', 'developernasim' ); ?></span><?php echo dn_icon( 'arrow' ); // phpcs:ignore ?></a>
	</div>
</section>
<?php
get_footer();
