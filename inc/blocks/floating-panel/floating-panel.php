<?php
/**
 * Floating Panel Logic.
 */

$contact_content = get_field( 'floating_panel_contact', 'option' );
$map_code        = get_field( 'floating_panel_map', 'option' );
$whatsapp        = get_field( 'floating_panel_whatsapp', 'option' );

if ( ! $contact_content && ! $map_code && ! $whatsapp ) {
	if ( is_admin() ) {
		echo '<p style="padding:20px; background:#eee;">Floating Panel: Configure settings in Global Options.</p>';
	}
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( array(
	'class' => 'lemon-floating-panel',
	'id'    => 'lemonFloatingPanel',
	'style' => is_admin() ? 'position:relative; top:auto; left:auto; transform:none;' : '',
) );
?>
	<div <?php echo $wrapper_attributes; ?>>
		<div class="lemon-fp-content">
			<button class="lemon-fp-close" aria-label="Close">&times;</button>
			
			<div class="lemon-fp-tab-content" id="lemonFpContact">
				<h3 class="lemon-fp-title"><?php esc_html_e( 'Contact Us', 'lemon-concentrate' ); ?></h3>
				<div class="lemon-fp-body">
					<?php echo wp_kses_post( $contact_content ); ?>
				</div>
			</div>

			<div class="lemon-fp-tab-content" id="lemonFpMap">
				<h3 class="lemon-fp-title"><?php esc_html_e( 'Our Location', 'lemon-concentrate' ); ?></h3>
				<div class="lemon-fp-body lemon-fp-map-container">
					<?php echo $map_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		</div>

		<div class="lemon-fp-triggers">
			<button class="lemon-fp-trigger" data-target="lemonFpContact" aria-label="Contact">
				<span class="lemon-fp-icon">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
				</span>
			</button>
			<button class="lemon-fp-trigger" data-target="lemonFpMap" aria-label="Location">
				<span class="lemon-fp-icon">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
				</span>
			</button>
			<?php if ( $whatsapp ) : ?>
				<a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $whatsapp ) ); ?>" class="lemon-fp-trigger lemon-fp-whatsapp" target="_blank" aria-label="WhatsApp">
					<span class="lemon-fp-icon">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
					</span>
				</a>
			<?php endif; ?>
		</div>
	</div>