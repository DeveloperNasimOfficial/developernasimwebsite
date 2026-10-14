<?php
/**
 * Free website audit: page, form handler, stored requests & emails.
 *
 * The page lives at /free-website-audit/ (template: page-free-website-audit.php).
 * Requests are saved under "Audit requests" in wp-admin and emailed to you.
 *
 * @package DeveloperNasim
 */

defined( 'ABSPATH' ) || exit;

define( 'DN_AUDIT_SLUG', 'free-website-audit' );

/**
 * Form options.
 */
function dn_audit_options() {
	return array(
		'business' => array(
			'service'    => __( 'Local service (HVAC, plumbing, trades)', 'developernasim' ),
			'ecommerce'  => __( 'eCommerce / WooCommerce', 'developernasim' ),
			'realestate' => __( 'Real estate', 'developernasim' ),
			'healthcare' => __( 'Healthcare / clinic', 'developernasim' ),
			'restaurant' => __( 'Restaurant / hospitality', 'developernasim' ),
			'agency'     => __( 'Agency / B2B', 'developernasim' ),
			'personal'   => __( 'Personal brand / coach', 'developernasim' ),
			'other'      => __( 'Something else', 'developernasim' ),
		),
		'goals'    => array(
			'leads'    => __( 'More leads & calls', 'developernasim' ),
			'sales'    => __( 'More online sales', 'developernasim' ),
			'speed'    => __( 'Faster loading', 'developernasim' ),
			'design'   => __( 'Modern redesign', 'developernasim' ),
			'seo'      => __( 'Better Google ranking', 'developernasim' ),
			'fix'      => __( 'Fix bugs or errors', 'developernasim' ),
		),
		'builder'  => array(
			'elementor' => 'Elementor',
			'divi'      => 'Divi',
			'gutenberg' => __( 'Gutenberg / block editor', 'developernasim' ),
			'custom'    => __( 'Custom theme', 'developernasim' ),
			'other'     => __( 'Other / not WordPress', 'developernasim' ),
			'unsure'    => __( "I'm not sure", 'developernasim' ),
		),
		'timeline' => array(
			'audit'  => __( 'Just the audit for now', 'developernasim' ),
			'asap'   => __( 'Ready to fix it ASAP', 'developernasim' ),
			'month'  => __( 'Within 1–3 months', 'developernasim' ),
			'later'  => __( 'Just exploring', 'developernasim' ),
		),
	);
}

/**
 * Public URL of the audit page.
 */
function dn_audit_url() {
	$page = get_page_by_path( DN_AUDIT_SLUG );
	return $page ? get_permalink( $page ) : home_url( '/' . DN_AUDIT_SLUG . '/' );
}

/**
 * Create the audit page if it doesn't exist (on activation, and once on first load).
 */
function dn_audit_ensure_page() {
	if ( get_page_by_path( DN_AUDIT_SLUG, OBJECT, 'page' ) ) {
		return;
	}
	wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => __( 'Free Website Audit', 'developernasim' ),
			'post_name'    => DN_AUDIT_SLUG,
			'post_excerpt' => __( 'Send me your website and get a personal Loom video audit with a clear action plan. Free, no strings attached.', 'developernasim' ),
		)
	);
}
add_action( 'after_switch_theme', 'dn_audit_ensure_page' );

function dn_audit_maybe_create_page() {
	if ( get_option( 'dn_audit_page_v1' ) ) {
		return;
	}
	dn_audit_ensure_page();
	update_option( 'dn_audit_page_v1', 1 );
}
add_action( 'admin_init', 'dn_audit_maybe_create_page' );

/**
 * Stored requests (private, admin only).
 */
