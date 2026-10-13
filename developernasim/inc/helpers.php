<?php
/**
 * Template helpers.
 *
 * @package DeveloperNasim
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme mod with a default from dn_defaults().
 */
function dn_mod( $key ) {
	$defaults = dn_defaults();
	return get_theme_mod( $key, $defaults[ $key ] ?? '' );
}

/**
 * Escape text and turn *word* into an italic serif accent.
 */
function dn_rich( $text ) {
	$text = esc_html( $text );
	return preg_replace( '/\*(.+?)\*/', '<em class="accent">$1</em>', $text );
}

/**
 * Wrap each word in spans for the staggered headline reveal.
 * Keeps the *accent* markup intact.
 */
function dn_split_words( $text ) {
	$out   = array();
	$index = 0;
	$parts = preg_split( '/(\*[^*]+\*)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
	foreach ( $parts as $part ) {
		$accent = preg_match( '/^\*(.+)\*$/', $part, $m );
		$words  = preg_split( '/\s+/', $accent ? $m[1] : $part, -1, PREG_SPLIT_NO_EMPTY );
		foreach ( $words as $word ) {
			$word  = esc_html( $word );
			$inner = $accent ? '<em class="accent">' . $word . '</em>' : $word;
			$out[] = sprintf( '<span class="word"><span style="--i:%d">%s</span></span>', $index++, $inner );
		}
	}
	return implode( ' ', $out );
}

/**
 * Where the main "hire me" buttons go: booking link → email → Upwork.
 */
function dn_contact_url() {
	if ( dn_mod( 'booking_url' ) ) {
		return dn_mod( 'booking_url' );
	}
	if ( dn_mod( 'email' ) ) {
		return 'mailto:' . antispambot( dn_mod( 'email' ) );
	}
	return dn_mod( 'upwork_url' ) ?: '#contact';
}

/**
 * Social profiles that have a URL set.
 */
function dn_socials() {
	$map = array(
		'linkedin_url' => 'LinkedIn',
		'upwork_url'   => 'Upwork',
		'github_url'   => 'GitHub',
		'x_url'        => 'X / Twitter',
		'youtube_url'  => 'YouTube',
	);
	$out = array();
	foreach ( $map as $key => $label ) {
		$url = dn_mod( $key );
		if ( $url ) {
			$out[] = array(
				'label' => $label,
				'url'   => $url,
			);
		}
	}
	return $out;
}

/**
 * Inline SVG icons.
 */
function dn_icon( $name ) {
	$icons = array(
		'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'arrow-ur' => '<path d="M7 17 17 7M8 7h9v9"/>',
		'figma'    => '<path d="M9 3h3v6H9a3 3 0 0 1 0-6Zm3 0h3a3 3 0 0 1 0 6h-3V3Zm-3 6h3v6H9a3 3 0 0 1 0-6Zm3 3a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-3 3h3v3a3 3 0 1 1-3-3Z"/>',
		'bolt'     => '<path d="M13 2 4 14h7l-1 8 9-12h-7l1-8Z"/>',
		'cart'     => '<path d="M3 4h2l2.4 11.2a1 1 0 0 0 1 .8h8.8a1 1 0 0 0 1-.8L20 8H6"/><circle cx="9" cy="20" r="1.2"/><circle cx="17" cy="20" r="1.2"/>',
		'layout'   => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M9 9v11"/>',
		'shield'   => '<path d="M12 3 4 6v6c0 4.5 3.4 8.3 8 9 4.6-.7 8-4.5 8-9V6l-8-3Z"/><path d="m9 12 2 2 4-4"/>',
		'star'     => '<path d="m12 3 2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1-4.4-4.3 6.1-.9L12 3Z"/>',
		'plus'     => '<path d="M12 5v14M5 12h14"/>',
		'sun'      => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
		'moon'     => '<path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/>',
		'play'     => '<path d="M8 5v14l11-7L8 5Z"/>',
		'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'check'    => '<path d="m5 12 4 4 10-10"/>',
	);
	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}
	$fill = 'star' === $name || 'play' === $name ? 'currentColor' : 'none';
	return '<svg class="icon icon--' . esc_attr( $name ) . '" viewBox="0 0 24 24" width="24" height="24" fill="' . $fill . '" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $icons[ $name ] . '</svg>';
}

/**
 * Projects for the work grid: real "Project" posts, or concept placeholders.
 *
 * @return array[] Normalised project arrays.
 */
function dn_get_projects( $limit = 4 ) {
	$query = new WP_Query(
		array(
			'post_type'      => 'dn_project',
			'posts_per_page' => $limit,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'no_found_rows'  => true,
		)
	);

	$projects = array();
	foreach ( $query->posts as $post ) {
		$terms      = get_the_terms( $post, 'dn_project_type' );
		$projects[] = array(
			'title'   => get_the_title( $post ),
			'type'    => get_post_meta( $post->ID, '_dn_industry', true ) ?: ( $terms && ! is_wp_error( $terms ) ? $terms[0]->name : '' ),
			'year'    => get_post_meta( $post->ID, '_dn_year', true ),
			'excerpt' => get_the_excerpt( $post ),
			'url'     => get_permalink( $post ),
			'image'   => get_the_post_thumbnail( $post, 'dn-card', array( 'loading' => 'lazy' ) ),
			'mockup'  => 'service',
			'palette' => array( '#111111', dn_mod( 'brand_color' ), '#F4F4F2' ),
			'concept' => false,
		);
	}

	if ( ! $projects ) {
		foreach ( dn_demo_projects() as $demo ) {
			$projects[] = $demo + array(
				'url'     => '',
				'image'   => '',
				'concept' => true,
			);
		}
	}
	return $projects;
}
