<?php
/**
 * Services bento grid.
 *
 * @package DeveloperNasim
 */

?>
<section class="section services" id="services">
	<div class="container">
		<header class="section-head section-head--center">
			<p class="eyebrow" data-reveal><span class="dot"></span><?php esc_html_e( 'Services', 'developernasim' ); ?></p>
			<h2 class="h2" data-reveal><?php echo dn_rich( __( 'Everything your website needs, *in one place.*', 'developernasim' ) ); // phpcs:ignore ?></h2>
		</header>

		<div class="bento">
			<?php foreach ( dn_services() as $i => $service ) : ?>
				<article class="bento__item bento__item--<?php echo esc_attr( $service['size'] ); ?>" data-reveal data-spotlight style="--d:<?php echo esc_attr( $i * 0.06 ); ?>s">
					<span class="bento__icon"><?php echo dn_icon( $service['icon'] ); // phpcs:ignore ?></span>
					<h3 class="bento__title"><?php echo esc_html( $service['title'] ); ?></h3>
					<p class="bento__text"><?php echo esc_html( $service['text'] ); ?></p>
					<ul class="bento__tags">
						<?php foreach ( $service['tags'] as $tag ) : ?>
							<li class="tag"><?php echo esc_html( $tag ); ?></li>
						<?php endforeach; ?>
					</ul>
					<?php if ( 'lg' === $service['size'] ) : ?>
						<div class="bento__visual" aria-hidden="true">
							<div class="code-window">
								<div class="code-window__bar"><i></i><i></i><i></i><span>functions.php</span></div>
<pre><code><span class="c">// Structure first. Design second.</span>
<span class="k">add_action</span>( <span class="s">'init'</span>, <span class="k">function</span> () {
  <span class="k">register_post_type</span>( <span class="s">'results'</span>, [
    <span class="s">'public'</span>  =&gt; <span class="k">true</span>,
    <span class="s">'convert'</span> =&gt; <span class="k">true</span>,
  ] );
} );</code></pre>
							</div>
						</div>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>

			<article class="bento__item bento__item--industries" data-reveal data-spotlight>
				<h3 class="bento__title"><?php esc_html_e( 'Industries I help', 'developernasim' ); ?></h3>
				<ul class="chips">
					<?php foreach ( dn_industries() as $industry ) : ?>
						<li><?php echo esc_html( $industry ); ?></li>
					<?php endforeach; ?>
				</ul>
			</article>
		</div>
	</div>
</section>
