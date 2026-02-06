<?php
/**
 * Render callback for the Breadcrumbs block.
 *
 * @package lemon-concentrate
 */

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-concentrate-breadcrumbs' ) );

// Determine the icon based on category.
$icon_html    = '';
$current_term = null;

if ( is_tax( 'product_category' ) ) {
	$current_term = get_queried_object();
} elseif ( is_singular( 'lemon_product' ) ) {
	$terms = get_the_terms( get_the_ID(), 'product_category' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$current_term = $terms[0];
	}
}

if ( $current_term ) {
	// Try ACF Icon first.
	if ( function_exists( 'get_field' ) ) {
		$acf_icon = get_field( 'icon', 'product_category_' . $current_term->term_id );
		if ( $acf_icon ) {
			if ( is_array( $acf_icon ) ) {
				$icon_html = wp_get_attachment_image( $acf_icon['ID'], 'thumbnail', false, array( 'style' => 'width: 20px; height: auto; display: block;' ) );
			} elseif ( is_numeric( $acf_icon ) ) {
				$icon_html = wp_get_attachment_image( $acf_icon, 'thumbnail', false, array( 'style' => 'width: 20px; height: auto; display: block;' ) );
			} else {
				$icon_html = '<img src="' . esc_url( $acf_icon ) . '" style="width: 20px; height: auto; display: block;" alt="" />';
			}
		}
	}

	// Fallback to term meta thumbnail.
	if ( ! $icon_html ) {
		$thumbnail_id = get_term_meta( $current_term->term_id, 'thumbnail_id', true );
		if ( $thumbnail_id ) {
			$icon_html = wp_get_attachment_image( $thumbnail_id, 'thumbnail', false, array( 'style' => 'width: 20px; height: auto; display: block;' ) );
		}
	}
}

if ( ! $icon_html ) {
	$icon_html = '<span style="display:block; width:20px; height:20px; background-color: #E5E5E5; border-radius: 50%;"></span>';
}
?>
<div <?php echo $wrapper_attributes; ?>>
	<style>
		.lemon-concentrate-breadcrumbs .last {
			color: #000;
			font-weight: 500;
		}
		.lemon-concentrate-breadcrumbs .separator {
			color: #888;}
	</style>
	<span class="lemon-concentrate-breadcrumbs-icon" aria-hidden="true">
		<?php echo $icon_html; ?>
	</span>
	<?php
	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		rank_math_the_breadcrumbs();
	} else {
		echo esc_html__( 'Please install and activate Rank Math SEO.', 'lemon-concentrate' );
	}
	?>
</div>