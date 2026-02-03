<?php
/**
 * Contact Form Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-contact-form' ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<form class="lemon-contact-form-inner" action="#" method="post">
		
		<div class="lemon-contact-form-row lemon-contact-form-row-split">
			<div class="lemon-contact-form-group">
				<label for="contact-name"><?php esc_html_e( 'Name', 'lemon-concentrate' ); ?></label>
				<input type="text" id="contact-name" name="contact_name" placeholder="<?php esc_attr_e( 'Your Name', 'lemon-concentrate' ); ?>" required>
			</div>
			<div class="lemon-contact-form-group">
				<label for="contact-surname"><?php esc_html_e( 'Surname', 'lemon-concentrate' ); ?></label>
				<input type="text" id="contact-surname" name="contact_surname" placeholder="<?php esc_attr_e( 'Your Surname', 'lemon-concentrate' ); ?>" required>
			</div>
		</div>

		<div class="lemon-contact-form-row">
			<div class="lemon-contact-form-group">
				<label for="contact-company"><?php esc_html_e( 'Company', 'lemon-concentrate' ); ?></label>
				<input type="text" id="contact-company" name="contact_company" placeholder="<?php esc_attr_e( 'Company Name', 'lemon-concentrate' ); ?>">
			</div>
		</div>

		<div class="lemon-contact-form-row">
			<div class="lemon-contact-form-group">
				<label for="contact-telephone"><?php esc_html_e( 'Telephone', 'lemon-concentrate' ); ?></label>
				<input type="tel" id="contact-telephone" name="contact_telephone" placeholder="<?php esc_attr_e( '+1 234 567 890', 'lemon-concentrate' ); ?>">
			</div>
		</div>

		<div class="lemon-contact-form-row">
			<div class="lemon-contact-form-group">
				<label for="contact-comments"><?php esc_html_e( 'Comments', 'lemon-concentrate' ); ?></label>
				<textarea id="contact-comments" name="contact_comments" rows="4" placeholder="<?php esc_attr_e( 'How can we help you?', 'lemon-concentrate' ); ?>"></textarea>
			</div>
		</div>

		<div class="lemon-contact-form-row lemon-contact-form-submit">
			<button type="submit" class="wp-block-button__link"><?php esc_html_e( 'Send Message', 'lemon-concentrate' ); ?></button>
		</div>

	</form>
</div>