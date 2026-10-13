<?php
/**
 * Testimonials.
 *
 * @package DeveloperNasim
 */

$items = dn_get_testimonials();
?>
<section class="section testimonials" id="reviews">
	<div class="container">
		<header class="section-head section-head--center">
			<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'Client love', 'developernasim' ); ?></p>
			<h2 class="h2" data-reveal><?php echo dn_rich( __( "Don't take my word for it, *take theirs.*", 'developernasim' ) ); // phpcs:ignore ?></h2>
			<?php if ( dn_mod( 'upwork_url' ) ) : ?>
				<a class="rating-badge" href="<?php echo esc_url( dn_mod( 'upwork_url' ) ); ?>" target="_blank" rel="noopener" data-reveal>
					<span class="rating-badge__stars"><?php echo str_repeat( dn_icon( 'star' ), 5 ); // phpcs:ignore ?></span>
					<span><?php esc_html_e( 'Top Rated Plus on Upwork · 21 reviews', 'developernasim' ); ?></span>
					<?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?>
				</a>
			<?php endif; ?>
		</header>

		<div class="quotes">
			<?php foreach ( $items as $i => $t ) : ?>
				<figure class="quote" data-reveal data-spotlight style="--d:<?php echo esc_attr( $i * 0.1 ); ?>s">
					<div class="quote__stars" aria-label="<?php echo esc_attr( sprintf( __( '%d star rating', 'developernasim' ), $t['rating'] ) ); ?>"><?php echo str_repeat( dn_icon( 'star' ), max( 1, min( 5, (int) $t['rating'] ) ) ); // phpcs:ignore ?></div>
					<blockquote><p>&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</p></blockquote>
					<figcaption>
						<span class="quote__avatar">
							<?php if ( ! empty( $t['avatar'] ) ) : ?>
								<img src="<?php echo esc_url( $t['avatar'] ); ?>" alt="" width="44" height="44" loading="lazy">
							<?php else : ?>
								<?php echo esc_html( mb_substr( $t['name'], 0, 1 ) ); ?>
							<?php endif; ?>
						</span>
						<span><strong><?php echo esc_html( $t['name'] ); ?></strong><small><?php echo esc_html( $t['role'] ); ?></small></span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
