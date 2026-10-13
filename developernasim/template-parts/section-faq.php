<?php
/**
 * FAQ accordion.
 *
 * @package DeveloperNasim
 */

?>
<section class="section faq" id="faq">
	<div class="container faq__grid">
		<header class="faq__head">
			<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'FAQ', 'developernasim' ); ?></p>
			<h2 class="h2" data-reveal><?php echo dn_rich( __( 'Questions, *answered.*', 'developernasim' ) ); // phpcs:ignore ?></h2>
			<p class="muted" data-reveal><?php esc_html_e( "Can't find what you're looking for? Send me a message. I usually reply within a few hours.", 'developernasim' ); ?></p>
			<a class="link-arrow" href="<?php echo esc_url( dn_contact_url() ); ?>" data-reveal><?php esc_html_e( 'Ask me anything', 'developernasim' ); ?> <?php echo dn_icon( 'arrow' ); // phpcs:ignore ?></a>
		</header>
		<div class="accordion">
			<?php foreach ( dn_faq() as $i => $item ) : ?>
				<details class="accordion__item" data-reveal <?php echo 0 === $i ? 'open' : ''; ?>>
					<summary><?php echo esc_html( $item['q'] ); ?><span class="accordion__icon"><?php echo dn_icon( 'plus' ); // phpcs:ignore ?></span></summary>
					<div class="accordion__body"><p><?php echo esc_html( $item['a'] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
