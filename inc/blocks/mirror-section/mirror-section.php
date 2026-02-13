<?php
/**
 * Mirror Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Retrieve the sections repeater from the current post.
$sections = get_field( 'sections', $post_id );

// Fallback if no sections are found.
if ( empty( $sections ) && ! empty( $is_preview ) ) {
	$sections = array(
		array(
			'title' => 'Industrial Processing',
			'text'  => '<p>Our orange pulp cells are processed using state-of-the-art technology to ensure maximum integrity and flavor retention. Suitable for a wide range of industrial applications including beverages, dairy products, and bakery items.</p>',
			'image' => '', 
			'order' => 1, // Left
		),
		array(
			'title' => 'Quality Assurance',
			'text'  => '<p>We adhere to strict quality control measures throughout the manufacturing process. From fruit selection to final packaging, every step is monitored to guarantee a premium product that meets international standards.</p>',
			'image' => '',
			'order' => 0, // Right
		),
	);
}

// Filter sections based on block setting.
$display_mode = get_field( 'mirror_section_display_mode' );
$transparent_bg = get_field( 'mirror_section_transparent_bg' );
$include_contact = get_field( 'mirror_section_include_contact' );
$contact_pos     = get_field( 'mirror_section_contact_position' ) ?: 2;

if ( $sections && is_array( $sections ) ) {
	if ( 'first_2' === $display_mode ) {
		$sections = array_slice( $sections, 0, 2 );
	} elseif ( 'offset_2' === $display_mode ) {
		$sections = array_slice( $sections, 2 );
	}
}

if ( empty( $sections ) ) {
	return;
}

// Determine background color from product category
$style_attr = '';
$color = '';

// 1. Check Product Override
if ( function_exists( 'get_field' ) ) {
	$color = get_field( 'product_color_override', $post_id );
}

// 2. Check Category if no override
if ( ! $color && function_exists( 'lemon_concentrate_get_category_color' ) ) {
	$category = null;
	$terms = get_the_terms( $post_id, 'product_category' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$category = $terms[0];
		// Try to find the most specific category (deepest child).
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

$contact_form_bg_color = $color;

if ( $transparent_bg ) {
	$style_attr = 'padding: 0;';
} elseif ( $color && 'transparent' !== $color ) {
	// Darken the color slightly (15%) for consistency with other blocks.
	if ( function_exists( 'lemon_concentrate_darken_color' ) ) {
		$color = lemon_concentrate_darken_color( $color, 15 );
	}

	$hex = ltrim( $color, '#' );
	if ( preg_match( '/^([a-f0-9]{3}|[a-f0-9]{6})$/i', $hex ) ) {
		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$style_attr = "background-color: rgba($r, $g, $b, 0.1); padding: 3rem; border-radius: 8px;";
	}
}

$wrapper_attributes_args = array( 'class' => 'lemon-mirror-sections' );
if ( $transparent_bg ) {
	$wrapper_attributes_args['class'] .= ' is-transparent';
}
if ( $style_attr ) {
	$wrapper_attributes_args['style'] = $style_attr;
}

$wrapper_attributes = get_block_wrapper_attributes( $wrapper_attributes_args );
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( ! empty( $sections ) ) : ?>
		<?php foreach ( $sections as $index => $section ) : ?>
			<?php
			$title = isset( $section['title'] ) ? $section['title'] : '';
			$text  = isset( $section['text'] ) ? $section['text'] : '';
			$image = isset( $section['image'] ) ? $section['image'] : ''; // Returns URL string based on ACF config

			if ( empty( $image ) ) {
				$image = get_theme_file_uri( 'assets/images/placeholder.svg' );
			}

			$order = isset( $section['order'] ) ? $section['order'] : false; // True = Left, False = Right
			
			$row_class = $order ? 'image-left' : 'image-right';
			?>
			<div class="lemon-mirror-section-row <?php echo esc_attr( $row_class ); ?>">
				<div class="lemon-mirror-section-content">
					<div class="lemon-mirror-section-body">
						<?php if ( $title ) : ?>
							<h3 class="lemon-mirror-section-title"><?php echo esc_html( $title ); ?></h3>
						<?php endif; ?>
						<?php echo wp_kses_post( $text ); ?>
					</div>
				</div>
				<div class="lemon-mirror-section-image">
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
				</div>
			</div>

			<?php if ( $include_contact && ( $index + 1 ) === (int) $contact_pos ) : ?>
				<?php
				$contact_label = get_field( 'mirror_contact_label' ) ?: 'Contact us';
				$contact_title = get_field( 'mirror_contact_title' ) ?: 'We will be happy to assist you';
				$contact_text  = get_field( 'mirror_contact_text' ) ?: 'Email us and our team will answer all your needs.';
				$contact_bg    = get_field( 'mirror_contact_bg_color' );
				$testimonials  = get_field( 'testimonials', 'option' );

				if ( empty( $contact_bg ) ) {
					$contact_bg = $contact_form_bg_color ?: '#000000';
				}

				$info_style = '';
				if ( $contact_bg ) {
					$info_style = 'style="background: ' . esc_attr( $contact_bg ) . ';"';
				}
				?>
				<div class="lemon-mirror-section-contact wp-block-lemon-concentrate-contact-form lemon-contact-form" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
					<div class="lemon-contact-layout">
						<div class="lemon-contact-info" <?php echo $info_style; ?>>
							<div class="lemon-contact-info-content">
								<?php if ( $contact_label ) : ?>
									<p class="lemon-contact-label"><?php echo esc_html( $contact_label ); ?></p>
								<?php endif; ?>
								<?php if ( $contact_title ) : ?>
									<h2 class="lemon-contact-title"><?php echo esc_html( $contact_title ); ?></h2>
								<?php endif; ?>
								<?php if ( $contact_text ) : ?>
									<div class="lemon-contact-text"><?php echo wp_kses_post( $contact_text ); ?></div>
								<?php endif; ?>
							</div>

							<?php if ( $testimonials ) : ?>
								<div class="lemon-testimonials-block align wp-block-lemon-concentrate-testimonials">
									<div class="lemon-testimonials-carousel">
										<div class="lemon-testimonials-track">
											<?php foreach ( $testimonials as $t_index => $testimonial ) : ?>
												<div class="lemon-testimonial-slide <?php echo 0 === $t_index ? 'is-active' : ''; ?>">
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
							<?php endif; ?>
						</div>

						<form class="lemon-contact-form-inner" action="#" method="post">
							<?php wp_nonce_field( 'lemon_contact_form_submit', 'lemon_contact_nonce' ); ?>
							<input type="hidden" name="action" value="lemon_contact_form_submit">
							
							<div class="lemon-contact-form-row lemon-contact-form-row-split">
								<div class="lemon-contact-form-group">
									<label for="contact-name-mirror"><?php esc_html_e( 'Name', 'lemon-concentrate' ); ?></label>
									<input type="text" id="contact-name-mirror" name="contact_name" placeholder="<?php esc_attr_e( 'Name', 'lemon-concentrate' ); ?>" required>
								</div>
								<div class="lemon-contact-form-group">
									<label for="contact-phone-mirror"><?php esc_html_e( 'Phone', 'lemon-concentrate' ); ?></label>
									<input type="tel" id="contact-phone-mirror" name="contact_phone" placeholder="<?php esc_attr_e( 'Phone', 'lemon-concentrate' ); ?>" required>
								</div>
							</div>

							<div class="lemon-contact-form-row lemon-contact-form-row-split">
								<div class="lemon-contact-form-group">
									<label for="contact-role-mirror"><?php esc_html_e( 'Role', 'lemon-concentrate' ); ?></label>
									<input type="text" id="contact-role-mirror" name="contact_role" placeholder="<?php esc_attr_e( 'Role', 'lemon-concentrate' ); ?>" required>
								</div>
								<div class="lemon-contact-form-group">
									<label for="contact-email-mirror"><?php esc_html_e( 'Email', 'lemon-concentrate' ); ?></label>
									<input type="email" id="contact-email-mirror" name="contact_email" placeholder="<?php esc_attr_e( 'Email', 'lemon-concentrate' ); ?>" required>
								</div>
							</div>

							<div class="lemon-contact-form-row lemon-contact-form-row-split">
								<div class="lemon-contact-form-group">
									<label for="contact-company-mirror"><?php esc_html_e( 'Company', 'lemon-concentrate' ); ?></label>
									<input type="text" id="contact-company-mirror" name="contact_company" placeholder="<?php esc_attr_e( 'Company', 'lemon-concentrate' ); ?>" required>
								</div>
								<div class="lemon-contact-form-group">
									<label for="contact-country-mirror"><?php esc_html_e( 'Country', 'lemon-concentrate' ); ?></label>
									<select id="contact-country-mirror" name="contact_country" required>
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
									<label for="contact-message-mirror"><?php esc_html_e( 'Message', 'lemon-concentrate' ); ?></label>
									<textarea id="contact-message-mirror" name="contact_message" rows="4" placeholder="<?php esc_attr_e( 'Message', 'lemon-concentrate' ); ?>" required></textarea>
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
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<style>
	.lemon-mirror-section-body ul li {
		font-size: 1.125rem;
		margin-bottom: 0.5rem;
	}
	/* Contact Form Styles */
	.lemon-mirror-section-contact {
		padding: 3rem 0;
		width: 100%;
	}
	.lemon-contact-layout {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 4rem;
		align-items: start;
	}
	.lemon-contact-form-row {
		margin-bottom: 1.5rem;
	}
	.lemon-contact-form-row-split {
		display: flex;
		gap: 2rem;
	}
	.lemon-contact-form-group {
		flex: 1;
		display: flex;
		flex-direction: column;
	}
	.lemon-contact-form-group label {
		margin-bottom: 0.5rem;
		font-weight: 500;
		font-size: 0.9rem;
		text-transform: uppercase;
		letter-spacing: 0.05em;
	}
	.lemon-contact-form-group input:not([type="checkbox"]),
	.lemon-contact-form-group select,
	.lemon-contact-form-group textarea {
		width: 100%;
		padding: 0.75rem;
		border: 1px solid #ccc;
		border-radius: 4px;
		font-size: 1rem;
		background-color: #fff;
		box-sizing: border-box;
	}
	.lemon-contact-checkbox-label {
		display: flex;
		align-items: center;
		gap: 0.5rem;
		cursor: pointer;
		font-size: 0.9rem;
	}
	.lemon-contact-form-submit .wp-block-button__link {
    font-size: 1.1rem;
    background-color: #ffffff;
    border: 2px solid var(--category-color, var(--wp--preset--color--secondary));
    color: var(--wp--preset--color--primary);
	box-shadow:none;
}
	.lemon-contact-info {
		padding: var(--wp--preset--spacing--80);
		border-radius: 8px;
		color: #fff;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		height: 100%;
		box-sizing: border-box;
	}
	.lemon-contact-label {
		letter-spacing: 0px;
		text-transform: uppercase;
		margin-bottom: 1rem;
		color: var(--wp--preset--color--contrast);
	}
	.lemon-contact-title {
		margin-top: 0;
		margin-bottom: 1.5rem;
		font-size: 2.5rem;
		color: #fff;
		font-weight: 500;
	}
	.lemon-contact-text {
		color: #fff;
	}
	/* Testimonials inside Contact Form */
	.lemon-testimonials-block {
		margin-top: 3rem;
	}
	.lemon-testimonials-track {
		display: grid;
		grid-template-areas: "slide";
	}
	.lemon-testimonial-slide {
		grid-area: slide;
		opacity: 0;
		transform: translateX(20px);
		transition: opacity 0.5s ease, transform 0.5s ease;
		pointer-events: none;
	}
	.lemon-testimonial-slide.is-active {
		opacity: 1;
		transform: translateX(0);
		pointer-events: auto;
	}
	.lemon-testimonial-quote {
		font-size: 1.5rem;
		font-style: normal;
		margin: 0;
		color: #fff;
		border-left: none;
		padding-left: 0;
	}
	.lemon-testimonials-nav {
		display: flex;
		gap: 0.5rem;
		margin-top: 1.5rem;
	}
	.lemon-testimonials-nav button {
		background: #ffffff;
		border: none;
		color: var(--wp--preset--color--primary, #000000);
		border-radius: 50%;
		width: 40px;
		height: 40px;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		padding: 0;
		transition: all 0.3s ease;
	}
	.lemon-testimonials-nav button:hover {
		transform: scale(1.1);
		box-shadow: 0 4px 12px rgba(0,0,0,0.15);
	}
	@media (max-width: 768px) {
		.lemon-contact-form-row-split { flex-direction: column; gap: 1.5rem; }
		.lemon-contact-layout {
			grid-template-columns: 1fr;
		}
	}
</style>
