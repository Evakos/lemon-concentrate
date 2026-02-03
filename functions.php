<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lemon-concentrate
 * @since 1.0.0
 */

/**
 * The theme version.
 *
 * @since 1.0.0
 */
define( 'LEMON_CONCENTRATE_VERSION', wp_get_theme()->get( 'Version' ) );

/**
 * Add theme support for block styles and editor style.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lemon_concentrate_setup() {
	add_editor_style( './assets/css/style-shared.min.css' );

	/*
	 * Load additional block styles.
	 * See details on how to add more styles in the readme.txt.
	 */
	$styled_blocks = [ 'button', 'quote', 'navigation', 'search' ];
	foreach ( $styled_blocks as $block_name ) {
		$args = array(
			'handle' => "lemon-concentrate-$block_name",
			'src'    => get_theme_file_uri( "assets/css/blocks/$block_name.min.css" ),
			'path'   => get_theme_file_path( "assets/css/blocks/$block_name.min.css" ),
		);
		// Replace the "core" prefix if you are styling blocks from plugins.
		wp_enqueue_block_style( "core/$block_name", $args );
	}

}
add_action( 'after_setup_theme', 'lemon_concentrate_setup' );

/**
 * Enqueue the CSS files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lemon_concentrate_styles() {
	wp_enqueue_style(
		'lemon-concentrate-style',
		get_stylesheet_uri(),
		[],
		LEMON_CONCENTRATE_VERSION
	);
	wp_enqueue_style(
		'lemon-concentrate-shared-styles',
		get_theme_file_uri( 'assets/css/style-shared.min.css' ),
		[],
		LEMON_CONCENTRATE_VERSION
	);
	wp_enqueue_script(
		'lemon-concentrate-sticky-header',
		get_theme_file_uri( 'assets/js/sticky-header.js' ),
		[],
		LEMON_CONCENTRATE_VERSION,
		true
	);
	wp_enqueue_script(
		'lemon-concentrate-cursor',
		get_theme_file_uri( 'assets/js/cursor.js' ),
		[],
		LEMON_CONCENTRATE_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'lemon_concentrate_styles' );

// Filters.
require_once get_theme_file_path( 'inc/filters.php' );

// Block variation example.
require_once get_theme_file_path( 'inc/register-block-variations.php' );

// Block style examples.
require_once get_theme_file_path( 'inc/register-block-styles.php' );

// Block pattern and block category examples.
require_once get_theme_file_path( 'inc/register-block-patterns.php' );

// Category Icons and Colors helper.
require_once get_theme_file_path( 'inc/blocks/breadcrumbs/category-icons.php' );



/**
 * Register Custom Blocks.
 *
 * @since 1.0.0
 * @return void
 */
function lemon_concentrate_register_blocks() {
	register_block_type( get_theme_file_path( 'inc/blocks/ticker' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/breadcrumbs' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/product-category-loop' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/faq' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/product-section' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/contact' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/testimonials' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/product-slider' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/mobile-menu' ) );
}
add_action( 'init', 'lemon_concentrate_register_blocks' );

/**
 * Register custom block category.
 *
 * @param array $categories Block categories.
 * @return array
 */
function lemon_concentrate_block_categories( $categories ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'lemon-concentrate',
				'title' => __( 'Lemon Concentrate', 'lemon-concentrate' ),
			),
		)
	);
}
add_filter( 'block_categories_all', 'lemon_concentrate_block_categories' );

/**
 * Allow SVG uploads.
 *
 * @param array $mimes Allowed mime types.
 * @return array
 */
function lemon_concentrate_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'lemon_concentrate_mime_types' );

/**
 * Programmatically add Lorem Ipsum to all product category descriptions.
 *
 * Usage: Visit your site with ?fill_descriptions=1
 */
function lemon_concentrate_fill_descriptions() {
	if ( isset( $_GET['fill_descriptions'] ) && current_user_can( 'manage_options' ) ) {
		$categories = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		) );

		$lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $category ) {
				wp_update_term( $category->term_id, 'product_cat', array(
					'description' => $lorem,
				) );
			}
			wp_die( 'Product category descriptions updated with Lorem Ipsum.' );
		}
	}
}
add_action( 'init', 'lemon_concentrate_fill_descriptions' );

/**
 * Define ACF JSON save point.
 *
 * @param string $path The path to save the JSON file.
 * @return string
 */
function lemon_concentrate_acf_json_save_point( $path ) {
	return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'lemon_concentrate_acf_json_save_point' );

/**
 * Define ACF JSON load point.
 *
 * @param array $paths The paths to load the JSON files from.
 * @return array
 */
function lemon_concentrate_acf_json_load_point( $paths ) {
	// Append our new path.
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'lemon_concentrate_acf_json_load_point' );

/**
 * Programmatically set colors based on product category.
 *
 * @param string $block_content The block content.
 * @param array  $block         The block data.
 * @return string
 */
