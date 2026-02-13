<?php
/**
 * Product Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$minimal = get_field( 'minimal_style' );
$hide_title = get_field( 'hide_title' );
$class_name = 'lemon-product-slider-block';
if ( $minimal ) {
	$class_name .= ' is-minimal';
}
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $class_name ) );

$products = array();

$products = get_posts( array(
	'post_type'      => 'lemon_product',
	'posts_per_page' => 8,
	'post_status'    => 'publish',
	'meta_key'       => '_lemon_featured',
	'meta_value'     => '1',
) );

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
								<img src="https://placehold.co/250x250" alt="Placeholder Product" />
								<?php if ( ! $hide_title ) : ?>
									<h3>Example Product</h3>
								<?php endif; ?>
								<span class="price">$99.00</span>
								<?php if ( ! $minimal ) : ?>
									<a href="#" class="lemon-product-button">
										<?php esc_html_e( 'Learn More', 'lemon-concentrate' ); ?>
									</a>
								<?php endif; ?>
							</div>
						<?php else : ?>
							<div class="lemon-product-card">
								<a href="<?php echo esc_url( get_permalink( $product->ID ) ); ?>" class="lemon-product-link">
									<?php
									$thumbnail = get_the_post_thumbnail( $product->ID, 'medium' );
									if ( $thumbnail ) {
										echo $thumbnail;
									} else {
										echo '<img src="' . esc_url( get_theme_file_uri( 'assets/images/placeholder.svg' ) ) . '" alt="' . esc_attr__( 'Placeholder', 'lemon-concentrate' ) . '" />';
									}
									?>
									<?php if ( ! $hide_title ) : ?>
										<h3 class="lemon-product-title"><?php echo esc_html( get_the_title( $product->ID ) ); ?></h3>
									<?php endif; ?>
								</a>
								<?php if ( ! $minimal ) : ?>
									<a href="<?php echo esc_url( get_permalink( $product->ID ) ); ?>" class="lemon-product-button">
										<?php esc_html_e( 'Learn More', 'lemon-concentrate' ); ?>
									</a>
								<?php endif; ?>
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
	<style>
		.lemon-product-slider-block.is-minimal .lemon-product-card {
			background: transparent;
			box-shadow: none;
			border: none;
			padding: 0;
		}
		.lemon-product-title {
			text-transform: uppercase;
			font-weight: 400;
			font-size: 0.9rem;
		}
		.lemon-product-card img {
			width: 250px;
			height: 250px;
			object-fit: cover;
			margin: 0 auto;
		}
	</style>
</div>