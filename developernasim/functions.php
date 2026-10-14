<?php
/**
 * Developer Nasim — theme bootstrap.
 *
 * @package DeveloperNasim
 */

defined( 'ABSPATH' ) || exit;

define( 'DN_VERSION', '1.0.0' );
define( 'DN_DIR', get_template_directory() );
define( 'DN_URI', get_template_directory_uri() );

require DN_DIR . '/inc/defaults.php';
require DN_DIR . '/inc/helpers.php';
require DN_DIR . '/inc/mockups.php';
require DN_DIR . '/inc/post-types.php';
require DN_DIR . '/inc/customizer.php';
require DN_DIR . '/inc/audit.php';

/**
 * Theme supports & menus.
 */
function dn_setup() {
	load_theme_textdomain( 'developernasim', DN_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_image_size( 'dn-card', 1200, 900, true );
	add_image_size( 'dn-wide', 1920, 1080, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'developernasim' ),
			'footer'  => __( 'Footer menu', 'developernasim' ),
		)
	);
}
add_action( 'after_setup_theme', 'dn_setup' );

/**
 * Styles & scripts.
 */
function dn_assets() {
	wp_enqueue_style(
		'dn-fonts',
		'https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,300..800;1,300..800&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'dn-style', get_stylesheet_uri(), array( 'dn-fonts' ), DN_VERSION );
	wp_add_inline_style( 'dn-style', dn_brand_css() );

	wp_enqueue_script( 'dn-main', DN_URI . '/assets/js/main.js', array(), DN_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
	wp_localize_script(
		'dn-main',
		'DN',
		array(
			'timezone' => dn_mod( 'timezone' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dn_assets' );

/**
 * Preconnect to Google Fonts.
 */
function dn_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'dn_resource_hints', 10, 2 );

/**
 * Apply the saved theme before first paint to avoid a flash.
 */
function dn_theme_boot_script() {
	?>
	<script>(function(){try{var t=localStorage.getItem('dn-theme');if(t){document.documentElement.setAttribute('data-theme',t);}}catch(e){}document.documentElement.classList.add('js');})();</script>
	<?php
}
add_action( 'wp_head', 'dn_theme_boot_script', 1 );

/**
 * Brand color tokens from the Customizer.
 */
function dn_brand_css() {
	$brand = sanitize_hex_color( dn_mod( 'brand_color' ) ) ?: '#3B5BFF';
	$ink   = sanitize_hex_color( dn_mod( 'brand_ink' ) ) ?: '#FFFFFF';
	return ":root{--brand:{$brand};--brand-ink:{$ink};}";
}

/**
 * Body classes.
 */
function dn_body_class( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-home';
	}
	return $classes;
}
add_filter( 'body_class', 'dn_body_class' );

/**
 * Basic SEO + social meta when no SEO plugin is active.
 */
function dn_meta_tags() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'All_in_One_SEO_Pack' ) ) {
		return;
	}
	$desc = is_singular() && has_excerpt() ? get_the_excerpt() : dn_mod( 'meta_description' );
	$desc = wp_strip_all_tags( $desc );
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_get_document_title() ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( home_url( add_query_arg( array() ) ) ) );
	if ( is_singular() && has_post_thumbnail() ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( get_the_post_thumbnail_url( null, 'dn-wide' ) ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	printf( '<meta name="theme-color" content="%s">' . "\n", esc_attr( dn_mod( 'brand_color' ) ) );
}
add_action( 'wp_head', 'dn_meta_tags', 2 );

/**
 * Person schema on the front page — helps your name show up in search.
 */
function dn_schema() {
	if ( ! is_front_page() ) {
		return;
	}
	$same_as = array_values( array_filter( array( dn_mod( 'linkedin_url' ), dn_mod( 'upwork_url' ), dn_mod( 'github_url' ), dn_mod( 'x_url' ) ) ) );
	$data    = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Person',
		'name'     => dn_mod( 'full_name' ),
		'jobTitle' => dn_mod( 'role' ),
		'url'      => home_url( '/' ),
		'address'  => array(
			'@type'          => 'PostalAddress',
			'addressCountry' => 'BD',
		),
		'knowsAbout' => array( 'WordPress', 'Elementor', 'WooCommerce', 'PHP', 'Web Design', 'Technical SEO', 'Speed Optimization' ),
		'sameAs'     => $same_as,
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'dn_schema', 20 );

/**
 * Excerpt tweaks.
 */
add_filter( 'excerpt_length', fn() => 24 );
add_filter( 'excerpt_more', fn() => '…' );

/**
 * Fallback menu: in-page anchors on the front page.
 */
function dn_fallback_menu() {
	$base  = is_front_page() ? '' : home_url( '/' );
	$items = array(
		'#work'     => __( 'Work', 'developernasim' ),
		'#services' => __( 'Services', 'developernasim' ),
		'#process'  => __( 'Process', 'developernasim' ),
		'#about'    => __( 'About', 'developernasim' ),
		'#faq'      => __( 'FAQ', 'developernasim' ),
	);
	$audit = function_exists( 'dn_audit_url' ) ? dn_audit_url() : '';
	echo '<ul class="nav__list">';
	foreach ( $items as $hash => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $base . $hash ), esc_html( $label ) );
	}
	if ( $audit ) {
		printf( '<li class="nav__audit"><a href="%s">%s</a></li>', esc_url( $audit ), esc_html__( 'Free audit', 'developernasim' ) );
	}
	echo '</ul>';
}