function lemon_concentrate_apply_product_colors( $block_content, $block ) {
	$is_product_page  = function_exists( 'is_product' ) && is_product();
	$is_category_page = function_exists( 'is_product_category' ) && is_product_category();

	if ( ! $is_product_page && ! $is_category_page ) {
		return $block_content;
	}

	$category = null;
	if ( $is_product_page ) {
		// Get current product category on single product pages.
		$terms = get_the_terms( get_the_ID(), 'product_cat' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$category = $terms[0];
		}
	} elseif ( $is_category_page ) {
		// Get current category on product category archives.
		$category = get_queried_object();
	}

	if ( ! $category ) {
		return $block_content;
	}

	$color = lemon_concentrate_get_category_color( $category->slug );

	if ( $color ) {
		// Handle Cover Block Overlay.
		if ( 'core/cover' === $block['blockName'] ) {
			$processor = new WP_HTML_Tag_Processor( $block_content );
			// Target the wrapper div to apply background color.
			if ( $processor->next_tag( array( 'class_name' => 'wp-block-cover' ) ) ) {
				$style = $processor->get_attribute( 'style' );
				$style = $style ? $style . ';' : '';
				$processor->set_attribute( 'style', $style . "background-color: $color !important;" );
				$block_content = $processor->get_updated_html();
			}
		}

		// Handle 'product-colour' class.
		if ( false !== strpos( $block_content, 'product-colour' ) ) {
			$processor = new WP_HTML_Tag_Processor( $block_content );
			while ( $processor->next_tag( array( 'class_name' => 'product-colour' ) ) ) {
				$style = $processor->get_attribute( 'style' );
				$classes = $processor->get_attribute( 'class' );

				// If the block has a background, apply the color to the background.
				$has_background = $classes && strpos( $classes, 'has-background' ) !== false;
				$css_prop       = $has_background ? 'background-color' : 'color';
				$css_rule       = "$css_prop: $color !important;";

				if ( ! $style || false === strpos( $style, $css_rule ) ) {
					$style = $style ? rtrim( $style, ';' ) . ';' : '';
					$processor->set_attribute( 'style', $style . $css_rule );
				}
			}
			$block_content = $processor->get_updated_html();
		}
	}

	return $block_content;
}
add_filter( 'render_block', 'lemon_concentrate_apply_product_colors', 10, 2 );

/**
 * Force search blocks to search for products (WooCommerce).
 *
 * @param string $block_content The block content.
 * @param array  $block         The block data.
 * @return string
 */
function lemon_concentrate_force_product_search( $block_content, $block ) {
	if ( 'core/search' === $block['blockName'] ) {
		$processor = new WP_HTML_Tag_Processor( $block_content );
		if ( $processor->next_tag( 'form' ) ) {
			$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
			$processor->set_attribute( 'action', $shop_url );
			$block_content = $processor->get_updated_html();
		}

		$block_content = str_replace(
			'</form>',
			'<input type="hidden" name="post_type" value="product"></form>',
			$block_content
		);
	}
	return $block_content;
}
add_filter( 'render_block', 'lemon_concentrate_force_product_search', 10, 2 );

/**
 * Apply ACF hero image to Cover block on product pages.
 *
 * @param string $block_content The block content.
 * @param array  $block         The block data.
 * @return string
 */
function lemon_concentrate_apply_product_hero_image( $block_content, $block ) {
	if ( ! function_exists( 'is_product' ) || ! is_product() || 'core/cover' !== $block['blockName'] ) {
		return $block_content;
	}

	if ( ! function_exists( 'get_field' ) ) {
		return $block_content;
	}

	$hero_image = get_field( 'hero_image', get_the_ID() );


	if ( ! $hero_image ) {
		return $block_content;
	}

	$image_url = '';
	$image_alt = '';

	if ( is_array( $hero_image ) ) {
		$image_url = $hero_image['url'];
		$image_alt = $hero_image['alt'];
	} elseif ( is_numeric( $hero_image ) ) {
		$image_url = wp_get_attachment_image_url( $hero_image, 'full' );
		$image_alt = get_post_meta( $hero_image, '_wp_attachment_image_alt', true );
	} else {
		$image_url = $hero_image;
	}

	if ( $image_url ) {
		$image_url = trim( $image_url );
		$processor = new WP_HTML_Tag_Processor( $block_content );
		if ( $processor->next_tag( array( 'class_name' => 'wp-block-cover__image-background' ) ) ) {
			$processor->set_attribute( 'src', $image_url );
			$processor->remove_attribute( 'srcset' );
			$processor->set_attribute( 'alt', $image_alt );
			$block_content = $processor->get_updated_html();
		} else {
			// Fallback: If no image tag exists (e.g. solid color cover), apply as background image on wrapper.
			$processor = new WP_HTML_Tag_Processor( $block_content );
			if ( $processor->next_tag( array( 'class_name' => 'wp-block-cover' ) ) ) {
				$style = $processor->get_attribute( 'style' );
				$style = $style ? rtrim( $style, ';' ) . ';' : '';
				$processor->set_attribute( 'style', $style . "background-image:url('" . esc_url( $image_url ) . "'); background-position: center; background-size: cover; background-repeat: no-repeat;" );
				$block_content = $processor->get_updated_html();
			}
		}
	}

	return $block_content;
}
add_filter( 'render_block', 'lemon_concentrate_apply_product_hero_image', 10, 2 );
