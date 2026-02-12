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
	$analytical     = $specs_group['analytical_parameters'] ?? [];
	$appearance     = $specs_group['appearance_sensory'] ?? [];
	$supply         = $specs_group['supply_storage'] ?? [];
	$url_field      = $specs_group['url'];
} else {
	$title          = get_field( 'title', $post_id );
	$description    = get_field( 'introduction', $post_id );
	$analytical     = get_field( 'analytical_parameters', $post_id );
	$appearance     = get_field( 'appearance_sensory', $post_id );
	$supply         = get_field( 'supply_storage', $post_id );
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
if ( empty( $title ) && empty( $analytical ) && empty( $appearance ) && empty( $supply ) && empty( $button ) ) {
	$title          = 'Technical Specifications';
	$description    = 'Detailed information about the product specifications and requirements.';
	
	$analytical = array(
		array( 'text' => 'Soluble solids: ºBrix 08–16', 'icon' => 'droplet' ),
		array( 'text' => 'pH range: 2.5–4.2', 'icon' => 'droplet' ),
		array( 'text' => 'Titratable acidity: 0.4–1.5 % as citric acid w/w', 'icon' => 'droplet' ),
		array( 'text' => 'Organoleptic profile: Colour, flavour and aroma characteristic of the orange range', 'icon' => 'tag' ),
		array( 'text' => 'Physical form: Suspended orange cells and pulp orange phase suitable for blending into liquid matrices', 'icon' => 'material' ),
	);
	$appearance = array(
		array( 'text' => 'Visual aspect: Characteristic orange cells with defined structure', 'icon' => 'tag' ),
		array( 'text' => 'Texture: Uniform orange pulp fiber content supporting mouthfeel and visual pulp level', 'icon' => 'material' ),
		array( 'text' => 'Flavour profile: Typical of orange pulp, aligned with industrial citrus beverage standards', 'icon' => 'tag' ),
	);
	$supply = array(
		array( 'text' => 'Packaging format: Aseptic bulk packaging for integration into industrial processing', 'icon' => 'dimensions' ),
		array( 'text' => 'Storage options: Refrigerated storage at 4–10 °C; Frozen storage at –18 °C', 'icon' => 'temperature' ),
		array( 'text' => 'Handling after opening: Once opened, product should be kept in a cool room and used within 5 days', 'icon' => 'warranty' ),
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

$wrapper_attributes_args = array( 'class' => 'technical-specifications-block has-4-columns' );
if ( $style_attr ) {
	$wrapper_attributes_args['style'] = $style_attr;
}

$wrapper_attributes = get_block_wrapper_attributes( $wrapper_attributes_args );

// Icons map
$icons = array(
	'weight'      => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
	'dimensions'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>',
	'material'    => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>',
	'temperature' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"></path></svg>',
	'warranty'    => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
	'tag'         => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>',
	'droplet'     => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>',
);

// Helper to render list
$render_list = function( $items ) use ( $icons ) {
	if ( empty( $items ) ) return;
	echo '<ul class="tech-specs-list">';
	if ( is_array( $items ) ) {
		foreach ( $items as $item ) {
			$text = isset( $item['text'] ) ? $item['text'] : '';
			$icon = isset( $item['icon'] ) ? $item['icon'] : '';
			
			if ( ! empty( $text ) ) {
				echo '<li style="display: flex; align-items: flex-start; margin-bottom: 1rem; line-height: 1.2;">';
				if ( ! empty( $icon ) ) {
					if ( isset( $icons[ $icon ] ) ) {
						echo '<span style="margin-right: 10px; display: flex; align-items: center; margin-top: 2px;">' . $icons[ $icon ] . '</span>';
					} elseif ( is_array( $icon ) ) {
						echo wp_get_attachment_image( $icon['ID'], 'thumbnail', false, array( 'style' => 'width: 20px; height: 20px; object-fit: contain; margin-right: 10px; margin-top: 2px;' ) );
					} elseif ( is_numeric( $icon ) ) {
						echo wp_get_attachment_image( $icon, 'thumbnail', false, array( 'style' => 'width: 20px; height: 20px; object-fit: contain; margin-right: 10px; margin-top: 2px;' ) );
					} else {
						echo '<img src="' . esc_url( $icon ) . '" style="width: 20px; height: 20px; object-fit: contain; margin-right: 10px; margin-top: 2px;" alt="" />';
					}
				}
				echo '<span>' . esc_html( $text ) . '</span>';
				echo '</li>';
			}
		}
	} else {
		$lines = explode( "\n", $items );
		foreach ( $lines as $line ) {
			echo '<li style="line-height: 1.2;">' . esc_html( $line ) . '</li>';
		}
	}
	echo '</ul>';
};
?>
<div <?php echo $wrapper_attributes; ?>>
	<div class="tech-specs-col-1">
		<h5 class="tech-specs-label wp-block-heading has-extra-small-font-size" style="font-style:normal;font-weight:400">Sheet</h5>
		<?php if ( $title ) : ?>
			<h2 class="tech-specs-title"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>
		<?php if ( $description ) : ?>
			<div class="tech-specs-description">
				<?php echo wp_kses_post( wpautop( $description ) ); ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="tech-specs-col-2">
		<h3 class="tech-specs-subtitle">Key analytical parameters</h3>
		<?php $render_list( $analytical ); ?>
	</div>

	<div class="tech-specs-col-3">
		<h3 class="tech-specs-subtitle">Appearance and sensory</h3>
		<?php $render_list( $appearance ); ?>
	</div>

	<div class="tech-specs-col-4">
		<h3 class="tech-specs-subtitle">Supply formats and storage</h3>
		<?php $render_list( $supply ); ?>
		
		<?php if ( ! empty( $button ) && ! empty( $button['url'] ) ) : ?>
			<div class="tech-specs-button-wrapper" style="margin-top: 2rem;">
				<a class="wp-block-button__link lemon-product-button" href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button['target'] ?? '_self' ); ?>" style="<?php echo esc_attr( $button_style_attr ); ?>">
					<i class="fa fa-file-pdf" aria-hidden="true" style="margin-right: 0.5em;"></i>
					<?php echo esc_html( $button['title'] ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
	<style>
		.technical-specifications-block.has-4-columns {
			display: grid;
			grid-template-columns: 2fr 1fr 1fr 1fr;
			gap: 0.5rem;
		}
		.tech-specs-col-1 {
			background-color: rgba(0, 0, 0, 0.03);
			padding: 1.5rem;
			border-radius: 4px;
			margin-right: 2rem;
			height: 100%;
		}
		.tech-specs-col-2,
		.tech-specs-col-3,
		.tech-specs-col-4 {
			background-color: #ffffff69;
    padding: 1.5rem;
    border-radius: 5px;
    min-height: 100%;
		}
		.tech-specs-subtitle {
    margin-bottom: 1rem;
    font-size: 0.9em;
    font-weight: 500;
    margin-top: 1rem;
    line-height: 1.2;
}
		@media (max-width: 1024px) {
			.technical-specifications-block.has-4-columns {
				grid-template-columns: repeat(2, 1fr);
			}
		}
		@media (max-width: 600px) {
			.technical-specifications-block.has-4-columns {
				grid-template-columns: 1fr;
			}
			.tech-specs-col-1 {
				margin-right: 0;
			}
		}
	</style>
</div>