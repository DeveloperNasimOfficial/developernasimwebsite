<?php
/**
 * Default content — Nasim's brand, story and copy.
 * Every Customizer value falls back to these. Edit here or in
 * Appearance → Customize → Developer Nasim.
 *
 * @package DeveloperNasim
 */

defined( 'ABSPATH' ) || exit;

/**
 * Customizer defaults.
 */
function dn_defaults() {
	return array(
		// Brand.
		'brand_color'      => '#3B5BFF',
		'brand_ink'        => '#FFFFFF',
		'full_name'        => 'MD Nasim',
		'short_name'       => 'Nasim',
		'role'             => 'WordPress Developer & Web Designer',
		'location'         => 'Dhaka, Bangladesh',
		'timezone'         => 'Asia/Dhaka',
		'portrait'         => '',
		'meta_description' => 'Nasim is a Top Rated Plus WordPress & Elementor developer (Top 3% on Upwork) who builds fast, conversion-focused websites for service businesses, eCommerce brands and agencies.',

		// Hero.
		'availability'     => 'Available for new projects',
		'hero_title'       => 'I build WordPress websites that turn visitors into *clients.*',
		'hero_text'        => "I'm Nasim, a Top Rated Plus WordPress & Elementor developer. Most sites look fine and still don't convert, and the cause is rarely the design. I fix the structure, the flow and the speed so visitors understand you in 5 seconds and take action.",
		'hero_cta_label'   => 'Get a free Loom audit',
		'hero_cta2_label'  => 'See selected work',

		// Story.
		'story_statement'  => "Websites rarely fail because of design. They fail because of structure. Visitors land, and within five seconds they don't know what to do next. I look at your site the way a visitor does: cold, impatient, ready to leave. Then I rebuild it so they stay, understand and act.",

		// Stats.
		'stat_1_value'     => '3',
		'stat_1_prefix'    => 'Top ',
		'stat_1_suffix'    => '%',
		'stat_1_label'     => 'of WordPress talent on Upwork',
		'stat_2_value'     => '35',
		'stat_2_prefix'    => '',
		'stat_2_suffix'    => '+',
		'stat_2_label'     => 'Projects shipped for clients worldwide',
		'stat_3_value'     => '20',
		'stat_3_prefix'    => '$',
		'stat_3_suffix'    => 'K+',
		'stat_3_label'     => 'Earned on Upwork, Top Rated Plus',
		'stat_4_value'     => '9',
		'stat_4_prefix'    => '',
		'stat_4_suffix'    => '',
		'stat_4_label'     => 'Companies & agencies worked with',

		// Offer / CTA.
		'offer_title'      => 'Not sure what is holding your site back?',
		'offer_text'       => "Send me your URL. I'll review your whole WordPress site and record a personal Loom video covering what's going wrong, what to improve and the best way to fix it. No generic advice, just an action plan for your actual website.",
		'cta_title'        => "Let's build something that *works.*",
		'cta_text'         => 'Taking on a limited number of projects each month. Tell me about yours.',

		// Contact & socials.
		'email'            => '',
		'booking_url'      => '',
		'upwork_url'       => 'https://www.upwork.com/freelancers/~01bf8d0b2c962776a5',
		'linkedin_url'     => '',
		'github_url'       => '',
		'x_url'            => '',
		'youtube_url'      => 'https://youtu.be/33tk2ZLAB0s',
		'footer_note'      => 'Structure first. Design second. Results always.',
	);
}

/**
 * Tool & skill marquee.
 */
function dn_marquee_items() {
	return array( 'WordPress', 'Elementor Pro', 'WooCommerce', 'PHP', 'Figma to WordPress', 'Technical SEO', 'Core Web Vitals', 'Custom Themes', 'ACF', 'JavaScript', 'Landing Pages', 'Malware Removal' );
}

/**
 * Industries served.
 */
function dn_industries() {
	return array( 'HVAC', 'Plumbing', 'Real Estate', 'Healthcare', 'Restaurants', 'eCommerce', 'Agencies', 'Small Business', 'Personal Brands' );
}

/**
 * Services (bento grid).
 */
function dn_services() {
	return array(
		array(
			'icon'  => 'figma',
			'title' => 'Figma to WordPress',
			'text'  => 'Pixel-accurate builds from your Figma file: responsive, accessible, and easy for your team to edit afterwards.',
			'tags'  => array( 'Custom theme', 'Elementor Pro', 'ACF' ),
			'size'  => 'lg',
		),
		array(
			'icon'  => 'bolt',
			'title' => 'Speed & Technical SEO',
			'text'  => 'Core Web Vitals, caching, image pipelines and clean markup that search engines can read.',
			'tags'  => array( 'CWV', 'Schema' ),
			'size'  => 'sm',
		),
		array(
			'icon'  => 'cart',
			'title' => 'WooCommerce Stores',
			'text'  => 'Product pages, checkout flows and integrations that make buying feel effortless.',
			'tags'  => array( 'Checkout', 'Payments' ),
			'size'  => 'sm',
		),
		array(
			'icon'  => 'layout',
			'title' => 'Redesign for Conversions',
			'text'  => 'Same brand, better structure. Clear messaging, a strong visual hierarchy and CTAs people actually click.',
			'tags'  => array( 'UX audit', 'Landing pages' ),
			'size'  => 'md',
		),
		array(
			'icon'  => 'shield',
			'title' => 'Care, Fixes & Security',
			'text'  => 'Maintenance, bug fixing, updates, backups and malware removal, so your site keeps working.',
			'tags'  => array( 'Maintenance', 'Malware' ),
			'size'  => 'md',
		),
	);
}

/**
 * Process steps.
 */
