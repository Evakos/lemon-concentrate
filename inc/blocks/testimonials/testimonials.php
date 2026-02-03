<?php
/**
 * Testimonials Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get testimonials from Global Options.
$testimonials = get_field( 'testimonials', 'option' );

// Fallback for preview.
if ( ! $testimonials && $is_preview ) {
	$testimonials = array(
		array( 'quote' => 'This is an example testimonial. Add real ones in Theme Options.' ),
		array( 'quote' => 'Another sample testimonial to demonstrate the carousel.' ),
	);
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-testimonials-block' ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( $testimonials ) : ?>
		<div class="lemon-testimonials-carousel">
			<div class="lemon-testimonials-track">
				<?php foreach ( $testimonials as $index => $item ) : ?>
					<div class="lemon-testimonial-slide <?php echo $index === 0 ? 'is-active' : ''; ?>">
						<blockquote class="lemon-testimonial-quote">
							<?php echo wp_kses_post( $item['quote'] ); ?>
						</blockquote>
					</div>
				<?php endforeach; ?>
			</div>
			
			<?php if ( count( $testimonials ) > 1 ) : ?>
				<div class="lemon-testimonials-nav">
					<button class="lemon-testimonials-prev" aria-label="<?php esc_attr_e( 'Previous', 'lemon-concentrate' ); ?>">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
					<button class="lemon-testimonials-next" aria-label="<?php esc_attr_e( 'Next', 'lemon-concentrate' ); ?>">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</div>
			<?php endif; ?>
		</div>
	<?php else : ?>
		<p><?php esc_html_e( 'No testimonials found.', 'lemon-concentrate' ); ?></p>
	<?php endif; ?>
</div>