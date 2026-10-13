<?php
/**
 * Customizer: Appearance → Customize → Developer Nasim.
 *
 * @package DeveloperNasim
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register panels, sections & controls.
 */
function dn_customize_register( $wp_customize ) {
	$d = dn_defaults();

	$wp_customize->add_panel(
		'dn_panel',
		array(
			'title'    => __( 'Developer Nasim', 'developernasim' ),
			'priority' => 20,
		)
	);

	$sections = array(
		'dn_brand'   => array(
			'title'  => __( 'Brand & identity', 'developernasim' ),
			'fields' => array(
				'brand_color'      => array( 'Brand color', 'color' ),
				'brand_ink'        => array( 'Text color on brand (buttons)', 'color' ),
				'full_name'        => array( 'Full name', 'text' ),
				'short_name'       => array( 'Short name (logo & footer)', 'text' ),
				'role'             => array( 'Role / title', 'text' ),
				'location'         => array( 'Location', 'text' ),
				'timezone'         => array( 'Time zone (IANA, e.g. Asia/Dhaka)', 'text' ),
				'portrait'         => array( 'Portrait photo', 'image' ),
				'meta_description' => array( 'SEO description', 'textarea' ),
			),
		),
		'dn_hero'    => array(
			'title'  => __( 'Hero', 'developernasim' ),
			'fields' => array(
				'availability'    => array( 'Availability badge (empty = hide)', 'text' ),
				'hero_title'      => array( 'Headline — wrap a word in *stars* for the italic accent', 'textarea' ),
				'hero_text'       => array( 'Intro paragraph', 'textarea' ),
				'hero_cta_label'  => array( 'Primary button', 'text' ),
				'hero_cta2_label' => array( 'Secondary button', 'text' ),
			),
		),
		'dn_story'   => array(
			'title'  => __( 'Story & stats', 'developernasim' ),
			'fields' => array(
				'story_statement' => array( 'Scroll-highlight statement', 'textarea' ),
			),
		),
		'dn_cta'     => array(
			'title'  => __( 'Offer & call to action', 'developernasim' ),
			'fields' => array(
				'offer_title' => array( 'Free audit title', 'text' ),
				'offer_text'  => array( 'Free audit text', 'textarea' ),
				'cta_title'   => array( 'Final CTA title (*accent*)', 'text' ),
				'cta_text'    => array( 'Final CTA text', 'textarea' ),
				'footer_note' => array( 'Footer tagline', 'text' ),
			),
		),
		'dn_contact' => array(
			'title'  => __( 'Contact & socials', 'developernasim' ),
			'fields' => array(
				'email'        => array( 'Email (shown in footer & CTA)', 'email' ),
				'booking_url'  => array( 'Booking link (Calendly / Cal.com) — used by main buttons', 'url' ),
				'linkedin_url' => array( 'LinkedIn URL', 'url' ),
				'upwork_url'   => array( 'Upwork URL', 'url' ),
				'github_url'   => array( 'GitHub URL', 'url' ),
				'x_url'        => array( 'X / Twitter URL', 'url' ),
				'youtube_url'  => array( 'YouTube / intro video URL', 'url' ),
			),
		),
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		$sections['dn_story']['fields'][ "stat_{$i}_prefix" ] = array( "Stat {$i} prefix", 'text' );
		$sections['dn_story']['fields'][ "stat_{$i}_value" ]  = array( "Stat {$i} number", 'text' );
		$sections['dn_story']['fields'][ "stat_{$i}_suffix" ] = array( "Stat {$i} suffix", 'text' );
		$sections['dn_story']['fields'][ "stat_{$i}_label" ]  = array( "Stat {$i} label", 'text' );
	}

	$priority = 10;
	foreach ( $sections as $section_id => $section ) {
		$wp_customize->add_section(
			$section_id,
			array(
				'title'    => $section['title'],
				'panel'    => 'dn_panel',
				'priority' => $priority++,
			)
		);

		foreach ( $section['fields'] as $key => $field ) {
			list( $label, $type ) = $field;
			$sanitize             = array(
				'color'    => 'sanitize_hex_color',
				'url'      => 'esc_url_raw',
				'email'    => 'sanitize_email',
				'image'    => 'esc_url_raw',
				'textarea' => 'sanitize_textarea_field',
			)[ $type ] ?? 'sanitize_text_field';

			$wp_customize->add_setting(
				$key,
				array(
					'default'           => $d[ $key ] ?? '',
					'sanitize_callback' => $sanitize,
					'transport'         => 'refresh',
				)
			);

			if ( 'color' === $type ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array( 'label' => $label, 'section' => $section_id ) ) );
			} elseif ( 'image' === $type ) {
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array( 'label' => $label, 'section' => $section_id ) ) );
			} else {
				$wp_customize->add_control(
					$key,
					array(
						'label'   => $label,
						'section' => $section_id,
						'type'    => $type,
					)
				);
			}
		}
	}
}
add_action( 'customize_register', 'dn_customize_register' );
