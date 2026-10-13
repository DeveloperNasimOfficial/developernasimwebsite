<?php
/**
 * Free Loom audit offer.
 *
 * @package DeveloperNasim
 */

?>
<section class="section offer" id="audit">
	<div class="container">
		<div class="offer__card" data-reveal>
			<div class="offer__glow" aria-hidden="true"></div>
			<div class="offer__copy">
				<p class="eyebrow eyebrow--light"><span class="dot"></span><?php esc_html_e( 'Free website audit', 'developernasim' ); ?></p>
				<h2 class="h2"><?php echo esc_html( dn_mod( 'offer_title' ) ); ?></h2>
				<p class="offer__text"><?php echo esc_html( dn_mod( 'offer_text' ) ); ?></p>
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( dn_contact_url() ); ?>" data-magnetic>
					<span><?php esc_html_e( 'Request my free Loom audit', 'developernasim' ); ?></span><?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?>
				</a>
			</div>
			<div class="offer__visual" aria-hidden="true">
				<div class="loom">
					<div class="loom__screen">
						<div class="loom__bar"></div>
						<div class="loom__line" style="width:70%"></div>
						<div class="loom__line" style="width:50%"></div>
						<div class="loom__issue"><b>!</b> <?php esc_html_e( 'CTA below the fold', 'developernasim' ); ?></div>
						<div class="loom__issue loom__issue--2"><b>!</b> <?php esc_html_e( 'LCP 4.8s on mobile', 'developernasim' ); ?></div>
						<span class="loom__play"><?php echo dn_icon( 'play' ); // phpcs:ignore ?></span>
					</div>
					<div class="loom__cam"><?php echo esc_html( mb_substr( dn_mod( 'short_name' ), 0, 1 ) ); ?></div>
				</div>
			</div>
		</div>
	</div>
</section>
