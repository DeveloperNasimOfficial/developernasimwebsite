<?php
/**
 * Projects (case studies) and Testimonials.
 *
 * @package DeveloperNasim
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register post types & taxonomy.
 */
function dn_register_types() {
	register_post_type(
		'dn_project',
		array(
			'labels'       => array(
				'name'          => __( 'Projects', 'developernasim' ),
				'singular_name' => __( 'Project', 'developernasim' ),
				'add_new_item'  => __( 'Add new project', 'developernasim' ),
				'edit_item'     => __( 'Edit project', 'developernasim' ),
			),
			'public'       => true,
			'has_archive'  => 'work',
			'rewrite'      => array( 'slug' => 'work' ),
			'menu_icon'    => 'dashicons-portfolio',
			'menu_position' => 5,
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		)
	);

	register_taxonomy(
		'dn_project_type',
		'dn_project',
		array(
			'labels'            => array(
				'name'          => __( 'Project types', 'developernasim' ),
				'singular_name' => __( 'Project type', 'developernasim' ),
			),
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'work-type' ),
		)
	);

	register_post_type(
		'dn_testimonial',
		array(
			'labels'        => array(
				'name'          => __( 'Testimonials', 'developernasim' ),
				'singular_name' => __( 'Testimonial', 'developernasim' ),
				'add_new_item'  => __( 'Add testimonial (title = client name)', 'developernasim' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'menu_icon'     => 'dashicons-format-quote',
			'menu_position' => 6,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'dn_register_types' );

/**
 * Flush rewrites when the theme is switched on so /work/ works immediately.
 */
function dn_flush_rewrites() {
	dn_register_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'dn_flush_rewrites' );

/**
 * Meta fields.
 */
function dn_meta_fields() {
	return array(
		'dn_project'     => array(
			'_dn_industry' => __( 'Industry / category label (e.g. "HVAC · Lead generation")', 'developernasim' ),
			'_dn_client'   => __( 'Client', 'developernasim' ),
			'_dn_year'     => __( 'Year', 'developernasim' ),
			'_dn_services' => __( 'Services (comma separated)', 'developernasim' ),
			'_dn_live_url' => __( 'Live website URL', 'developernasim' ),
			'_dn_result'   => __( 'Headline result (e.g. "2.4s → 0.9s load time")', 'developernasim' ),
		),
		'dn_testimonial' => array(
			'_dn_role'   => __( 'Role / company', 'developernasim' ),
			'_dn_rating' => __( 'Rating (1–5)', 'developernasim' ),
		),
	);
}

/**
 * Meta boxes.
 */
function dn_add_meta_boxes() {
	foreach ( dn_meta_fields() as $type => $fields ) {
		add_meta_box( 'dn_details', __( 'Details', 'developernasim' ), 'dn_render_meta_box', $type, 'side', 'high', $fields );
	}
}
add_action( 'add_meta_boxes', 'dn_add_meta_boxes' );

/**
 * Render a meta box.
 */
function dn_render_meta_box( $post, $box ) {
	wp_nonce_field( 'dn_meta', 'dn_meta_nonce' );
	foreach ( $box['args'] as $key => $label ) {
		printf(
			'<p><label for="%1$s"><strong>%2$s</strong></label><br><input type="text" class="widefat" id="%1$s" name="%1$s" value="%3$s"></p>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( get_post_meta( $post->ID, $key, true ) )
		);
	}
}

/**
 * Save meta.
 */
function dn_save_meta( $post_id, $post ) {
	if ( ! isset( $_POST['dn_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['dn_meta_nonce'] ), 'dn_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$fields = dn_meta_fields()[ $post->post_type ] ?? array();
	foreach ( array_keys( $fields ) as $key ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$value = wp_unslash( $_POST[ $key ] );
		$value = '_dn_live_url' === $key ? esc_url_raw( $value ) : sanitize_text_field( $value );
		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post', 'dn_save_meta', 10, 2 );

/**
 * Testimonials: published posts, or the Upwork defaults.
 */
function dn_get_testimonials() {
	$posts = get_posts(
		array(
			'post_type'      => 'dn_testimonial',
			'posts_per_page' => 12,
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
		)
	);
	if ( ! $posts ) {
		return dn_testimonials();
	}
	return array_map(
		function ( $p ) {
			return array(
				'quote'  => wp_strip_all_tags( $p->post_content ),
				'name'   => get_the_title( $p ),
				'role'   => get_post_meta( $p->ID, '_dn_role', true ),
				'rating' => (int) ( get_post_meta( $p->ID, '_dn_rating', true ) ?: 5 ),
				'avatar' => get_the_post_thumbnail_url( $p, 'thumbnail' ),
			);
		},
		$posts
	);
}
