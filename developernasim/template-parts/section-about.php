<?php
/**
 * About — story statement, portrait card and stats.
 *
 * @package DeveloperNasim
 */

$portrait = dn_mod( 'portrait' );
$words    = preg_split( '/\s+/', dn_mod( 'story_statement' ), -1, PREG_SPLIT_NO_EMPTY );
?>
<section class="section about" id="about">
	<div class="container">
		<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'About me', 'developernasim' ); ?></p>

		<div class="about__grid">
			<figure class="portrait" data-reveal data-tilt>
				<?php if ( $portrait ) : ?>
					<img src="<?php echo esc_url( $portrait ); ?>" alt="<?php echo esc_attr( dn_mod( 'full_name' ) ); ?>" loading="lazy" width="640" height="800">
				<?php else : ?>
					<div class="portrait__placeholder" aria-hidden="true">
						<span><?php echo esc_html( mb_substr( dn_mod( 'short_name' ), 0, 1 ) ); ?></span>
					</div>
				<?php endif; ?>
				<figcaption class="portrait__caption">
					<strong><?php echo esc_html( dn_mod( 'full_name' ) ); ?></strong>
					<span><?php echo esc_html( dn_mod( 'location' ) ); ?> · UTC+6</span>
				</figcaption>
				<span class="portrait__sticker" aria-hidden="true">
					<svg viewBox="0 0 100 100"><defs><path id="dn-circle" d="M50 50m-38 0a38 38 0 1 1 76 0a38 38 0 1 1-76 0"/></defs><text><textPath href="#dn-circle">STRUCTURE · DESIGN · RESULTS · </textPath></text></svg>
					<b>✦</b>
				</span>
			</figure>

			<div class="about__body">
				<p class="statement" data-highlight>
					<?php foreach ( $words as $word ) : ?>
						<span><?php echo esc_html( $word ); ?></span>
					<?php endforeach; ?>
				</p>

				<div class="about__facts" data-reveal>
					<div><small><?php esc_html_e( 'Focus', 'developernasim' ); ?></small><span>WordPress · Elementor · WooCommerce</span></div>
					<div><small><?php esc_html_e( 'Education', 'developernasim' ); ?></small><span>MSc Computer Science · MTech</span></div>
					<div><small><?php esc_html_e( 'Languages', 'developernasim' ); ?></small><span>English, Bengali + 5 conversational</span></div>
				</div>

				<div class="about__ctas" data-reveal>
					<a class="btn btn--dark" href="<?php echo esc_url( dn_contact_url() ); ?>" data-magnetic><span><?php esc_html_e( 'Work with me', 'developernasim' ); ?></span><?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?></a>
					<?php if ( dn_mod( 'youtube_url' ) ) : ?>
						<a class="btn btn--ghost" href="<?php echo esc_url( dn_mod( 'youtube_url' ) ); ?>" target="_blank" rel="noopener"><?php echo dn_icon( 'play' ); // phpcs:ignore ?><span><?php esc_html_e( 'Watch my intro', 'developernasim' ); ?></span></a>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="stats">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<?php if ( ! dn_mod( "stat_{$i}_value" ) ) { continue; } ?>
				<div class="stat" data-reveal style="--d:<?php echo esc_attr( ( $i - 1 ) * 0.08 ); ?>s">
					<p class="stat__value">
						<?php echo esc_html( dn_mod( "stat_{$i}_prefix" ) ); ?><span data-count="<?php echo esc_attr( dn_mod( "stat_{$i}_value" ) ); ?>"><?php echo esc_html( dn_mod( "stat_{$i}_value" ) ); ?></span><?php echo esc_html( dn_mod( "stat_{$i}_suffix" ) ); ?>
					</p>
					<p class="stat__label"><?php echo esc_html( dn_mod( "stat_{$i}_label" ) ); ?></p>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</section>
