<?php
/**
 * Contact Form Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$wrapper_attributes = get_block_wrapper_attributes( array(
	'class'         => 'lemon-contact-form',
	'data-ajax-url' => admin_url( 'admin-ajax.php' ),
) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<form class="lemon-contact-form-inner" action="#" method="post">
		<?php wp_nonce_field( 'lemon_contact_form_submit', 'lemon_contact_nonce' ); ?>
		<input type="hidden" name="action" value="lemon_contact_form_submit">
		
		<div class="lemon-contact-form-row lemon-contact-form-row-split">
			<div class="lemon-contact-form-group">
				<label for="contact-name"><?php esc_html_e( 'Name', 'lemon-concentrate' ); ?></label>
				<input type="text" id="contact-name" name="contact_name" placeholder="<?php esc_attr_e( 'Name', 'lemon-concentrate' ); ?>" required>
			</div>
			<div class="lemon-contact-form-group">
				<label for="contact-phone"><?php esc_html_e( 'Phone', 'lemon-concentrate' ); ?></label>
				<input type="tel" id="contact-phone" name="contact_phone" placeholder="<?php esc_attr_e( 'Phone', 'lemon-concentrate' ); ?>" required>
			</div>
		</div>

		<div class="lemon-contact-form-row lemon-contact-form-row-split">
			<div class="lemon-contact-form-group">
				<label for="contact-role"><?php esc_html_e( 'Role', 'lemon-concentrate' ); ?></label>
				<input type="text" id="contact-role" name="contact_role" placeholder="<?php esc_attr_e( 'Role', 'lemon-concentrate' ); ?>" required>
			</div>
			<div class="lemon-contact-form-group">
				<label for="contact-email"><?php esc_html_e( 'Email', 'lemon-concentrate' ); ?></label>
				<input type="email" id="contact-email" name="contact_email" placeholder="<?php esc_attr_e( 'Email', 'lemon-concentrate' ); ?>" required>
			</div>
		</div>

		<div class="lemon-contact-form-row lemon-contact-form-row-split">
			<div class="lemon-contact-form-group">
				<label for="contact-company"><?php esc_html_e( 'Company', 'lemon-concentrate' ); ?></label>
				<input type="text" id="contact-company" name="contact_company" placeholder="<?php esc_attr_e( 'Company', 'lemon-concentrate' ); ?>" required>
			</div>
			<div class="lemon-contact-form-group">
				<label for="contact-country"><?php esc_html_e( 'Country', 'lemon-concentrate' ); ?></label>
				<select id="contact-country" name="contact_country" required>
					<option value="" selected="selected"><?php esc_html_e( 'Country', 'lemon-concentrate' ); ?></option>
					<?php
					$countries = array();
					if ( class_exists( 'WC_Countries' ) ) {
						$countries_obj = new WC_Countries();
						$countries     = $countries_obj->get_countries();
					}

					foreach ( $countries as $code => $name ) {
						echo '<option value="' . esc_attr( $name ) . '">' . esc_html( $name ) . '</option>';
					}
					?>
				</select>
			</div>
		</div>

		<div class="lemon-contact-form-row">
			<div class="lemon-contact-form-group">
				<label for="contact-message"><?php esc_html_e( 'Message', 'lemon-concentrate' ); ?></label>
				<textarea id="contact-message" name="contact_message" rows="4" placeholder="<?php esc_attr_e( 'Message', 'lemon-concentrate' ); ?>" required></textarea>
			</div>
		</div>

		<div class="lemon-contact-form-row">
			<div class="lemon-contact-form-group lemon-contact-form-consent">
				<label class="lemon-contact-checkbox-label">
					<input type="checkbox" name="contact_consent" required>
					<?php echo wp_kses_post( __( 'I\'ve read and agree with the <a href="https://lemonconcentrate.com/privacy_policy/" target="_blank">privacy policy</a>*', 'lemon-concentrate' ) ); ?>
				</label>
			</div>
		</div>

		<div class="lemon-contact-form-row lemon-contact-form-submit">
			<button type="submit" class="wp-block-button__link"><?php esc_html_e( 'Send Message', 'lemon-concentrate' ); ?></button>
		</div>

		<div class="lemon-contact-message" style="margin-top: 15px; display: none;"></div>
	</form>
</div>