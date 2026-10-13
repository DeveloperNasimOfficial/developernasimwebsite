<?php
/**
 * Process — sticky heading + steps.
 *
 * @package DeveloperNasim
 */

?>
<section class="section process" id="process">
	<div class="container process__grid">
		<header class="process__head">
			<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'How I work', 'developernasim' ); ?></p>
			<h2 class="h2" data-reveal><?php echo dn_rich( __( 'Structure first. Design second. *Results always.*', 'developernasim' ) ); // phpcs:ignore ?></h2>
			<p class="muted" data-reveal><?php esc_html_e( "I don't just open Elementor and start dragging blocks around. Every project follows the same proven process, so you always know what's next.", 'developernasim' ); ?></p>
			<a class="btn btn--brand" href="<?php echo esc_url( dn_contact_url() ); ?>" data-reveal data-magnetic><span><?php esc_html_e( 'Book a free call', 'developernasim' ); ?></span><?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?></a>
		</header>

		<ol class="steps">
			<?php foreach ( dn_process() as $i => $step ) : ?>
				<li class="step" data-reveal>
					<span class="step__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<div>
						<div class="step__top">
							<h3 class="step__title"><?php echo esc_html( $step['title'] ); ?></h3>
							<span class="tag tag--muted"><?php echo esc_html( $step['meta'] ); ?></span>
						</div>
						<p class="step__text"><?php echo esc_html( $step['text'] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
