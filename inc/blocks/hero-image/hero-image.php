<?php
/**
 * Hero Image Block Template.
 *
 * @package lemon-concentrate
 */

$image  = null;
$object = get_queried_object();

if ( is_a( $object, 'WP_Term' ) && function_exists( 'get_field' ) ) {
	$image = get_field( 'hero_image', $object );
} elseif ( is_singular( 'lemon_product' ) && function_exists( 'get_field' ) ) {
	$terms = get_the_terms( get_the_ID(), 'product_category' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$image = get_field( 'hero_image', $terms[0] );
	}
}

// Fallback to placeholder if no image is found.
if ( ! $image ) {
	$image = get_theme_file_uri( 'assets/images/placeholder.svg' );
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-category-hero-image' ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( $image ) : ?>
		<?php
		if ( is_array( $image ) ) {
			echo wp_get_attachment_image( $image['ID'], 'full' );
		} elseif ( is_numeric( $image ) ) {
			echo wp_get_attachment_image( $image, 'full' );
		} else {
			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Hero Image', 'lemon-concentrate' ) . '" />';
		}
		?>
	<?php endif; ?>
</div>