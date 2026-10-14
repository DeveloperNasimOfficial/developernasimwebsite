<?php
/**
 * Free website audit page — /free-website-audit/
 *
 * @package DeveloperNasim
 */

get_header();

$opts   = dn_audit_options();
$status = isset( $_GET['audit'] ) ? sanitize_key( $_GET['audit'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
?>
<section class="audit-hero">
	<div class="hero__bg" aria-hidden="true"><div class="hero__grid"></div><div class="hero__glow"></div></div>

	<div class="container audit__grid">
		<div class="audit__intro">
			<p class="pill" data-reveal>
				<span class="pulse" aria-hidden="true"></span>
				<?php esc_html_e( '100% free · No strings attached', 'developernasim' ); ?>
			</p>
			<h1 class="audit__title" data-split><?php echo dn_split_words( __( 'Get a free *website audit* on video.', 'developernasim' ) ); // phpcs:ignore ?></h1>
			<p class="lead" data-reveal style="--d:.4s"><?php esc_html_e( "Send me your website. I'll review it the way your visitors do (cold, impatient, ready to leave) and record a personal Loom video covering what's holding it back and exactly how to fix it.", 'developernasim' ); ?></p>

			<ul class="audit__checks" data-reveal style="--d:.5s">
				<li><?php echo dn_icon( 'check' ); // phpcs:ignore ?><span><strong><?php esc_html_e( 'Structure & messaging', 'developernasim' ); ?></strong> <?php esc_html_e( 'Can visitors tell what you do in 5 seconds?', 'developernasim' ); ?></span></li>
				<li><?php echo dn_icon( 'check' ); // phpcs:ignore ?><span><strong><?php esc_html_e( 'Conversion flow', 'developernasim' ); ?></strong> <?php esc_html_e( 'CTAs, forms and the path to "contact" or "buy".', 'developernasim' ); ?></span></li>
				<li><?php echo dn_icon( 'check' ); // phpcs:ignore ?><span><strong><?php esc_html_e( 'Speed & Core Web Vitals', 'developernasim' ); ?></strong> <?php esc_html_e( 'Mobile load time and what is slowing it down.', 'developernasim' ); ?></span></li>
				<li><?php echo dn_icon( 'check' ); // phpcs:ignore ?><span><strong><?php esc_html_e( 'SEO & technical health', 'developernasim' ); ?></strong> <?php esc_html_e( 'Indexing, broken bits, security red flags.', 'developernasim' ); ?></span></li>
			</ul>

			<div class="audit__proof" data-reveal style="--d:.6s">
				<div class="avatar">
					<?php if ( dn_mod( 'portrait' ) ) : ?>
						<img src="<?php echo esc_url( dn_mod( 'portrait' ) ); ?>" alt="<?php echo esc_attr( dn_mod( 'full_name' ) ); ?>" width="56" height="56">
					<?php else : ?>
						<span><?php echo esc_html( mb_substr( dn_mod( 'short_name' ), 0, 1 ) ); ?></span>
					<?php endif; ?>
					<i class="avatar__status" aria-hidden="true"></i>
				</div>
				<div>
					<div class="proof-card__stars"><?php echo str_repeat( dn_icon( 'star' ), 5 ); // phpcs:ignore ?><span><?php esc_html_e( 'Top Rated Plus · Top 3% on Upwork', 'developernasim' ); ?></span></div>
					<p class="audit__proof-text"><?php echo esc_html( sprintf( __( 'Recorded personally by %1$s, not an automated report. Delivered within %2$s.', 'developernasim' ), dn_mod( 'short_name' ), dn_mod( 'audit_turnaround' ) ) ); ?></p>
				</div>
			</div>
		</div>

		<div class="audit__form-wrap" id="audit-form" data-reveal style="--d:.3s">
			<form class="audit-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-audit-form novalidate <?php echo 'sent' === $status ? 'hidden' : ''; ?>>
				<div class="audit-form__head">
					<h2><?php esc_html_e( 'Request your audit', 'developernasim' ); ?></h2>
					<p><?php esc_html_e( 'Takes about 60 seconds.', 'developernasim' ); ?></p>
				</div>

				<?php if ( 'error' === $status ) : ?>
					<p class="form-alert" role="alert"><?php esc_html_e( 'Something went wrong. Please check your details and try again.', 'developernasim' ); ?></p>
				<?php endif; ?>
				<p class="form-alert" role="alert" data-form-error hidden></p>

				<input type="hidden" name="action" value="dn_audit">
				<input type="hidden" name="dn_t" value="<?php echo esc_attr( time() ); ?>">
				<?php wp_nonce_field( 'dn_audit', 'dn_audit_nonce' ); ?>
				<div class="hp" aria-hidden="true"><label>Leave this empty <input type="text" name="company_site" tabindex="-1" autocomplete="off"></label></div>

				<div class="field-row">
					<div class="field">
						<label for="a-name"><?php esc_html_e( 'Your name', 'developernasim' ); ?> <b>*</b></label>
						<input id="a-name" name="name" type="text" autocomplete="name" required placeholder="<?php esc_attr_e( 'Jane Cooper', 'developernasim' ); ?>">
						<small class="field__error" data-error-for="name"></small>
					</div>
					<div class="field">
						<label for="a-email"><?php esc_html_e( 'Email', 'developernasim' ); ?> <b>*</b></label>
						<input id="a-email" name="email" type="email" autocomplete="email" required placeholder="jane@business.com">
						<small class="field__error" data-error-for="email"></small>
					</div>
				</div>

				<div class="field">
					<label for="a-website"><?php esc_html_e( 'Website URL', 'developernasim' ); ?> <b>*</b></label>
					<div class="field__prefix">
						<span>https://</span>
						<input id="a-website" name="website" type="text" inputmode="url" autocomplete="url" required placeholder="yourbusiness.com">
					</div>
					<small class="field__error" data-error-for="website"></small>
				</div>

				<fieldset class="field">
					<legend><?php esc_html_e( 'What do you want your website to do better?', 'developernasim' ); ?></legend>
					<div class="choice-chips">
						<?php foreach ( $opts['goals'] as $value => $label ) : ?>
							<label class="choice"><input type="checkbox" name="goals[]" value="<?php echo esc_attr( $value ); ?>"><span><?php echo esc_html( $label ); ?></span></label>
						<?php endforeach; ?>
					</div>
				</fieldset>

				<div class="field-row">
					<div class="field">
						<label for="a-business"><?php esc_html_e( 'Business type', 'developernasim' ); ?></label>
						<div class="select">
							<select id="a-business" name="business">
								<option value=""><?php esc_html_e( 'Choose one', 'developernasim' ); ?></option>
								<?php foreach ( $opts['business'] as $value => $label ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="field">
						<label for="a-builder"><?php esc_html_e( 'Built with', 'developernasim' ); ?></label>
						<div class="select">
							<select id="a-builder" name="builder">
								<option value=""><?php esc_html_e( 'Choose one', 'developernasim' ); ?></option>
								<?php foreach ( $opts['builder'] as $value => $label ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>

				<div class="field">
					<label for="a-message"><?php esc_html_e( "What's not working right now?", 'developernasim' ); ?> <span class="field__opt"><?php esc_html_e( 'Optional', 'developernasim' ); ?></span></label>
					<textarea id="a-message" name="message" rows="4" maxlength="3000" placeholder="<?php esc_attr_e( 'e.g. We get traffic but hardly any calls, and the site feels slow on mobile.', 'developernasim' ); ?>"></textarea>
				</div>

				<fieldset class="field">
					<legend><?php esc_html_e( 'When are you planning to improve it?', 'developernasim' ); ?></legend>
					<div class="choice-chips">
						<?php foreach ( $opts['timeline'] as $value => $label ) : ?>
							<label class="choice choice--radio"><input type="radio" name="timeline" value="<?php echo esc_attr( $value ); ?>"><span><?php echo esc_html( $label ); ?></span></label>
						<?php endforeach; ?>
					</div>
				</fieldset>

				<button class="btn btn--brand btn--lg audit-form__submit" type="submit" data-magnetic>
					<span data-label><?php esc_html_e( 'Get my free audit', 'developernasim' ); ?></span>
					<span class="spinner" aria-hidden="true"></span>
					<?php echo dn_icon( 'arrow-ur' ); // phpcs:ignore ?>
				</button>
				<p class="audit-form__note"><?php esc_html_e( 'No spam, no sales pressure. Your details are only used to prepare your audit.', 'developernasim' ); ?></p>
			</form>

			<div class="audit-success" data-audit-success <?php echo 'sent' === $status ? '' : 'hidden'; ?> tabindex="-1">
				<span class="audit-success__icon" aria-hidden="true">
					<svg viewBox="0 0 52 52"><circle cx="26" cy="26" r="24"/><path d="m15 27 7 7 15-16"/></svg>
				</span>
				<h2><?php esc_html_e( 'Request received!', 'developernasim' ); ?></h2>
				<p data-success-text><?php echo esc_html( sprintf( __( "Thanks! I'll review your website and send your personal Loom audit within %s. Check your inbox for a confirmation email.", 'developernasim' ), dn_mod( 'audit_turnaround' ) ) ); ?></p>
				<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/#work' ) ); ?>"><span><?php esc_html_e( 'See my work meanwhile', 'developernasim' ); ?></span><?php echo dn_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
		</div>
	</div>
</section>

<section class="section audit-steps">
	<div class="container">
		<header class="section-head section-head--center">
			<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'How it works', 'developernasim' ); ?></p>
			<h2 class="h2" data-reveal><?php echo dn_rich( __( 'Three steps to a site that *converts.*', 'developernasim' ) ); // phpcs:ignore ?></h2>
		</header>
		<ol class="audit-steps__list">
			<?php
			$steps = array(
				array( __( 'Send your URL', 'developernasim' ), __( 'Fill in the form above. It takes a minute, and you don’t need to give me any logins.', 'developernasim' ) ),
				array( __( 'I record your audit', 'developernasim' ), sprintf( __( 'A personal Loom walkthrough of your site covering structure, flow, speed and SEO, delivered within %s.', 'developernasim' ), dn_mod( 'audit_turnaround' ) ) ),
				array( __( 'You get an action plan', 'developernasim' ), __( 'Clear, prioritised fixes you can do yourself, or hand to me. Zero obligation either way.', 'developernasim' ) ),
			);
			foreach ( $steps as $i => $step ) :
				?>
				<li class="audit-step" data-reveal data-spotlight style="--d:<?php echo esc_attr( $i * 0.1 ); ?>s">
					<span class="audit-step__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $step[0] ); ?></h3>
					<p><?php echo esc_html( $step[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<?php get_template_part( 'template-parts/section', 'testimonials' ); ?>

<section class="section faq">
	<div class="container faq__grid">
		<header class="faq__head">
			<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'FAQ', 'developernasim' ); ?></p>
			<h2 class="h2" data-reveal><?php echo dn_rich( __( 'Is it *really* free?', 'developernasim' ) ); // phpcs:ignore ?></h2>
			<a class="btn btn--brand" href="#audit-form" data-reveal><span><?php esc_html_e( 'Request my audit', 'developernasim' ); ?></span><?php echo dn_icon( 'arrow' ); // phpcs:ignore ?></a>
		</header>
		<div class="accordion">
			<?php
			$faq = array(
				array( __( 'Is the audit really free?', 'developernasim' ), __( "Yes. It's how I show you how I think before we ever work together. There's no payment and no obligation.", 'developernasim' ) ),
				array( __( 'Do you need access to my WordPress admin?', 'developernasim' ), __( 'No. I review your live website from the outside, exactly like a visitor and Google see it. Just send the URL.', 'developernasim' ) ),
				array( __( "What if my site isn't built on WordPress?", 'developernasim' ), __( "Send it anyway. Structure, messaging, speed and conversion issues are the same on any platform. I'll tell you honestly whether WordPress would help.", 'developernasim' ) ),
				array( __( 'What happens after I get the video?', 'developernasim' ), __( "Whatever you want. Fix things yourself with the action plan, or reply and I'll send a fixed quote to handle it for you.", 'developernasim' ) ),
			);
			foreach ( $faq as $i => $item ) :
				?>
				<details class="accordion__item" data-reveal <?php echo 0 === $i ? 'open' : ''; ?>>
					<summary><?php echo esc_html( $item[0] ); ?><span class="accordion__icon"><?php echo dn_icon( 'plus' ); // phpcs:ignore ?></span></summary>
					<div class="accordion__body"><p><?php echo esc_html( $item[1] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
get_footer();
