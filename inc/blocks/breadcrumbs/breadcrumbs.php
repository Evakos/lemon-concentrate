<?php
/**
 * Render callback for the Breadcrumbs block.
 *
 * @package lemon-concentrate
 */

// Category Icons.
require_once get_theme_file_path( 'inc/blocks/breadcrumbs/category-icons.php' );

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-concentrate-breadcrumbs' ) );

// Determine the icon based on category.
$icon_html    = '';
$current_term = null;

if ( function_exists( 'is_product_category' ) && is_product_category() ) {
	$current_term = get_queried_object();
} elseif ( function_exists( 'is_product' ) && is_product() ) {
	$terms = get_the_terms( get_the_ID(), 'product_cat' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$current_term = $terms[0];
	}
}

if ( $current_term ) {
	$thumbnail_id = get_term_meta( $current_term->term_id, 'thumbnail_id', true );
	if ( $thumbnail_id ) {
		$icon_html = wp_get_attachment_image( $thumbnail_id, 'thumbnail', false, array( 'style' => 'width: 20px; height: auto; display: block;' ) );
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