<?php
/**
 * Project card.
 *
 * @package DeveloperNasim
 */

$p   = $args['project'];
$tag = $p['url'] ? 'a' : 'div';
?>
<<?php echo $tag; // phpcs:ignore ?> class="project-card" <?php echo $p['url'] ? 'href="' . esc_url( $p['url'] ) . '" data-cursor="view"' : ''; ?> data-reveal style="--d:<?php echo esc_attr( ( $args['index'] % 2 ) * 0.12 ); ?>s">
	<div class="project-card__media">
		<?php
		if ( $p['image'] ) {
			echo $p['image']; // phpcs:ignore
		} else {
			echo dn_mockup( $p['mockup'], $p['palette'], $p['title'] ); // phpcs:ignore
		}
		?>
		<?php if ( $p['concept'] ) : ?>
			<span class="project-card__badge"><?php esc_html_e( 'Concept', 'developernasim' ); ?></span>
		<?php endif; ?>
		<?php if ( $p['url'] ) : ?>
			<span class="project-card__go" aria-hidden="true"><?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?></span>
		<?php endif; ?>
	</div>
	<div class="project-card__meta">
		<div>
			<h3 class="project-card__title"><?php echo esc_html( $p['title'] ); ?></h3>
			<p class="project-card__excerpt"><?php echo esc_html( $p['excerpt'] ); ?></p>
		</div>
		<div class="project-card__tags">
			<?php if ( $p['type'] ) : ?><span class="tag"><?php echo esc_html( $p['type'] ); ?></span><?php endif; ?>
			<?php if ( $p['year'] ) : ?><span class="tag tag--muted"><?php echo esc_html( $p['year'] ); ?></span><?php endif; ?>
		</div>
	</div>
</<?php echo $tag; // phpcs:ignore ?>>
