<?php
/**
 * Footer.
 *
 * @package DeveloperNasim
 */

?>
</main>

<footer class="site-footer" id="contact">
	<div class="container">
		<div class="footer__top">
			<div class="footer__intro" data-reveal>
				<p class="eyebrow"><span class="dot"></span><?php echo esc_html( dn_mod( 'availability' ) ?: __( 'Get in touch', 'developernasim' ) ); ?></p>
				<h2 class="footer__title"><?php echo dn_rich( dn_mod( 'cta_title' ) ); // phpcs:ignore ?></h2>
				<p class="footer__text"><?php echo esc_html( dn_mod( 'cta_text' ) ); ?></p>
				<div class="footer__ctas">
					<a class="btn btn--brand btn--lg" href="<?php echo esc_url( dn_contact_url() ); ?>" data-magnetic>
						<span><?php esc_html_e( 'Start a project', 'developernasim' ); ?></span><?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?>
					</a>
					<?php if ( dn_mod( 'email' ) ) : ?>
						<a class="btn btn--ghost btn--lg" href="mailto:<?php echo esc_attr( antispambot( dn_mod( 'email' ) ) ); ?>">
							<?php echo dn_icon( 'mail' ); // phpcs:ignore ?><span><?php echo esc_html( antispambot( dn_mod( 'email' ) ) ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="footer__cols">
				<div>
					<h3 class="footer__h"><?php esc_html_e( 'Navigate', 'developernasim' ); ?></h3>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'nav__list footer__list',
							'depth'          => 1,
							'fallback_cb'    => 'dn_fallback_menu',
						)
					);
					?>
				</div>
				<div>
					<h3 class="footer__h"><?php esc_html_e( 'Elsewhere', 'developernasim' ); ?></h3>
					<ul class="footer__list">
						<?php foreach ( dn_socials() as $social ) : ?>
							<li><a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $social['label'] ); ?> <?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div>
					<h3 class="footer__h"><?php esc_html_e( 'Local time', 'developernasim' ); ?></h3>
					<p class="footer__time"><span data-clock>—</span><br><small><?php echo esc_html( dn_mod( 'location' ) ); ?></small></p>
				</div>
			</div>
		</div>

		<div class="footer__giant" aria-hidden="true" data-reveal>
			<span><?php echo esc_html( dn_mod( 'short_name' ) ); ?></span><i>.</i>
		</div>

		<div class="footer__bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) . ' ' . dn_mod( 'full_name' ) ); ?>. <?php echo esc_html( dn_mod( 'footer_note' ) ); ?></p>
			<a href="#main" class="to-top"><?php esc_html_e( 'Back to top', 'developernasim' ); ?> ↑</a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
