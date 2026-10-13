<?php
/**
 * Experience list.
 *
 * @package DeveloperNasim
 */

?>
<section class="section experience" id="experience">
	<div class="container">
		<header class="section-head">
			<div>
				<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'Experience', 'developernasim' ); ?></p>
				<h2 class="h2" data-reveal><?php echo dn_rich( __( 'Trusted by teams *across the world.*', 'developernasim' ) ); // phpcs:ignore ?></h2>
			</div>
		</header>
		<ul class="xp">
			<?php foreach ( dn_experience() as $i => $row ) : ?>
				<li class="xp__row" data-reveal>
					<span class="xp__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<span class="xp__company"><?php echo esc_html( $row['company'] ); ?></span>
					<span class="xp__role"><?php echo esc_html( $row['role'] ); ?></span>
					<span class="xp__icon" aria-hidden="true"><?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
