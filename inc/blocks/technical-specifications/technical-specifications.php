<?php
/**
 * Technical Specifications Block Template.
 */

$post_id = get_the_ID();

// Retrieve fields
$title          = get_field( 'title' );
$intro          = get_field( 'introduction' );
$columns        = get_field( 'data_columns' );
$transparent_bg = get_field( 'transparent_background' );

// Check Product Data
$product_specs = get_field( 'technical_specifications', $post_id );

if ( ! empty( $product_specs['hide_section'] ) && ! $is_preview ) {
	return;
}

if ( empty( $columns ) ) {
	if ( $product_specs ) {
		if ( empty( $title ) && ! empty( $product_specs['title'] ) ) {
			$title = $product_specs['title'];
		}
		if ( empty( $intro ) && ! empty( $product_specs['introduction'] ) ) {
			$intro = $product_specs['introduction'];
		}
		if ( ! empty( $product_specs['data_columns'] ) ) {
			$columns = $product_specs['data_columns'];
		}
	}
}

if ( empty( $title ) ) {
	$title = 'Technical Specifications Overview';
}

// Fallback for columns if empty (ensures grid layout is preserved)
if ( empty( $columns ) ) {
	$columns = array(
		array(
			'column_title' => 'Key analytical parameters',
			'items' => array(
				array( 'icon' => 'droplet', 'text' => 'Soluble solids: ºBrix 08–16' ),
				array( 'icon' => 'droplet', 'text' => 'pH range: 2.5–4.2' ),
				array( 'icon' => 'droplet', 'text' => 'Titratable acidity: 0.4–1.5 % as citric acid w/w' ),
			),
		),
		array(
			'column_title' => 'Appearance and sensory',
			'items' => array(
				array( 'icon' => 'tag', 'text' => 'Visual aspect: Characteristic orange cells with defined structure' ),
				array( 'icon' => 'material', 'text' => 'Texture: Uniform orange pulp fiber content' ),
			),
		),
		array(
			'column_title' => 'Supply formats',
			'items' => array(
				array( 'icon' => 'dimensions', 'text' => 'Packaging format: Aseptic bulk packaging' ),
				array( 'icon' => 'temperature', 'text' => 'Storage options: Refrigerated or Frozen' ),
			),
		),
	);
}

// Background Color Logic
$style_attr = '';
$color      = '';

// 1. Check Product Override
if ( function_exists( 'get_field' ) ) {
	$color = get_field( 'product_color_override', $post_id );
}

