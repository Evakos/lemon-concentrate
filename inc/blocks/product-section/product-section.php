<?php
/**
 * Product Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$sections = get_field( 'sections' );

// Fallback for preview
if ( empty( $sections ) ) {
	$sections = array(
		array(
			'order'        => 1, // 1 = Left (Default)
			'title'        => 'This is a Product Section Title Left Aligned',
			'image'        => 0,
			'text'         => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vel mi vitae mi maximus rhoncus id vel nulla. Donec blandit venenatis porttitor. Ut congue leo ex, et egestas ex suscipit in. Nunc ultrices, est eu bibendum euismod, odio ligula mollis ante, commodo cursus nisl ipsum non dui. Proin eget ornare nunc, in aliquam augue. Maecenas non turpis non magna hendrerit sagittis. Nulla a lacus suscipit, eleifend dui ut, ultricies quam. Cras elit lorem, aliquet at molestie et, tristique ut enim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur eleifend odio in purus iaculis ullamcorper. Fusce commodo, urna vel interdum bibendum, dui est suscipit sem, ac ullamcorper lectus augue ut felis. Proin porttitor ex id pulvinar laoreet.',
		),
		array(
			'order'        => 0, // 0 = Right (Flipped)
			'title'        => 'This is a Product Section Title Right Flipped',
			'image'        => 0,
			'text'         => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vel mi vitae mi maximus rhoncus id vel nulla. Donec blandit venenatis porttitor. Ut congue leo ex, et egestas ex suscipit in. Nunc ultrices, est eu bibendum euismod, odio ligula mollis ante, commodo cursus nisl ipsum non dui. Proin eget ornare nunc, in aliquam augue. Maecenas non turpis non magna hendrerit sagittis. Nulla a lacus suscipit, eleifend dui ut, ultricies quam. Cras elit lorem, aliquet at molestie et, tristique ut enim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur eleifend odio in purus iaculis ullamcorper. Fusce commodo, urna vel interdum bibendum, dui est suscipit sem, ac ullamcorper lectus augue ut felis. Proin porttitor ex id pulvinar laoreet.',
		),
	);
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'product-section-block' ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( $sections ) : ?>
		<?php foreach ( $sections as $section ) : ?>
			<?php
			// 'order' field: 1 (True) = Left, 0 (False) = Right.
			// If order is 0 (Right), we flip the columns.
			$flip  = isset( $section['order'] ) && ! $section['order'];
			$title = $section['title'] ?? '';
			$image = $section['image'] ?? 0;
			$text  = $section['text'] ?? '';
			?>
			<div class="product-section-row <?php echo $flip ? 'is-flipped' : ''; ?>">
				<div class="product-section-col-media">
					<?php if ( $image ) : ?>
						<?php
						// Handle both Image ID (int) and URL (string)
						echo is_numeric( $image ) ? wp_get_attachment_image( $image, 'large' ) : '<img src="' . esc_url( $image ) . '" alt="" />';
						?>
					<?php else : ?>
						<img src="http://lemon-concentrate.local/wp-content/uploads/2023/10/placeholder.svg" alt="<?php esc_attr_e( 'Placeholder', 'lemon-concentrate' ); ?>" />
					<?php endif; ?>
				</div>
				<div class="product-section-col-text">
					<?php if ( $title ) : ?>
						<h3 class="product-section-title"><?php echo esc_html( $title ); ?></h3>
					<?php endif; ?>
					<?php echo wp_kses_post( $text ); ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>