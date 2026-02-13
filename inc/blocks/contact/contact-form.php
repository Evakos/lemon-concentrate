<?php
/**
 * Contact Form Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$label = get_field( 'label' ) ?: 'Contact us';
$title = get_field( 'title' ) ?: 'We will be happy to assist you';
$text  = get_field( 'text' ) ?: 'Email us and our team will answer all your needs.';
$testimonials = get_field( 'testimonials', 'option' );
$extra_type   = get_field( 'contact_extra_type' ) ?: 'testimonials';
$simple_text  = get_field( 'product_contact_simple_text', $post_id );
$bg_color     = get_field( 'info_background_color' );

if ( empty( $bg_color ) ) {
	// Attempt to get category color
	$color = '';
	if ( function_exists( 'get_field' ) ) {
		$color = get_field( 'product_color_override', $post_id );
	}
	if ( ! $color && function_exists( 'lemon_concentrate_get_category_color' ) ) {
		$category = null;
		$terms    = get_the_terms( $post_id, 'product_category' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$category = $terms[0];
			foreach ( $terms as $term ) {
				if ( $term->parent !== 0 && ( $category->parent === 0 || $term->parent === $category->term_id ) ) {
					$category = $term;
				}
			}
		} elseif ( is_tax( 'product_category' ) ) {
			$category = get_queried_object();
		}

		if ( $category ) {
			$color = lemon_concentrate_get_category_color( $category->slug );
		}
	}
	if ( $color ) {
		$bg_color = $color;
	}
}

$wrapper_attributes = get_block_wrapper_attributes( array(
	'class'         => 'lemon-contact-form',
	'data-ajax-url' => admin_url( 'admin-ajax.php' ),
) );

$info_style = '';
if ( $bg_color ) {
	$info_style = 'style="background: ' . esc_attr( $bg_color ) . ';"';
}
?>
<div <?php echo $wrapper_attributes; ?>>
	<div class="lemon-contact-layout">
		<div class="lemon-contact-info" <?php echo $info_style; ?>>
			<div class="lemon-contact-info-content">
				<?php if ( $label ) : ?>
					<p class="lemon-contact-label"><?php echo esc_html( $label ); ?></p>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h2 class="lemon-contact-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $text ) : ?>
					<div class="lemon-contact-text"><?php echo wp_kses_post( $text ); ?></div>
				<?php endif; ?>
			</div>

			<?php if ( 'testimonials' === $extra_type && $testimonials ) : ?>
				<div class="lemon-testimonials-block align wp-block-lemon-concentrate-testimonials">
					<div class="lemon-testimonials-carousel">
						<div class="lemon-testimonials-track">
							<?php foreach ( $testimonials as $index => $testimonial ) : ?>
								<div class="lemon-testimonial-slide <?php echo 0 === $index ? 'is-active' : ''; ?>">
									<blockquote class="lemon-testimonial-quote">
										<?php echo wp_kses_post( $testimonial['quote'] ); ?>
									</blockquote>
								</div>
							<?php endforeach; ?>
						</div>
						<?php if ( count( $testimonials ) > 1 ) : ?>
						<div class="lemon-testimonials-nav">
							<button class="lemon-testimonials-prev" aria-label="<?php esc_attr_e( 'Previous', 'lemon-concentrate' ); ?>">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
							</button>
							<button class="lemon-testimonials-next" aria-label="<?php esc_attr_e( 'Next', 'lemon-concentrate' ); ?>">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
							</button>
						</div>
						<?php endif; ?>
					</div>
				</div>
			<?php elseif ( 'text' === $extra_type && $simple_text ) : ?>
				<div class="lemon-contact-simple-text">
					<?php echo wp_kses_post( $simple_text ); ?>
				</div>
			<?php endif; ?>
		</div>

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
</div>