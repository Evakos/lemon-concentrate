<?php
/**
 * Category Button Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$button_style  = get_field( 'button_style' ) ?: 'dark';
$remove_shadow = get_field( 'remove_box_shadow' );
$hide_icon     = get_field( 'hide_icon' );

$classes = 'lemon-category-button wp-block-button';
$classes .= ' is-style-' . esc_attr( $button_style );
if ( $remove_shadow ) {
	$classes .= ' no-shadow';
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $classes ) );

// Determine the current category URL and Name
$term = get_queried_object();
$url  = '';
$name = '';

if ( $term instanceof WP_Term ) {
	$url  = get_term_link( $term );
	$name = $term->name;
} elseif ( is_singular( 'lemon_product' ) ) {
	$terms = get_the_terms( get_the_ID(), 'product_category' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		// Find the most specific category (deepest child)
		$term = $terms[0];
		foreach ( $terms as $t ) {
			if ( $t->parent !== 0 && ( $term->parent === 0 || $t->parent === $term->term_id ) ) {
				$term = $t;
			}
		}
		$url  = get_term_link( $term );
		$name = $term->name;
	}
}

// Get Label Format from ACF (default: "Related Products")
$label_format = get_field( 'label_format' );
if ( ! $label_format || strpos( $label_format, '%s' ) !== false ) {
	$label = 'Related Products';
} else {
	$label = $label_format;
}

// Icon: Link/Chain (representing "Related")
$icon = '';
if ( ! $hide_icon ) {
	$icon = '<svg width="20" height="20" viewBox="0 0 2443 2443" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left:8px;"><path d="M2228.59 214.409C2038.9 24.7172 1730.22 24.7172 1540.53 214.409L1214.03 540.909C1186 568.931 1186 614.486 1214.03 642.509C1242.05 670.531 1287.6 670.531 1315.63 642.509L1642.13 316.009C1775.77 182.363 1993.2 182.363 2126.85 316.009C2191.66 380.82 2227.3 466.9 2227.3 558.441C2227.3 649.981 2191.66 736.061 2126.85 800.873L1587.09 1340.63C1453.44 1474.28 1236.01 1474.28 1102.37 1340.63C1091.01 1329.28 1081.1 1317.93 1072.33 1306.29C1048.48 1274.53 1003.5 1268.06 971.739 1291.92C939.98 1315.77 933.513 1360.75 957.369 1392.51C970.302 1409.61 984.385 1425.99 1000.62 1442.23C1095.47 1537.08 1220.06 1584.5 1344.66 1584.5C1469.25 1584.5 1593.84 1537.08 1688.69 1442.23L2228.45 902.473C2320.42 810.501 2371 688.351 2371 558.441C2371 428.531 2320.42 306.381 2228.45 214.409H2228.59Z" fill="currentColor"/><path d="M1127.23 1800.49L800.729 2126.99C667.083 2260.64 449.656 2260.64 316.009 2126.99C251.198 2062.18 215.559 1976.1 215.559 1884.56C215.559 1793.02 251.198 1706.94 316.009 1642.13L855.768 1102.37C920.436 1037.7 1006.52 1002.06 1098.06 1001.92C1189.6 1001.92 1275.68 1037.56 1340.49 1102.37C1351.84 1113.86 1361.76 1125.07 1370.52 1136.71C1394.38 1168.47 1439.36 1174.94 1471.12 1151.08C1502.88 1127.23 1509.34 1082.25 1485.49 1050.49C1472.55 1033.39 1458.47 1017.15 1442.09 1000.77C1350.26 908.94 1228.11 858.355 1098.06 858.355C968.147 858.355 845.996 908.94 754.168 1000.77L214.409 1540.67C122.437 1632.64 71.8529 1754.79 71.8529 1884.7C71.8529 2014.61 122.437 2136.76 214.409 2228.73C309.255 2323.58 433.848 2371 558.441 2371C683.034 2371 807.627 2323.58 902.473 2228.73L1228.97 1902.24C1257 1874.21 1257 1828.66 1228.97 1800.64C1200.95 1772.61 1155.4 1772.61 1127.37 1800.64L1127.23 1800.49Z" fill="currentColor"/></svg>';
}
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( $url ) : ?>
		<a class="wp-block-button__link" href="<?php echo esc_url( $url ); ?>">
			<?php echo esc_html( $label ); ?>
			<?php echo $icon; ?>
		</a>
	<?php elseif ( $is_preview ) : ?>
		<a class="wp-block-button__link" href="#">Related Products <?php echo $icon; ?></a>
	<?php endif; ?>
</div>
<style>
	.lemon-category-button.is-style-light .wp-block-button__link {
		background-color: var(--wp--preset--color--base, #FFFDF2) !important;
		color: var(--wp--preset--color--primary, #000000) !important;
		border: none !important;
		padding-top: var(--wp--preset--spacing--40) !important;
		padding-bottom: var(--wp--preset--spacing--40) !important;
		transition: all 0.3s ease;
	}
	.lemon-category-button.is-style-light .wp-block-button__link:hover {
		background-color: var(--wp--preset--color--primary, #000000) !important;
		color: var(--wp--preset--color--base, #FFFDF2) !important;
	}
	.lemon-category-button.is-style-dark .wp-block-button__link {
		background-color: var(--wp--preset--color--primary, #000000) !important;
		color: var(--wp--preset--color--base, #FFFDF2) !important;
		border: none !important;
		padding-top: var(--wp--preset--spacing--40) !important;
		padding-bottom: var(--wp--preset--spacing--40) !important;
		transition: all 0.3s ease;
	}
	.lemon-category-button.is-style-dark .wp-block-button__link:hover {
		background-color: var(--wp--preset--color--base, #FFFDF2) !important;
		color: var(--wp--preset--color--primary, #000000) !important;
	}
	.lemon-category-button.no-shadow .wp-block-button__link {
		box-shadow: none !important;
	}
</style>