function dn_audit_register_type() {
	register_post_type(
		'dn_audit',
		array(
			'labels'          => array(
				'name'          => __( 'Audit requests', 'developernasim' ),
				'singular_name' => __( 'Audit request', 'developernasim' ),
				'edit_item'     => __( 'Audit request', 'developernasim' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'menu_icon'       => 'dashicons-search',
			'menu_position'   => 4,
			'supports'        => array( 'title' ),
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
		)
	);
}
add_action( 'init', 'dn_audit_register_type' );

/**
 * Labels for stored fields.
 */
function dn_audit_fields() {
	return array(
		'name'     => __( 'Name', 'developernasim' ),
		'email'    => __( 'Email', 'developernasim' ),
		'website'  => __( 'Website', 'developernasim' ),
		'business' => __( 'Business type', 'developernasim' ),
		'goals'    => __( 'Goals', 'developernasim' ),
		'builder'  => __( 'Built with', 'developernasim' ),
		'timeline' => __( 'Timeline', 'developernasim' ),
		'message'  => __( "What's not working", 'developernasim' ),
	);
}

/**
 * Handle a submission (works with and without JavaScript).
 */
function dn_audit_handle() {
	$ajax = ! empty( $_POST['dn_ajax'] );

	$fail = function ( $errors ) use ( $ajax ) {
		if ( $ajax ) {
			wp_send_json_error( array( 'errors' => $errors ), 422 );
		}
		wp_safe_redirect( add_query_arg( 'audit', 'error', dn_audit_url() ) . '#audit-form' );
		exit;
	};

	if ( ! isset( $_POST['dn_audit_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['dn_audit_nonce'] ), 'dn_audit' ) ) {
		$fail( array( 'form' => __( 'Your session expired. Please refresh the page and try again.', 'developernasim' ) ) );
	}

	// Spam traps: hidden field must stay empty, and humans need more than 3 seconds.
	$started = isset( $_POST['dn_t'] ) ? (int) $_POST['dn_t'] : 0;
	if ( ! empty( $_POST['company_site'] ) || ( $started && time() - $started < 3 ) ) {
		if ( $ajax ) {
			wp_send_json_success();
		}
		wp_safe_redirect( add_query_arg( 'audit', 'sent', dn_audit_url() ) . '#audit-form' );
		exit;
	}

	// Rate limit: 5 requests per hour per IP.
	$ip_key = 'dn_audit_' . md5( isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '' );
	$count  = (int) get_transient( $ip_key );
	if ( $count >= 5 ) {
		$fail( array( 'form' => __( 'Too many requests. Please try again in an hour or email me directly.', 'developernasim' ) ) );
	}

	$opts    = dn_audit_options();
	$post    = wp_unslash( $_POST );
	$website = trim( sanitize_text_field( $post['website'] ?? '' ) );
	if ( $website && ! preg_match( '#^https?://#i', $website ) ) {
		$website = 'https://' . $website;
	}

	$data = array(
		'name'     => sanitize_text_field( $post['name'] ?? '' ),
		'email'    => sanitize_email( $post['email'] ?? '' ),
		'website'  => esc_url_raw( $website ),
		'business' => array_key_exists( $post['business'] ?? '', $opts['business'] ) ? $post['business'] : '',
		'goals'    => array_values( array_intersect( (array) ( $post['goals'] ?? array() ), array_keys( $opts['goals'] ) ) ),
		'builder'  => array_key_exists( $post['builder'] ?? '', $opts['builder'] ) ? $post['builder'] : '',
		'timeline' => array_key_exists( $post['timeline'] ?? '', $opts['timeline'] ) ? $post['timeline'] : '',
		'message'  => sanitize_textarea_field( mb_substr( $post['message'] ?? '', 0, 3000 ) ),
	);

	$errors = array();
	if ( mb_strlen( $data['name'] ) < 2 ) {
		$errors['name'] = __( 'Please tell me your name.', 'developernasim' );
	}
	if ( ! is_email( $data['email'] ) ) {
		$errors['email'] = __( 'Please enter a valid email address.', 'developernasim' );
	}
	if ( ! $data['website'] || ! wp_http_validate_url( $data['website'] ) || false === strpos( wp_parse_url( $data['website'], PHP_URL_HOST ) ?? '', '.' ) ) {
		$errors['website'] = __( 'Please enter your website address, e.g. yourbusiness.com', 'developernasim' );
	}
	if ( $errors ) {
		$fail( $errors );
	}

	set_transient( $ip_key, $count + 1, HOUR_IN_SECONDS );

	$host = wp_parse_url( $data['website'], PHP_URL_HOST );
	$id   = wp_insert_post(
		array(
			'post_type'   => 'dn_audit',
			'post_status' => 'private',
			'post_title'  => sprintf( '%s — %s', $host, $data['name'] ),
		)
	);
	if ( $id && ! is_wp_error( $id ) ) {
		foreach ( $data as $key => $value ) {
			update_post_meta( $id, '_dn_' . $key, $value );
		}
	}

	dn_audit_send_emails( $data, $id );

	if ( $ajax ) {
		wp_send_json_success( array( 'name' => $data['name'] ) );
	}
	wp_safe_redirect( add_query_arg( 'audit', 'sent', dn_audit_url() ) . '#audit-form' );
	exit;
}
add_action( 'admin_post_nopriv_dn_audit', 'dn_audit_handle' );
add_action( 'admin_post_dn_audit', 'dn_audit_handle' );

/**
 * Human-readable value for a stored field.
 */
function dn_audit_display( $key, $value ) {
	$opts = dn_audit_options();
	if ( 'goals' === $key ) {
		return implode( ', ', array_map( fn( $g ) => $opts['goals'][ $g ] ?? $g, (array) $value ) );
	}
	if ( isset( $opts[ $key ] ) ) {
		return $opts[ $key ][ $value ] ?? '';
	}
	return (string) $value;
}

/**
 * Notify Nasim and confirm to the client.
 */
function dn_audit_send_emails( $data, $id ) {
	$to   = dn_mod( 'audit_email' ) ?: ( dn_mod( 'email' ) ?: get_option( 'admin_email' ) );
	$host = wp_parse_url( $data['website'], PHP_URL_HOST );

	$lines = array();
	foreach ( dn_audit_fields() as $key => $label ) {
		$value = dn_audit_display( $key, $data[ $key ] );
		if ( '' !== $value ) {
			$lines[] = $label . ': ' . $value;
		}
	}
	if ( $id ) {
		$lines[] = '';
		$lines[] = 'View in WordPress: ' . admin_url( 'post.php?post=' . $id . '&action=edit' );
	}

	wp_mail(
		$to,
		sprintf( 'New audit request: %s', $host ),
		implode( "\n", $lines ),
		array( 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>' )
	);

	$body = sprintf(
		"Hi %1\$s,\n\nThanks for requesting a free website audit for %2\$s.\n\nI'll go through your site the way a visitor does and record a personal Loom video covering what's holding it back and how to fix it. Expect it in your inbox within %3\$s.\n\nIf there's anything else I should know, just reply to this email.\n\nTalk soon,\n%4\$s\n%5\$s",
		$data['name'],
		$host,
		dn_mod( 'audit_turnaround' ),
		dn_mod( 'short_name' ),
		home_url( '/' )
	);
	wp_mail(
		$data['email'],
		sprintf( 'Your free website audit for %s', $host ),
		$body,
		array( 'Reply-To: ' . dn_mod( 'full_name' ) . ' <' . $to . '>' )
	);
}

/**
 * Admin: list columns.
 */
function dn_audit_columns( $cols ) {
	return array(
		'cb'          => $cols['cb'],
		'title'       => __( 'Request', 'developernasim' ),
		'dn_email'    => __( 'Email', 'developernasim' ),
		'dn_goals'    => __( 'Goals', 'developernasim' ),
		'dn_timeline' => __( 'Timeline', 'developernasim' ),
		'date'        => $cols['date'],
	);
}
add_filter( 'manage_dn_audit_posts_columns', 'dn_audit_columns' );

function dn_audit_column( $col, $id ) {
	$key = substr( $col, 3 );
	if ( 'email' === $key ) {
		$email = get_post_meta( $id, '_dn_email', true );
		printf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $email ) );
	} elseif ( in_array( $key, array( 'goals', 'timeline' ), true ) ) {
		echo esc_html( dn_audit_display( $key, get_post_meta( $id, '_dn_' . $key, true ) ) );
	}
}
add_action( 'manage_dn_audit_posts_custom_column', 'dn_audit_column', 10, 2 );

/**
 * Admin: read-only details box.
 */
function dn_audit_meta_box() {
	add_meta_box(
		'dn_audit_details',
		__( 'Request details', 'developernasim' ),
		function ( $post ) {
			echo '<table class="form-table" role="presentation"><tbody>';
			foreach ( dn_audit_fields() as $key => $label ) {
				$value = dn_audit_display( $key, get_post_meta( $post->ID, '_dn_' . $key, true ) );
				if ( 'website' === $key ) {
					$value = sprintf( '<a href="%1$s" target="_blank" rel="noopener">%1$s</a>', esc_url( $value ) );
				} elseif ( 'email' === $key ) {
					$value = sprintf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $value ) );
				} else {
					$value = nl2br( esc_html( $value ) );
				}
				printf( '<tr><th scope="row">%s</th><td>%s</td></tr>', esc_html( $label ), $value ?: '—' ); // phpcs:ignore
			}
			echo '</tbody></table>';
		},
		'dn_audit',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_dn_audit', 'dn_audit_meta_box' );

/**
 * Admin: count new requests in the menu.
 */
function dn_audit_menu_badge() {
	global $menu;
	$count = (int) ( new WP_Query(
		array(
			'post_type'      => 'dn_audit',
			'post_status'    => 'private',
			'date_query'     => array( array( 'after' => '7 days ago' ) ),
			'fields'         => 'ids',
			'posts_per_page' => 1,
		)
	) )->found_posts;
	if ( ! $count || ! is_array( $menu ) ) {
		return;
	}
	foreach ( $menu as $i => $item ) {
		if ( 'edit.php?post_type=dn_audit' === $item[2] ) {
			$menu[ $i ][0] .= ' <span class="awaiting-mod">' . $count . '</span>'; // phpcs:ignore
		}
	}
}
add_action( 'admin_menu', 'dn_audit_menu_badge', 99 );
