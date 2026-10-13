<?php
/**
 * Header.
 *
 * @package DeveloperNasim
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'developernasim' ); ?></a>

<div class="cursor" aria-hidden="true"><span class="cursor__label"><?php esc_html_e( 'View', 'developernasim' ); ?></span></div>

<header class="site-header" data-header>
	<div class="nav">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( dn_mod( 'full_name' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'class' => 'brand__logo' ) ); ?>
			<?php else : ?>
				<span class="brand__mark" aria-hidden="true"><?php echo esc_html( mb_substr( dn_mod( 'short_name' ), 0, 1 ) ); ?></span>
				<span class="brand__name"><?php echo esc_html( strtolower( dn_mod( 'short_name' ) ) ); ?><i>.</i></span>
			<?php endif; ?>
		</a>

		<nav class="nav__menu" aria-label="<?php esc_attr_e( 'Primary', 'developernasim' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav__list',
					'depth'          => 1,
					'fallback_cb'    => 'dn_fallback_menu',
				)
			);
			?>
		</nav>

		<div class="nav__actions">
			<button class="theme-toggle" type="button" data-theme-toggle aria-label="<?php esc_attr_e( 'Toggle dark mode', 'developernasim' ); ?>">
				<?php echo dn_icon( 'sun' ) . dn_icon( 'moon' ); // phpcs:ignore ?>
			</button>
			<a class="btn btn--brand btn--sm nav__cta" href="<?php echo esc_url( dn_contact_url() ); ?>" data-magnetic>
				<span><?php esc_html_e( "Let's talk", 'developernasim' ); ?></span>
				<?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?>
			</a>
			<button class="burger" type="button" data-menu-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'developernasim' ); ?>">
				<span></span><span></span>
			</button>
		</div>
	</div>
</header>

<div class="mobile-menu" id="mobile-menu" hidden>
	<nav aria-label="<?php esc_attr_e( 'Mobile', 'developernasim' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav__list',
				'depth'          => 1,
				'fallback_cb'    => 'dn_fallback_menu',
			)
		);
		?>
	</nav>
	<a class="btn btn--brand" href="<?php echo esc_url( dn_contact_url() ); ?>"><span><?php esc_html_e( "Let's talk", 'developernasim' ); ?></span><?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?></a>
</div>

<main id="main" class="site-main">
