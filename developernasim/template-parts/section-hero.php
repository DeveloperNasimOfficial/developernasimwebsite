<?php
/**
 * Hero.
 *
 * @package DeveloperNasim
 */

$portrait = dn_mod( 'portrait' );
?>
<section class="hero" id="top">
	<div class="hero__bg" aria-hidden="true">
		<div class="hero__grid"></div>
		<div class="hero__glow"></div>
	</div>

	<div class="container hero__inner">
		<?php if ( dn_mod( 'availability' ) ) : ?>
			<p class="pill hero__pill" data-reveal>
				<span class="pulse" aria-hidden="true"></span>
				<?php echo esc_html( dn_mod( 'availability' ) ); ?>
				<span class="pill__sep">·</span>
				<span class="pill__muted"><?php echo esc_html( date_i18n( 'F Y' ) ); ?></span>
			</p>
		<?php endif; ?>

		<h1 class="hero__title" data-split><?php echo dn_split_words( dn_mod( 'hero_title' ) ); // phpcs:ignore ?></h1>

		<div class="hero__row">
			<div class="hero__copy" data-reveal style="--d:.5s">
				<p class="lead"><?php echo esc_html( dn_mod( 'hero_text' ) ); ?></p>
				<div class="hero__ctas">
					<a class="btn btn--brand btn--lg" href="<?php echo esc_url( dn_audit_url() ); ?>" data-magnetic>
						<span><?php echo esc_html( dn_mod( 'hero_cta_label' ) ); ?></span><?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?>
					</a>
					<a class="btn btn--ghost btn--lg" href="#work">
						<span><?php echo esc_html( dn_mod( 'hero_cta2_label' ) ); ?></span><?php echo dn_icon( 'arrow' ); // phpcs:ignore ?>
					</a>
				</div>
			</div>

			<aside class="proof-card" data-reveal style="--d:.65s">
				<div class="proof-card__top">
					<div class="avatar">
						<?php if ( $portrait ) : ?>
							<img src="<?php echo esc_url( $portrait ); ?>" alt="<?php echo esc_attr( dn_mod( 'full_name' ) ); ?>" width="56" height="56">
						<?php else : ?>
							<span><?php echo esc_html( mb_substr( dn_mod( 'short_name' ), 0, 1 ) ); ?></span>
						<?php endif; ?>
						<i class="avatar__status" aria-hidden="true"></i>
					</div>
					<div>
						<strong><?php echo esc_html( dn_mod( 'full_name' ) ); ?></strong>
						<span><?php echo esc_html( dn_mod( 'role' ) ); ?></span>
					</div>
				</div>
				<div class="proof-card__stars" aria-label="<?php esc_attr_e( '5 star rating', 'developernasim' ); ?>">
					<?php echo str_repeat( dn_icon( 'star' ), 5 ); // phpcs:ignore ?>
					<span><?php esc_html_e( 'Top Rated Plus', 'developernasim' ); ?></span>
				</div>
				<ul class="proof-card__list">
					<li><?php echo dn_icon( 'check' ); // phpcs:ignore ?><?php esc_html_e( 'Top 3% WordPress developer on Upwork', 'developernasim' ); ?></li>
					<li><?php echo dn_icon( 'check' ); // phpcs:ignore ?><?php esc_html_e( '35+ projects · 21 client reviews', 'developernasim' ); ?></li>
					<li><?php echo dn_icon( 'check' ); // phpcs:ignore ?><?php echo esc_html( sprintf( __( 'Based in %s, working worldwide', 'developernasim' ), dn_mod( 'location' ) ) ); ?></li>
				</ul>
			</aside>
		</div>
	</div>

	<a class="hero__scroll" href="#work" aria-label="<?php esc_attr_e( 'Scroll to work', 'developernasim' ); ?>"><span></span></a>
</section>
