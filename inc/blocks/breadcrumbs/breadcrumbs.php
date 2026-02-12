<?php
/**
 * Breadcrumbs Block Template.
 */

$icon_html = '';
$term      = null;

// 1. Determine the relevant term (Category)
$queried_object = get_queried_object();

if ( is_a( $queried_object, 'WP_Term' ) && 'product_category' === $queried_object->taxonomy ) {
	// We are on a category archive
	$term = $queried_object;
} elseif ( is_singular( 'lemon_product' ) ) {
	// We are on a single product, find the most specific category
	$terms = get_the_terms( get_the_ID(), 'product_category' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$term = $terms[0];
		foreach ( $terms as $t ) {
			// If $t is a child of the current $term, or $term is top-level, update $term to $t
			if ( $t->parent !== 0 && ( $term->parent === 0 || $t->parent === $term->term_id ) ) {
				$term = $t;
			}
		}
	}
}

// 2. Fetch the icon from the term
if ( $term ) {
	// Use the specific ID format for terms to ensure compatibility
	$icon = get_field( 'icon', 'product_category_' . $term->term_id );
	if ( $icon ) {
		if ( is_array( $icon ) ) {
			$icon_html = wp_get_attachment_image( $icon['ID'], 'thumbnail' );
		} elseif ( is_numeric( $icon ) ) {
			$icon_html = wp_get_attachment_image( $icon, 'thumbnail' );
		} else {
			$icon_html = '<img src="' . esc_url( $icon ) . '" alt="' . esc_attr( $term->name ) . '" />';
		}
	}
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-concentrate-breadcrumbs' ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( $icon_html ) : ?>
		<div class="lemon-concentrate-breadcrumbs-icon">
			<?php echo $icon_html; ?>
		</div>
	<?php endif; ?>

	<?php
	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		rank_math_the_breadcrumbs();
	} elseif ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
	}
	?>
</div>