function dn_process() {
	return array(
		array(
			'title' => 'Structure first',
			'text'  => 'Audit, goals and sitemap. I map what visitors need to see, in what order, before a single pixel moves.',
			'meta'  => 'Week 1',
		),
		array(
			'title' => 'Design second',
			'text'  => 'Wireframes become a polished, on-brand design system: typography, components and responsive layouts.',
			'meta'  => 'Week 1–2',
		),
		array(
			'title' => 'Build & optimise',
			'text'  => 'Hand-built in WordPress with a clean backend you can manage, tuned for speed, SEO and security.',
			'meta'  => 'Week 2–4',
		),
		array(
			'title' => 'Results always',
			'text'  => 'Launch, train your team on a Loom walkthrough, then measure and iterate on what converts.',
			'meta'  => 'Ongoing',
		),
	);
}

/**
 * Testimonials (from Upwork client feedback).
 */
function dn_testimonials() {
	return array(
		array(
			'quote'  => 'Nasim did an outstanding job on my WordPress website design project. He quickly implemented all the requests. Communication was excellent throughout the project, and he was responsive, professional, and easy to work with. I will definitely hire him again.',
			'name'   => 'Upwork Client',
			'role'   => 'WordPress website design',
			'rating' => 5,
		),
		array(
			'quote'  => 'Nasim has a lot of passion and commitment to his clients and their needs. He was able to complete my work with the highest quality and also inform me on how I can improve my WordPress website design at the same time.',
			'name'   => 'Upwork Client',
			'role'   => 'WordPress website project',
			'rating' => 5,
		),
	);
}

/**
 * Experience (from Upwork employment history).
 */
function dn_experience() {
	return array(
		array( 'company' => 'Devixus', 'role' => 'WordPress Developer · Elementor & WooCommerce' ),
		array( 'company' => 'RealTech Solution', 'role' => 'WordPress PHP Developer · HTML, CSS & JS' ),
		array( 'company' => 'Code Hub', 'role' => 'WordPress Web Designer · Elementor Pro' ),
		array( 'company' => 'DaySmart Software Solution', 'role' => 'Full-Stack Web Developer · WordPress' ),
		array( 'company' => 'Easy Tech Solution', 'role' => 'Senior WordPress Developer' ),
		array( 'company' => 'VEUTI TECH', 'role' => 'WordPress & Web Expert' ),
		array( 'company' => 'CodemanBD', 'role' => 'Sr. WordPress Developer' ),
		array( 'company' => 'Aginex Co Ltd', 'role' => 'WordPress Developer · WooCommerce Expert' ),
		array( 'company' => 'CabinetCorp', 'role' => 'Lead WordPress Website Developer' ),
	);
}

/**
 * FAQ.
 */
function dn_faq() {
	return array(
		array(
			'q' => 'How much does a website cost?',
			'a' => 'It depends on scope: number of pages, custom functionality and whether you have a design. After a short call or your free Loom audit you get a fixed quote with clear deliverables, so there are no surprises.',
		),
		array(
			'q' => 'How long does a project take?',
			'a' => 'Most marketing sites launch in 2–4 weeks. Larger WooCommerce or custom builds take 4–8 weeks. You get a timeline with milestones before we start.',
		),
		array(
			'q' => 'Will I be able to edit the site myself?',
			'a' => 'Yes. Every site comes with an easy-to-manage backend and a recorded Loom walkthrough, so you can update text, images and pages without calling a developer.',
		),
		array(
			'q' => 'Do you work with Elementor or custom code?',
			'a' => 'Both. I use Elementor Pro when your team wants visual editing, and custom themes when performance and flexibility matter most. I will recommend whichever fits your goals.',
		),
		array(
			'q' => 'Can you fix or speed up my existing website?',
			'a' => 'Absolutely. Bug fixing, speed optimisation, malware removal and redesigns of existing WordPress sites make up a big part of my work.',
		),
		array(
			'q' => 'What time zone do you work in?',
			'a' => 'I am based in Dhaka (UTC+6) and overlap with both European and US mornings. Communication stays fast and clear throughout the project.',
		),
	);
}

/**
 * Concept projects shown until real Projects are published.
 * Labelled "Concept" on the site so nothing is presented as client work.
 */
function dn_demo_projects() {
	return array(
		array(
			'title'    => 'Northwind Air',
			'type'     => 'HVAC · Lead generation',
			'year'     => '2026',
			'excerpt'  => 'A service-area site built around one job: booking a technician in under 60 seconds.',
			'mockup'   => 'service',
			'palette'  => array( '#0E2A47', '#FF7A1A', '#F4F1EA' ),
		),
		array(
			'title'    => 'Maison Verde',
			'type'     => 'WooCommerce · Lifestyle',
			'year'     => '2026',
			'excerpt'  => 'An editorial storefront with a faster product page and a one-page checkout.',
			'mockup'   => 'shop',
			'palette'  => array( '#1F3B2D', '#E9D8B4', '#FAF7F0' ),
		),
		array(
			'title'    => 'Keystone Realty',
			'type'     => 'Real estate · Listings',
			'year'     => '2025',
			'excerpt'  => 'Property search, agent profiles and lead capture on a clean, fast WordPress backend.',
			'mockup'   => 'listings',
			'palette'  => array( '#111111', '#C9A46A', '#F2F2F0' ),
		),
		array(
			'title'    => 'Pulse Clinic',
			'type'     => 'Healthcare · Booking',
			'year'     => '2025',
			'excerpt'  => 'A calm, accessible clinic site that answers patient questions before they call.',
			'mockup'   => 'saas',
			'palette'  => array( '#0B3B5C', '#5EE1C1', '#F3FAF8' ),
		),
	);
}
