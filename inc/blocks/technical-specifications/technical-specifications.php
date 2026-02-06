<?php
/**
 * Technical Specifications Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Check for Group field first (from new export structure)
$specs_group = get_field( 'technical_specifications', $post_id );

if ( $specs_group ) {
	$title          = $specs_group['title'];
	$description    = $specs_group['introduction'];
	$specifications = $specs_group['list'];
	$url_field      = $specs_group['url'];
} else {
	$title          = get_field( 'title', $post_id );
	$description    = get_field( 'introduction', $post_id );
	$specifications = get_field( 'list', $post_id );
	$url_field      = get_field( 'url', $post_id );
}

$button = $url_field;
if ( $url_field && ! is_array( $url_field ) ) {
	$button = array(
		'url'   => $url_field,
		'title' => 'Download PDF',
	);
}

// Fallback for preview
if ( empty( $title ) && empty( $specifications ) && empty( $button ) ) {
	$title          = 'Technical Specifications';
	$description    = 'Detailed information about the product specifications and requirements.';
	$specifications = array(
		array( 'text' => 'Product: ' . get_the_title( $post_id ), 'icon' => 'tag' ),
		array( 'text' => 'Brix (°Bx): 69.0 – 71.0', 'icon' => 'droplet' ),
		array( 'text' => 'Acidity (as malic acid): 1.6 – 2.4 g/100 mL', 'icon' => 'droplet' ),
		array( 'text' => 'Formats: aseptic drums, frozen drums, IBC containers, flexitanks, Bag-in-Box', 'icon' => 'material' ),
		array( 'text' => 'Storage: frozen at –18 ºC for frozen formats, ambient for aseptic formats', 'icon' => 'temperature' ),
		array( 'text' => 'MOQ: 5–10 MT per reference', 'icon' => 'weight' ),
	);
}

// Determine background color from product category
$style_attr = '';
$button_style_attr = 'font-size: small;';
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
		if ( $color && 'transparent' !== $color ) {
			// Color found.
		}
	}
}

if ( $color && 'transparent' !== $color ) {
	// Darken the color slightly (15%) as requested.
	if ( function_exists( 'lemon_concentrate_darken_color' ) ) {
		$color = lemon_concentrate_darken_color( $color, 15 );
	}

	$button_style_attr = 'background-color: ' . $color . '; border-color: ' . $color . '; color: #fff; font-size: small;';

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
				<?php if ( is_array( $specifications ) ) : ?>
					<?php foreach ( $specifications as $item ) : ?>
						<?php
						$text = isset( $item['text'] ) ? $item['text'] : '';
						$icon = isset( $item['icon'] ) ? $item['icon'] : '';

						$icons = array(
							'weight'      => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
							'dimensions'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>',
							'material'    => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>',
							'temperature' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"></path></svg>',
							'warranty'    => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
							'tag'         => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>',
							'droplet'     => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>',
						);
						?>
						<?php if ( ! empty( $text ) ) : ?>
							<li style="display: flex; align-items: center; margin-bottom: 0.5em;">
								<?php if ( ! empty( $icon ) ) : ?>
									<?php
									if ( isset( $icons[ $icon ] ) ) {
										echo '<span style="margin-right: 10px; display: flex; align-items: center;">' . $icons[ $icon ] . '</span>';
									} elseif ( is_array( $icon ) ) {
										echo wp_get_attachment_image( $icon['ID'], 'thumbnail', false, array( 'style' => 'width: 20px; height: 20px; object-fit: contain; margin-right: 10px;' ) );
									} elseif ( is_numeric( $icon ) ) {
										echo wp_get_attachment_image( $icon, 'thumbnail', false, array( 'style' => 'width: 20px; height: 20px; object-fit: contain; margin-right: 10px;' ) );
									} else {
										echo '<img src="' . esc_url( $icon ) . '" style="width: 20px; height: 20px; object-fit: contain; margin-right: 10px;" alt="" />';
									}
									?>
								<?php endif; ?>
								<?php echo esc_html( $text ); ?>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php else : ?>
					<?php // If it's a text field, split by newlines ?>
					<?php $lines = explode( "\n", $specifications ); ?>
					<?php foreach ( $lines as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
	</div>

	<div class="tech-specs-col-right">
		<?php if ( ! empty( $button ) && ! empty( $button['url'] ) ) : ?>
			<div class="tech-specs-button-wrapper">
				<a class="wp-block-button__link lemon-product-button" href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button['target'] ?? '_self' ); ?>" style="<?php echo esc_attr( $button_style_attr ); ?>">
					<i class="fa fa-file-pdf" aria-hidden="true" style="margin-right: 0.5em;"></i>
					<?php echo esc_html( $button['title'] ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>