<?php
/**
 * Infinite skills marquee.
 *
 * @package DeveloperNasim
 */

$items = dn_marquee_items();
?>
<section class="marquee" aria-label="<?php esc_attr_e( 'Skills', 'developernasim' ); ?>">
	<div class="marquee__track">
		<?php for ( $copy = 0; $copy < 2; $copy++ ) : ?>
			<ul class="marquee__list" <?php echo $copy ? 'aria-hidden="true"' : ''; ?>>
				<?php foreach ( $items as $item ) : ?>
					<li><?php echo esc_html( $item ); ?><span class="marquee__star" aria-hidden="true">✦</span></li>
				<?php endforeach; ?>
			</ul>
		<?php endfor; ?>
	</div>
</section>
