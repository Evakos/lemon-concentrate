<?php
/**
 * Product Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-product-slider-block' ) );

$products = array();

if ( function_exists( 'wc_get_products' ) ) {
	$products = wc_get_products( array(
		'status'   => 'publish',
		'limit'    => 8,
		'featured' => true,
	) );
}

// Fallback for preview if no products found or WC not active.
if ( empty( $products ) && $is_preview ) {
	// Create dummy objects for preview.
	$products = array( (object) array( 'dummy' => true ), (object) array( 'dummy' => true ), (object) array( 'dummy' => true ) );
}
?>

<div <?php echo $wrapper_attributes; ?>>
	<?php if ( ! empty( $products ) ) : ?>
		<div class="lemon-product-slider-container">
			<button class="lemon-product-slider-prev" aria-label="<?php esc_attr_e( 'Previous', 'lemon-concentrate' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>
			<button class="lemon-product-slider-next" aria-label="<?php esc_attr_e( 'Next', 'lemon-concentrate' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>
			<div class="lemon-product-slider-track">
				<?php foreach ( $products as $product ) : ?>
					<div class="lemon-product-slide">
						<?php if ( isset( $product->dummy ) ) : ?>
							<div class="lemon-product-card">
								<img src="https://placehold.co/400x400" alt="Placeholder Product" />
								<h3>Example Product</h3>
								<span class="price">$99.00</span>
								<a href="#" class="lemon-product-button">
									<?php esc_html_e( 'Learn More', 'lemon-concentrate' ); ?>
								</a>
							</div>
						<?php else : ?>
							<div class="lemon-product-card">
								<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="lemon-product-link">
									<?php echo $product->get_image( 'woocommerce_thumbnail' ); ?>
									<h3 class="lemon-product-title"><?php echo esc_html( $product->get_name() ); ?></h3>
									<span class="price"><?php echo $product->get_price_html(); ?></span>
								</a>
								<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="lemon-product-button">
									<?php esc_html_e( 'Learn More', 'lemon-concentrate' ); ?>
								</a>
								<?php
								// Optional: Add to cart button.
								// woocommerce_template_loop_add_to_cart();
								?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="lemon-product-slider-dots"></div>
		</div>
	<?php else : ?>
		<p><?php esc_html_e( 'No featured products found.', 'lemon-concentrate' ); ?></p>
	<?php endif; ?>
</div>