// 2. Check Category if no override
if ( ! $color && function_exists( 'lemon_concentrate_get_category_color' ) ) {
	$category = null;
	$terms    = get_the_terms( $post_id, 'product_category' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$category = $terms[0];
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
	// Darken the color slightly (20%)
	if ( function_exists( 'lemon_concentrate_darken_color' ) ) {
		$color = lemon_concentrate_darken_color( $color, 20 );
	}

	// Calculate brightness to determine text color
	$hex = ltrim( $color, '#' );
	$r = $g = $b = 0;
	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} elseif ( strlen( $hex ) == 6 ) {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	$brightness = ( $r * 299 + $g * 587 + $b * 114 ) / 1000;
	$text_color = ( $brightness > 128 ) ? '#302F29' : '#FFFFFF';

	$style_attr = "background-color: $color; color: $text_color; padding: 3rem; border-radius: 0; width: 100%; box-sizing: border-box;";
}

$classes = 'technical-specifications-block';
if ( $transparent_bg ) {
	$classes .= ' is-transparent';
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $classes, 'style' => $style_attr ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<div class="tech-specs-inner has-4-columns">
		<div class="tech-specs-col-1">
			<h5 class="tech-specs-label wp-block-heading has-extra-small-font-size" style="font-style:normal;font-weight:400">Sheet</h5>
			<h2 class="tech-specs-title"><?php echo esc_html( $title ); ?></h2>
			<?php if ( $intro ) : ?>
				<div class="tech-specs-description">
					<p><?php echo esc_html( $intro ); ?></p>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $columns ) : ?>
			<?php foreach ( $columns as $col ) : ?>
				<div class="tech-specs-data-col">
					<?php if ( ! empty( $col['column_title'] ) ) : ?>
						<h3 class="tech-specs-subtitle"><?php echo esc_html( $col['column_title'] ); ?></h3>
					<?php endif; ?>
					<?php if ( ! empty( $col['items'] ) ) : ?>
						<ul class="tech-specs-list">
							<?php foreach ( $col['items'] as $item ) : ?>
								<li>
									<?php
									if ( ! empty( $item['icon'] ) ) {
										$icon_value = $item['icon'];
										if ( is_array( $icon_value ) ) {
											$icon_value = $icon_value['value'] ?? '';
										}

										$icon_svg = '';
										switch ( $icon_value ) {
											case 'weight':
												$icon_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="3"></circle><path d="M6.5 8a2 2 0 0 0-1.905 1.46L2.1 18.5A2 2 0 0 0 4 21h16a2 2 0 0 0 1.9-2.5l-2.495-9.04A2 2 0 0 0 17.5 8h-11z"></path></svg>';
												break;
											case 'dimensions':
												$icon_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>';
												break;
											case 'material':
												$icon_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="7.5 4.21 12 6.81 16.5 4.21"></polyline><polyline points="7.5 19.79 7.5 14.6 3 12"></polyline><polyline points="21 12 16.5 14.6 16.5 19.79"></polyline><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>';
												break;
											case 'temperature':
												$icon_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"></path></svg>';
												break;
											case 'warranty':
												$icon_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>';
												break;
											case 'tag':
												$icon_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>';
												break;
											case 'droplet':
												$icon_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>';
												break;
										}
										if ( $icon_svg ) {
											echo '<span class="tech-specs-icon">' . $icon_svg . '</span>';
										}
									}
									?>
									<?php echo esc_html( $item['text'] ); ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<style>
		.technical-specifications-block {
			display: flex;
			min-height: 550px;
			align-items: center;
		}
		.technical-specifications-block h2,
		.technical-specifications-block h3,
		.technical-specifications-block h5,
		.technical-specifications-block p,
		.technical-specifications-block li {
			color: inherit;
		}
		.tech-specs-inner.has-4-columns {
			display: grid;
			grid-template-columns: 2fr 1fr 1fr 1fr;
			gap: 1rem;
		max-width: 1770px;
			width: 100%;
			margin: 0 auto;
			padding: 0;
			box-sizing: border-box;
		}
		.tech-specs-col-1 {
			background-color: transparent;
			padding: 1.5rem 1.5rem 1.5rem 0;
			border-radius: 4px;
			margin-right: 3rem;
			height: 100%;
		}
		.technical-specifications-block.is-transparent .tech-specs-col-1 {
			background-color: transparent;
		}
		.tech-specs-data-col {
			background-color: transparent;
			padding: 1rem;
			border-radius: 5px;
			min-height: 100%;
		}
		.technical-specifications-block.is-transparent .tech-specs-data-col {
			background-color: transparent;
		}
		.tech-specs-subtitle {
			margin-bottom: 1rem;
			font-size: 1.45em;
			font-weight: 500;
			margin-top: 1rem;
			line-height: 1.2;
		}
		.tech-specs-list {
			list-style: none;
			padding: 0;
			margin: 0;
		}
		.tech-specs-list li {
			font-size: 1.125rem;
			margin-bottom: 0.5rem;
			display: flex;
			align-items: flex-start;
			gap: 0.5rem;
		}
		.tech-specs-icon {
			flex-shrink: 0;
			display: inline-flex;
			margin-top: 2px;
		}
		@media (max-width: 1024px) {
			.technical-specifications-block {
				min-height: auto;
			}
			.tech-specs-inner.has-4-columns {
				grid-template-columns: repeat(2, 1fr);
			}
		}
		@media (max-width: 600px) {
			.tech-specs-inner.has-4-columns {
				grid-template-columns: 1fr;
			}
			.tech-specs-col-1 {
				margin-right: 0;
			}
		}
	</style>
</div>