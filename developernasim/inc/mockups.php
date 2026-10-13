<?php
/**
 * Generated SVG website mockups for project cards that have no
 * featured image yet. Swap them out by adding a featured image.
 *
 * @package DeveloperNasim
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render a browser-window mockup.
 *
 * @param string   $kind    service|shop|listings|saas.
 * @param string[] $palette [dark, accent, light].
 * @param string   $label   Brand name shown in the mock nav.
 */
function dn_mockup( $kind, $palette, $label = '' ) {
	list( $d, $a, $l ) = array_map( 'esc_attr', $palette );
	$label             = esc_html( $label );
	$id                = 'm' . wp_rand( 1000, 9999 );

	ob_start();
	?>
	<svg class="mockup" viewBox="0 0 1200 900" role="img" aria-label="<?php echo esc_attr( sprintf( __( '%s website mockup', 'developernasim' ), $label ) ); ?>" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
		<defs>
			<linearGradient id="<?php echo $id; ?>bg" x1="0" y1="0" x2="1" y2="1">
				<stop offset="0" stop-color="<?php echo $a; ?>" stop-opacity=".9"/>
				<stop offset="1" stop-color="<?php echo $d; ?>"/>
			</linearGradient>
			<filter id="<?php echo $id; ?>sh" x="-10%" y="-10%" width="120%" height="130%">
				<feDropShadow dx="0" dy="30" stdDeviation="30" flood-color="#000" flood-opacity=".35"/>
			</filter>
			<clipPath id="<?php echo $id; ?>clip"><rect x="120" y="130" width="960" height="900" rx="18"/></clipPath>
		</defs>
		<rect width="1200" height="900" fill="url(#<?php echo $id; ?>bg)"/>
		<circle cx="1050" cy="120" r="260" fill="<?php echo $l; ?>" opacity=".08"/>
		<circle cx="120" cy="860" r="320" fill="<?php echo $a; ?>" opacity=".18"/>

		<g class="mockup__window" filter="url(#<?php echo $id; ?>sh)">
			<rect x="120" y="130" width="960" height="900" rx="18" fill="<?php echo $l; ?>"/>
			<g clip-path="url(#<?php echo $id; ?>clip)">
				<rect x="120" y="130" width="960" height="44" fill="<?php echo $d; ?>" opacity=".06"/>
				<circle cx="148" cy="152" r="6" fill="#FF5F57"/><circle cx="168" cy="152" r="6" fill="#FEBC2E"/><circle cx="188" cy="152" r="6" fill="#28C840"/>
				<rect x="460" y="142" width="280" height="20" rx="10" fill="<?php echo $d; ?>" opacity=".08"/>

				<!-- nav -->
				<text x="168" y="226" font-family="Inter Tight, Arial, sans-serif" font-size="22" font-weight="700" fill="<?php echo $d; ?>"><?php echo $label; ?></text>
				<rect x="640" y="212" width="54" height="10" rx="5" fill="<?php echo $d; ?>" opacity=".3"/>
				<rect x="712" y="212" width="54" height="10" rx="5" fill="<?php echo $d; ?>" opacity=".3"/>
				<rect x="784" y="212" width="54" height="10" rx="5" fill="<?php echo $d; ?>" opacity=".3"/>
				<rect x="900" y="200" width="132" height="36" rx="18" fill="<?php echo $a; ?>"/>

				<?php if ( 'service' === $kind ) : ?>
					<rect x="168" y="300" width="460" height="34" rx="6" fill="<?php echo $d; ?>"/>
					<rect x="168" y="348" width="400" height="34" rx="6" fill="<?php echo $d; ?>"/>
					<rect x="168" y="396" width="260" height="34" rx="6" fill="<?php echo $a; ?>"/>
					<rect x="168" y="460" width="420" height="12" rx="6" fill="<?php echo $d; ?>" opacity=".25"/>
					<rect x="168" y="484" width="360" height="12" rx="6" fill="<?php echo $d; ?>" opacity=".25"/>
					<rect x="168" y="530" width="180" height="52" rx="26" fill="<?php echo $d; ?>"/>
					<rect x="364" y="530" width="160" height="52" rx="26" fill="none" stroke="<?php echo $d; ?>" stroke-opacity=".3" stroke-width="2"/>
					<rect x="690" y="290" width="342" height="340" rx="16" fill="#fff" stroke="<?php echo $d; ?>" stroke-opacity=".08"/>
					<rect x="718" y="320" width="180" height="16" rx="8" fill="<?php echo $d; ?>"/>
					<?php for ( $i = 0; $i < 3; $i++ ) : ?>
						<rect x="718" y="<?php echo 362 + $i * 62; ?>" width="286" height="44" rx="10" fill="<?php echo $d; ?>" opacity=".06"/>
					<?php endfor; ?>
					<rect x="718" y="560" width="286" height="46" rx="10" fill="<?php echo $a; ?>"/>
					<?php for ( $i = 0; $i < 3; $i++ ) : ?>
						<rect x="<?php echo 168 + $i * 296; ?>" y="680" width="272" height="160" rx="14" fill="<?php echo $d; ?>" opacity="<?php echo 0 === $i ? '.9' : '.06'; ?>"/>
						<circle cx="<?php echo 210 + $i * 296; ?>" cy="722" r="18" fill="<?php echo $a; ?>"/>
					<?php endfor; ?>

				<?php elseif ( 'shop' === $kind ) : ?>
					<rect x="168" y="290" width="864" height="230" rx="16" fill="<?php echo $d; ?>"/>
					<rect x="208" y="340" width="320" height="30" rx="6" fill="<?php echo $l; ?>"/>
					<rect x="208" y="384" width="240" height="30" rx="6" fill="<?php echo $a; ?>"/>
					<rect x="208" y="446" width="140" height="44" rx="22" fill="<?php echo $l; ?>"/>
					<circle cx="840" cy="405" r="120" fill="<?php echo $a; ?>" opacity=".85"/>
					<rect x="790" y="330" width="100" height="150" rx="40" fill="<?php echo $l; ?>" opacity=".9"/>
					<?php for ( $i = 0; $i < 4; $i++ ) : ?>
						<rect x="<?php echo 168 + $i * 222; ?>" y="550" width="198" height="220" rx="14" fill="<?php echo $a; ?>" opacity="<?php echo 0.25 + $i * 0.12; ?>"/>
						<rect x="<?php echo 168 + $i * 222; ?>" y="786" width="140" height="12" rx="6" fill="<?php echo $d; ?>"/>
						<rect x="<?php echo 168 + $i * 222; ?>" y="808" width="70" height="12" rx="6" fill="<?php echo $d; ?>" opacity=".4"/>
					<?php endfor; ?>

				<?php elseif ( 'listings' === $kind ) : ?>
					<rect x="168" y="290" width="864" height="80" rx="40" fill="#fff" stroke="<?php echo $d; ?>" stroke-opacity=".1"/>
					<rect x="208" y="322" width="180" height="16" rx="8" fill="<?php echo $d; ?>" opacity=".5"/>
					<rect x="430" y="322" width="140" height="16" rx="8" fill="<?php echo $d; ?>" opacity=".3"/>
					<rect x="872" y="304" width="140" height="52" rx="26" fill="<?php echo $d; ?>"/>
					<rect x="168" y="400" width="420" height="440" rx="16" fill="<?php echo $d; ?>" opacity=".07"/>
					<path d="M190 520 C 300 460, 380 600, 560 500 M200 700 C 320 640, 420 760, 570 680" stroke="<?php echo $d; ?>" stroke-opacity=".15" stroke-width="10" fill="none"/>
					<?php foreach ( array( array( 280, 480 ), array( 450, 560 ), array( 330, 690 ) ) as $p ) : ?>
						<rect x="<?php echo $p[0] - 38; ?>" y="<?php echo $p[1] - 16; ?>" width="76" height="32" rx="16" fill="<?php echo $d; ?>"/>
						<rect x="<?php echo $p[0] - 22; ?>" y="<?php echo $p[1] - 4; ?>" width="44" height="8" rx="4" fill="<?php echo $a; ?>"/>
					<?php endforeach; ?>
					<?php for ( $i = 0; $i < 2; $i++ ) : ?>
						<rect x="612" y="<?php echo 400 + $i * 228; ?>" width="420" height="212" rx="16" fill="#fff" stroke="<?php echo $d; ?>" stroke-opacity=".08"/>
						<rect x="628" y="<?php echo 416 + $i * 228; ?>" width="180" height="180" rx="10" fill="<?php echo $a; ?>" opacity="<?php echo 0.5 + $i * 0.3; ?>"/>
						<rect x="830" y="<?php echo 430 + $i * 228; ?>" width="150" height="16" rx="8" fill="<?php echo $d; ?>"/>
						<rect x="830" y="<?php echo 460 + $i * 228; ?>" width="110" height="12" rx="6" fill="<?php echo $d; ?>" opacity=".35"/>
						<rect x="830" y="<?php echo 548 + $i * 228; ?>" width="90" height="22" rx="11" fill="<?php echo $a; ?>"/>
					<?php endfor; ?>

				<?php else : ?>
					<rect x="168" y="290" width="400" height="30" rx="6" fill="<?php echo $d; ?>"/>
					<rect x="168" y="334" width="300" height="30" rx="6" fill="<?php echo $d; ?>"/>
					<rect x="168" y="394" width="360" height="12" rx="6" fill="<?php echo $d; ?>" opacity=".25"/>
					<rect x="168" y="418" width="300" height="12" rx="6" fill="<?php echo $d; ?>" opacity=".25"/>
					<rect x="168" y="460" width="170" height="50" rx="25" fill="<?php echo $a; ?>"/>
					<rect x="640" y="280" width="392" height="560" rx="18" fill="#fff" stroke="<?php echo $d; ?>" stroke-opacity=".08"/>
					<rect x="668" y="308" width="160" height="16" rx="8" fill="<?php echo $d; ?>"/>
					<?php for ( $r = 0; $r < 5; $r++ ) : ?>
						<?php for ( $c = 0; $c < 7; $c++ ) : ?>
							<rect x="<?php echo 668 + $c * 48; ?>" y="<?php echo 348 + $r * 48; ?>" width="38" height="38" rx="10" fill="<?php echo ( 2 === $r && 3 === $c ) ? $a : $d; ?>" opacity="<?php echo ( 2 === $r && 3 === $c ) ? '1' : '.06'; ?>"/>
						<?php endfor; ?>
					<?php endfor; ?>
					<rect x="668" y="606" width="336" height="44" rx="10" fill="<?php echo $d; ?>" opacity=".06"/>
					<rect x="668" y="662" width="336" height="44" rx="10" fill="<?php echo $d; ?>" opacity=".06"/>
					<rect x="668" y="740" width="336" height="52" rx="12" fill="<?php echo $d; ?>"/>
					<?php for ( $i = 0; $i < 3; $i++ ) : ?>
						<rect x="168" y="<?php echo 560 + $i * 96; ?>" width="420" height="80" rx="14" fill="<?php echo $d; ?>" opacity=".05"/>
						<circle cx="210" cy="<?php echo 600 + $i * 96; ?>" r="20" fill="<?php echo $a; ?>" opacity="<?php echo 1 - $i * 0.25; ?>"/>
						<rect x="246" y="<?php echo 588 + $i * 96; ?>" width="200" height="12" rx="6" fill="<?php echo $d; ?>"/>
						<rect x="246" y="<?php echo 608 + $i * 96; ?>" width="140" height="10" rx="5" fill="<?php echo $d; ?>" opacity=".3"/>
					<?php endfor; ?>
				<?php endif; ?>
			</g>
		</g>
	</svg>
	<?php
	return ob_get_clean();
}
