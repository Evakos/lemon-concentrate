<?php
/**
 * Double Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Retrieve the sections repeater from the current post.
$sections = get_field( 'double_sections', $post_id );

// Fallback if no sections are found.
if ( empty( $sections ) && ! empty( $is_preview ) ) {
	$product_title = get_the_title( $post_id );
	$sections = array(
		array(
			'title_left'  => sprintf( 'Why Choose LemonConcentrate for %s Supply', $product_title ),
			'text_left'   => '<p>LemonConcentrate competes directly with major global producers thanks to its large-scale processing capacity, consistent quality and competitive pricing. Our operations offer full traceability, strict adherence to food-safety regulations, flexible packaging options and the logistical capacity to ship worldwide. We also provide technical support for custom specifications, including adjusted Brix levels, acidity modification and bespoke blends tailored to industrial requirements.</p>',
			'title_right' => sprintf( 'Ordering, Documentation and Vendor Approval for %s', $product_title ),
			'text_right'  => '<p>To support procurement, QA onboarding and repeatable supply, we can provide documentation commonly required in industrial purchasing processes, such as:</p><ul><li>Specification sheet reflecting the commercial and analytical parameters agreed</li><li>Certificate of Analysis per batch on request</li><li>Traceability information and export documentation aligned with destination-market requirements</li><li>Packaging and storage guidance for frozen and aseptic handling</li></ul><p>Lead time, Incoterms, sampling and contract supply planning can be discussed based on format, volume and destination.</p>',
		),
	);
}

if ( empty( $sections ) ) {
	return;
}

// Determine background color from product category
$style_attr = '';
$color = '';
$transparent_bg = get_field( 'double_section_transparent_bg' );

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

$wrapper_attributes_args = array( 'class' => 'lemon-double-sections' );
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
		<?php foreach ( $sections as $section ) : ?>
			<?php
			$product_title = get_the_title( $post_id );
			$title_left    = str_replace( '%s', $product_title, $section['title_left'] );
			$title_right   = str_replace( '%s', $product_title, $section['title_right'] );
			?>
			<div class="lemon-double-section-row">
				<div class="lemon-double-section-col-left">
					<h3 class="lemon-double-section-title"><?php echo esc_html( $title_left ); ?></h3>
					<div class="lemon-double-section-body"><?php echo wp_kses_post( $section['text_left'] ); ?></div>
				</div>
				<div class="lemon-double-section-col-right">
					<h3 class="lemon-double-section-title"><?php echo esc_html( $title_right ); ?></h3>
					<div class="lemon-double-section-body"><?php echo wp_kses_post( $section['text_right'] ); ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<style>
	.lemon-double-section-body ul li {
		font-size: 1.125rem;
		margin-bottom: 0.5rem;
	}
</style>
