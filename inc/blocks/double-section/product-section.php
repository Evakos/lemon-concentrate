<?php
/**
 * Product Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Retrieve the sections repeater from the current post.
$sections = get_field( 'sections', $post_id );

// Fallback if no sections are found.
if ( empty( $sections ) && ! empty( $is_preview ) ) {
	$sections = array(
		array(
			'title' => 'Industrial Processing',
			'text'  => '<p>Our orange pulp cells are processed using state-of-the-art technology to ensure maximum integrity and flavor retention. Suitable for a wide range of industrial applications including beverages, dairy products, and bakery items.</p>',
			'image' => '', 
			'order' => 1, // Left
		),
		array(
			'title' => 'Quality Assurance',
			'text'  => '<p>We adhere to strict quality control measures throughout the manufacturing process. From fruit selection to final packaging, every step is monitored to guarantee a premium product that meets international standards.</p>',
			'image' => '',
			'order' => 0, // Right
		),
	);
}

if ( empty( $sections ) ) {
	return;
}

// Determine background color from product category
$style_attr = '';
$color = '';

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

if ( $color && 'transparent' !== $color ) {
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

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-product-sections', 'style' => $style_attr ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( ! empty( $sections ) ) : ?>
		<?php foreach ( $sections as $section ) : ?>
			<?php
			$title = isset( $section['title'] ) ? $section['title'] : '';
			$text  = isset( $section['text'] ) ? $section['text'] : '';
			$image = isset( $section['image'] ) ? $section['image'] : ''; // Returns URL string based on ACF config

			if ( empty( $image ) ) {
				$image = get_theme_file_uri( 'assets/images/placeholder.svg' );
			}

			$order = isset( $section['order'] ) ? $section['order'] : false; // True = Left, False = Right
			
			$row_class = $order ? 'image-left' : 'image-right';
			?>
			<div class="lemon-product-section-row <?php echo esc_attr( $row_class ); ?>">
				<div class="lemon-product-section-content">
					<?php if ( $title ) : ?>
						<h2 class="lemon-product-section-title"><?php echo esc_html( $title ); ?></h2>
					<?php endif; ?>
					<div class="lemon-product-section-body"><?php echo wp_kses_post( $text ); ?></div>
				</div>
				<div class="lemon-product-section-image">
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>