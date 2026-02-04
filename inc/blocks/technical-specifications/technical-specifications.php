<?php
/**
 * Technical Specifications Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$title          = get_field( 'title' );
$description    = get_field( 'description' );
$specifications = get_field( 'specifications' );
$button         = get_field( 'button' );

// Fallback for preview
if ( empty( $title ) && empty( $specifications ) ) {
	$title          = 'Technical Specifications';
	$description    = 'Detailed information about the product specifications and requirements.';
	$specifications = array(
		array( 'text' => 'Weight: 1.5kg' ),
		array( 'text' => 'Dimensions: 20x30x5cm' ),
		array( 'text' => 'Material: Aluminum' ),
		array( 'text' => 'Warranty: 2 Years' ),
	);
	$button         = array(
		'url'   => '#',
		'title' => 'Download PDF',
	);
}

// Determine background color from product category
$style_attr = '';
$button_style_attr = '';
if ( function_exists( 'lemon_concentrate_get_category_color' ) ) {
	$category = null;
	
	// Try to get terms from the current post (works in backend editor too).
	$terms = get_the_terms( $post_id, 'product_cat' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$category = $terms[0];
	} elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
		$category = get_queried_object();
	}

	if ( $category ) {
		$color = lemon_concentrate_get_category_color( $category->slug );
		if ( $color && 'transparent' !== $color ) {
			$button_style_attr = 'background-color: ' . $color . '; border-color: ' . $color . '; color: #fff;';

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
				$style_attr = "background-color: rgba($r, $g, $b, 0.1);";
			}
		}
	}
}

$wrapper_attributes_args = array( 'class' => 'technical-specifications-block' );
if ( $style_attr ) {
	$wrapper_attributes_args['style'] = $style_attr;
}

$wrapper_attributes = get_block_wrapper_attributes( $wrapper_attributes_args );
?>
<div <?php echo $wrapper_attributes; ?>>
	<div class="tech-specs-col-left">
		<h5 class="tech-specs-label wp-block-heading has-extra-small-font-size" style="font-style:normal;font-weight:400">Sheet</h5>
		<?php if ( $title ) : ?>
			<h3 class="tech-specs-title"><?php echo esc_html( $title ); ?></h3>
		<?php endif; ?>
		<?php if ( $description ) : ?>
			<div class="tech-specs-description">
				<?php echo wp_kses_post( wpautop( $description ) ); ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="tech-specs-col-center">
		<?php if ( $specifications ) : ?>
			<ul class="tech-specs-list">
				<?php foreach ( $specifications as $item ) : ?>
					<?php if ( ! empty( $item['text'] ) ) : ?>
						<li><?php echo esc_html( $item['text'] ); ?></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<div class="tech-specs-col-right">
		<?php if ( $button ) : ?>
			<div class="tech-specs-button-wrapper">
				<a class="wp-block-button__link" href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button['target'] ?? '_self' ); ?>" style="<?php echo esc_attr( $button_style_attr ); ?>">
					<i class="fa fa-file-pdf" aria-hidden="true" style="margin-right: 0.5em;"></i>
					<?php echo esc_html( $button['title'] ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>