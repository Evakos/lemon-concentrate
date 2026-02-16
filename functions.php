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
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( './assets/css/style-shared.min.css' );
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'lemon-concentrate' ),
	) );

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
	wp_enqueue_style(
		'lemon-concentrate-filter-modal',
		get_theme_file_uri( 'assets/css/filter-modal.css' ),
		[],
		LEMON_CONCENTRATE_VERSION
	);
	wp_enqueue_script(
		'lemon-concentrate-filter-modal',
		get_theme_file_uri( 'assets/js/filter-modal.js' ),
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
require_once get_theme_file_path( 'inc/blocks/mega-menu/category-icons.php' );

// Category Colors helper.
require_once get_theme_file_path( 'inc/category-colors.php' );

// Migration script.
require_once get_theme_file_path( 'inc/migration.php' );

// ACF Fields.
require_once get_theme_file_path( 'inc/acf-fields.php' );



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
	register_block_type( get_theme_file_path( 'inc/blocks/double-section' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/mirror-section' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/contact' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/testimonials' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/product-slider' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/mobile-menu' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/technical-specifications' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/mega-menu' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/hero-image' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/simple-menu' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/hero-bullets' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/ajax-search' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/floating-panel' ) );
	register_block_type( get_theme_file_path( 'inc/blocks/category-button' ) );
}
add_action( 'init', 'lemon_concentrate_register_blocks' );

/**
 * Register Mega Menu Block Styles.
 */
function lemon_concentrate_register_mega_menu_styles() {
	register_block_style( 'lemon-concentrate/mega-menu', array(
		'name'  => 'underline',
		'label' => __( 'Underline', 'lemon-concentrate' ),
	) );
}
add_action( 'init', 'lemon_concentrate_register_mega_menu_styles' );

/**
 * Register Custom Post Type and Taxonomy.
 */
function lemon_concentrate_register_cpt() {
	register_post_type( 'lemon_product', array(
		'labels'       => array(
			'name'          => __( 'Lemon Products', 'lemon-concentrate' ),
			'singular_name' => __( 'Product', 'lemon-concentrate' ),
		),
		'public'       => true,
		'show_ui'      => true,
		'menu_position'=> 20,
		'has_archive'  => 'catalogue',
		'rewrite'      => array( 'slug' => 'catalogue', 'with_front' => false ),
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'menu_icon'    => 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9Ii01IC01IDYxIDYxIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cGF0aCBkPSJNNDkuNDQ1NiAxNy4xODczQzQ5LjIyMzYgMTYuNDU1NiA0OS4xNTIgMTUuNjg2NyA0OS4yMzUgMTQuOTI2N0M0OS4zMTggMTQuMTY2NiA0OS41NTM5IDEzLjQzMTMgNDkuOTI4NSAxMi43NjQ4QzUwLjg5MTggMTAuODE2OSA1MS4xMDg4IDguNTgzNzYgNTAuNTM4NSA2LjQ4Njg1QzUwLjExOSA1LjAwMzM4IDQ5LjMyNjQgMy42NTIxMyA0OC4yMzYyIDIuNTYyMDJDNDcuMTQ2MSAxLjQ3MTkxIDQ1Ljc5NDkgMC42NzkyODggNDQuMzExNCAwLjI1OTc3QzQyLjIzNDEgLTAuMjUzNTUyIDQwLjA0MTMgLTAuMDA4ODg4MjE2IDM4LjEzNTIgMC45NzE0MzdDMzcuNDgyMiAxLjMzMjM1IDM2Ljc2NDQgMS41NjA4IDM2LjAyMjkgMS42NDM2N0MzNS4yODE0IDEuNzI2NTQgMzQuNTMwOSAxLjY2MjIgMzMuODE0MyAxLjQ1NDM1QzI4LjQzNTYgLTAuMzg5MjAyIDIyLjU5NiAtMC4zODkyMDIgMTcuMjE3MyAxLjQ1NDM1QzEzLjU0NTMgMi42NzQwNyAxMC4yMDUzIDQuNzI2NjQgNy40NTgzMSA3LjQ1MTU1QzQuNzExMzUgMTAuMTc2NSAyLjYzMTk0IDEzLjQ5OTkgMS4zODI2NyAxNy4xNjE5Qy0wLjQ2MDg4OSAyMi41NDA2IC0wLjQ2MDg4OSAyOC4zODAyIDEuMzgyNjcgMzMuNzU4OUMxLjYwODQzIDM0LjQ4ODkgMS42ODQyOCAzNS4yNTY5IDEuNjA1NjYgMzYuMDE2OUMxLjUyNzA0IDM2Ljc3NjkgMS4yOTU1NyAzNy41MTMyIDAuOTI1MTY3IDM4LjE4MTRDLTAuMDM4MTIzNSA0MC4xMjkzIC0wLjI1NTEwNyA0Mi4zNjI0IDAuMzE1MTY3IDQ0LjQ1OTRDMC43MzQ2ODQgNDUuOTQyOCAxLjUyNzMxIDQ3LjI5NDEgMi42MTc0MiA0OC4zODQyQzMuNzA3NTMgNDkuNDc0MyA1LjA1ODc4IDUwLjI2NjkgNi41NDIyNSA1MC42ODY0QzguNjE5NTkgNTEuMTk5OCAxMC44MTIzIDUwLjk0NzEgMTIuNzE4NSA0OS45NzQ4QzEzLjM3MTUgNDkuNjEzOSAxNC4wODkzIDQ5LjM4NTQgMTQuODMwOCA0OS4zMDI1QzE1LjU3MjIgNDkuMjE5NyAxNi4zMjI4IDQ5LjI4NCAxNy4wMzkzIDQ5LjQ5MTlDMTkuNzM0NCA1MC40MzUxIDIyLjU3MTUgNTAuOTA4IDI1LjQyNjggNTAuODg5OEMyOC4yNTMyIDUwLjg4MzkgMzEuMDU5OSA1MC40MjA0IDMzLjczODEgNDkuNTE3M0MzNy4zOTM5IDQ4LjI4MTYgNDAuNzE1NCA0Ni4yMTkyIDQzLjQ0NDIgNDMuNDkwNUM0Ni4xNzI5IDQwLjc2MTcgNDguMjM1MyAzNy40NDAyIDQ5LjQ3MSAzMy43ODQ0QzUxLjMwNjMgMjguNDAyOCA1MS4yOTc0IDIyLjU2MzIgNDkuNDQ1NiAxNy4xODczWk0yNS40MjY4IDEyLjc2NDhDMjIuMDU2NCAxMi43NjQ4IDE4LjgyNCAxNC4xMDM3IDE2LjQ0MDcgMTYuNDg3QzE0LjA1NzQgMTguODcwMiAxMi43MTg1IDIyLjEwMjYgMTIuNzE4NSAyNS40NzMxSDcuNjM1MTdDNy42MzUxNyAyMC43NTQ1IDkuNTA5NjQgMTYuMjI5MSAxMi44NDYyIDEyLjg5MjVDMTYuMTgyOCA5LjU1NTkxIDIwLjcwODIgNy42ODE0NCAyNS40MjY4IDcuNjgxNDRWMTIuNzY0OFoiIGZpbGw9IiNGNkI1MDEiLz4KPC9zdmc+Cg==',
		'show_in_rest' => true,
	) );

	register_taxonomy( 'product_category', 'lemon_product', array(
		'labels'            => array(
			'name'          => __( 'Product Categories', 'lemon-concentrate' ),
			'singular_name' => __( 'Product Category', 'lemon-concentrate' ),
		),
		'public'            => true,
		'show_in_nav_menus' => true,
		'rewrite'           => array( 'slug' => 'catalogue', 'with_front' => false, 'hierarchical' => false ),
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
	) );
}
add_action( 'init', 'lemon_concentrate_register_cpt' );

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
			'taxonomy'   => 'product_category',
			'hide_empty' => false,
		) );

		$lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $category ) {
				wp_update_term( $category->term_id, 'product_category', array(
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
 * Lighten a hex color.
 *
 * @param string $color   The hex color.
 * @param int    $percent The percentage to lighten.
 * @return string
 */
function lemon_concentrate_lighten_color( $color, $percent ) {
	if ( ! preg_match( '/^#?([a-f0-9]{3}|[a-f0-9]{6})$/i', $color ) ) {
		return $color;
	}

	$hex = ltrim( $color, '#' );

	if ( strlen( $hex ) == 3 ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	$r = min( 255, $r + ( 255 - $r ) * ( $percent / 100 ) );
	$g = min( 255, $g + ( 255 - $g ) * ( $percent / 100 ) );
	$b = min( 255, $b + ( 255 - $b ) * ( $percent / 100 ) );

	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Darken a hex color.
 *
 * @param string $color   The hex color.
 * @param int    $percent The percentage to darken.
 * @return string
 */
function lemon_concentrate_darken_color( $color, $percent ) {
	if ( ! preg_match( '/^#?([a-f0-9]{3}|[a-f0-9]{6})$/i', $color ) ) {
		return $color;
	}

	$hex = ltrim( $color, '#' );

	if ( strlen( $hex ) == 3 ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	$r = max( 0, $r - ( $r * ( $percent / 100 ) ) );
	$g = max( 0, $g - ( $g * ( $percent / 100 ) ) );
	$b = max( 0, $b - ( $b * ( $percent / 100 ) ) );

	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Programmatically set colors based on product category.
 *
 * @param string $block_content The block content.
 * @param array  $block         The block data.
 * @return string
 */
function lemon_concentrate_apply_product_colors( $block_content, $block ) {
	$is_product_page  = is_singular( 'lemon_product' );
	$is_category_page = is_tax( 'product_category' );
	$is_archive_page  = is_post_type_archive( 'lemon_product' ) || ( is_archive() && 'lemon_product' === get_query_var( 'post_type' ) );

	if ( ! $is_product_page && ! $is_category_page && ! $is_archive_page ) {
		return $block_content;
	}

	$color = '';

	if ( $is_product_page ) {
		// Check for product override first.
		if ( function_exists( 'get_field' ) ) {
			$color = get_field( 'product_color_override', get_the_ID() );
		}
	}

	if ( ! $color ) {
		$category = null;
		if ( $is_product_page ) {
			// Get current product category on single product pages.
			$terms = get_the_terms( get_the_ID(), 'product_category' );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$category = $terms[0];
				// Try to find the most specific category (deepest child).
				foreach ( $terms as $term ) {
					if ( $term->parent !== 0 && ( $category->parent === 0 || $term->parent === $category->term_id ) ) {
						$category = $term;
					}
				}
			}
		} elseif ( $is_category_page ) {
			// Get current category on product category archives.
			$category = get_queried_object();
		}

		if ( $category ) {
			$color = lemon_concentrate_get_category_color( $category->slug );
		}
	}

	// Set default to Orange if no color is found (e.g. Main Catalogue / Archive)
	if ( ! $color && ( is_post_type_archive( 'lemon_product' ) || ( is_archive() && 'lemon_product' === get_query_var( 'post_type' ) ) ) ) {
		$color = '#F6B501';
	}

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

		// Handle Button Block.
		if ( 'core/button' === $block['blockName'] ) {
			$processor = new WP_HTML_Tag_Processor( $block_content );
			if ( $processor->next_tag( array( 'class_name' => 'wp-block-button__link' ) ) ) {
				$style = $processor->get_attribute( 'style' );
				$style = $style ? rtrim( $style, ';' ) . ';' : '';
				$border_color = lemon_concentrate_lighten_color( $color, 20 );
				$processor->set_attribute( 'style', $style . "background-color: $color !important; border-color: $border_color !important;" );
				$block_content = $processor->get_updated_html();
			}
		}

		// Handle Read More Block.
		if ( 'core/read-more' === $block['blockName'] ) {
			$processor = new WP_HTML_Tag_Processor( $block_content );
			if ( ! isset( $block['attrs']['className'] ) || strpos( $block['attrs']['className'], 'lemon-view-product-btn' ) === false ) {
				$processor = new WP_HTML_Tag_Processor( $block_content );
				if ( $processor->next_tag( 'a' ) ) {
					$style = $processor->get_attribute( 'style' );
					$style = $style ? rtrim( $style, ';' ) . ';' : '';
					$processor->set_attribute( 'style', $style . "background-color: $color !important; border-color: $color !important;" );
					$block_content = $processor->get_updated_html();
				}
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
 * Output the category color as a CSS variable.
 */
function lemon_concentrate_category_color_css() {
	$color = '';

	if ( is_singular( 'lemon_product' ) ) {
		if ( function_exists( 'get_field' ) ) {
			$color = get_field( 'product_color_override', get_the_ID() );
		}
		if ( ! $color ) {
			$terms = get_the_terms( get_the_ID(), 'product_category' );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$category = $terms[0];
				foreach ( $terms as $term ) {
					if ( $term->parent !== 0 && ( $category->parent === 0 || $term->parent === $category->term_id ) ) {
						$category = $term;
					}
				}
				$color = lemon_concentrate_get_category_color( $category->slug );
			}
		}
	} elseif ( is_tax( 'product_category' ) ) {
		$slug = get_queried_object()->slug;
		$color = lemon_concentrate_get_category_color( $slug );
	}

	// Set default to Orange if no color is found (e.g. Main Catalogue / Archive)
	if ( ! $color ) {
		$color = '#F6B501';
	}

	if ( $color ) {
		echo "<style>:root { --category-color: " . esc_attr( $color ) . "; }</style>\n";
	}
}
add_action( 'wp_head', 'lemon_concentrate_category_color_css' );

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
			$archive_url = get_post_type_archive_link( 'lemon_product' );
			$processor->set_attribute( 'action', $archive_url ? $archive_url : home_url( '/' ) );
			$block_content = $processor->get_updated_html();
		}

		$block_content = str_replace(
			'</form>',
			'<input type="hidden" name="post_type" value="lemon_product"></form>',
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
	if ( 'core/cover' !== $block['blockName'] ) {
		return $block_content;
	}

	$object_id = false;
	if ( is_singular( 'lemon_product' ) ) {
		$object_id = get_the_ID();
	} elseif ( is_tax( 'product_category' ) ) {
		$object_id = get_queried_object();
	}

	if ( ! $object_id ) {
		return $block_content;
	}

	if ( ! function_exists( 'get_field' ) ) {
		return $block_content;
	}

	$hero_image = get_field( 'hero_background_image', $object_id );

	$image_url = '';
	$image_alt = '';

	if ( $hero_image ) {
		if ( is_array( $hero_image ) ) {
			$image_url = $hero_image['url'];
			$image_alt = $hero_image['alt'];
		} elseif ( is_numeric( $hero_image ) ) {
			$image_url = wp_get_attachment_image_url( $hero_image, 'full' );
			$image_alt = get_post_meta( $hero_image, '_wp_attachment_image_alt', true );
		} else {
			$image_url = $hero_image;
		}
	}

	if ( $image_url ) {
		$image_url = str_replace( array( "\r", "\n", ' ' ), '', $image_url );
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

/**
 * Force Allow Null on Product Categories field in Block to allow deselecting all.
 * Field Key: field_69732c9ac907c
 */
function lemon_concentrate_force_allow_null( $field ) {
	if ( 'field_69732c9ac907c' === $field['key'] ) {
		$field['allow_null'] = 1;
		$field['required']   = 0;
		$field['save_terms'] = 0;
		$field['load_terms'] = 0;
	}
	return $field;
}
add_filter( 'acf/load_field/key=field_69732c9ac907c', 'lemon_concentrate_force_allow_null' );

/**
 * Restrict plugin uploads and installation to a specific user ID.
 *
 * @param array $allcaps An array of all the user's capabilities.
 * @return array Modified capabilities.
 */
function lemon_concentrate_restrict_plugin_access( $allcaps ) {
	// CHANGE THIS: The user ID allowed to upload/install plugins.
	$allowed_user_id = 2;

	if ( is_user_logged_in() && get_current_user_id() !== $allowed_user_id ) {
		$allcaps['install_plugins'] = false;
		$allcaps['update_plugins']  = false;
		$allcaps['delete_plugins']  = false;
	}

	return $allcaps;
}
add_filter( 'user_has_cap', 'lemon_concentrate_restrict_plugin_access' );

/**
 * Add "Featured Product" meta box to Lemon Products.
 */
function lemon_concentrate_add_featured_meta_box() {
	add_meta_box(
		'lemon_featured_meta',
		__( 'Featured Product', 'lemon-concentrate' ),
		'lemon_concentrate_featured_meta_box_callback',
		'lemon_product',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'lemon_concentrate_add_featured_meta_box' );

function lemon_concentrate_featured_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_lemon_featured', true );
	wp_nonce_field( 'lemon_featured_save', 'lemon_featured_nonce' );
	?>
	<label>
		<input type="checkbox" name="lemon_featured" value="1" <?php checked( $value, '1' ); ?> />
		<?php esc_html_e( 'Mark as Featured', 'lemon-concentrate' ); ?>
	</label>
	<?php
}

function lemon_concentrate_save_featured_meta( $post_id ) {
	if ( ! isset( $_POST['lemon_featured_nonce'] ) || ! wp_verify_nonce( $_POST['lemon_featured_nonce'], 'lemon_featured_save' ) ) {
		return;
	}

	if ( isset( $_POST['lemon_featured'] ) ) {
		update_post_meta( $post_id, '_lemon_featured', '1' );
	} else {
		delete_post_meta( $post_id, '_lemon_featured' );
	}
}
add_action( 'save_post', 'lemon_concentrate_save_featured_meta' );

/**
 * Add Featured column to Lemon Product admin list.
 */
function lemon_concentrate_add_featured_column( $columns ) {
	$new_columns = array();
	foreach ( $columns as $key => $value ) {
		if ( 'title' === $key ) {
			$new_columns['thumb'] = __( 'Image', 'lemon-concentrate' );
		}
		$new_columns[ $key ] = $value;
		if ( 'title' === $key ) {
			$new_columns['featured'] = __( 'Featured', 'lemon-concentrate' );
		}
	}
	return $new_columns;
}
add_filter( 'manage_lemon_product_posts_columns', 'lemon_concentrate_add_featured_column' );

function lemon_concentrate_show_featured_column( $column, $post_id ) {
	if ( 'thumb' === $column ) {
		$thumbnail = get_the_post_thumbnail( $post_id, array( 50, 50 ) );
		if ( $thumbnail ) {
			echo $thumbnail;
		} else {
			echo '<span aria-hidden="true">&mdash;</span>';
		}
	}
	if ( 'featured' === $column ) {
		$is_featured = get_post_meta( $post_id, '_lemon_featured', true );
		$icon_class  = '1' === $is_featured ? 'dashicons-star-filled' : 'dashicons-star-empty';
		$color       = '1' === $is_featured ? '#f0ad4e' : '#ccc';
		$nonce       = wp_create_nonce( 'lemon_toggle_featured_' . $post_id );

		echo sprintf(
			'<a href="#" class="lemon-toggle-featured" data-id="%d" data-nonce="%s" aria-label="%s"><span class="dashicons %s" style="color: %s;"></span></a>',
			esc_attr( $post_id ),
			esc_attr( $nonce ),
			esc_attr__( 'Toggle Featured', 'lemon-concentrate' ),
			esc_attr( $icon_class ),
			esc_attr( $color )
		);
	}
}
add_action( 'manage_lemon_product_posts_custom_column', 'lemon_concentrate_show_featured_column', 10, 2 );

/**
 * Make Featured column sortable.
 */
function lemon_concentrate_sortable_featured_column( $columns ) {
	$columns['featured'] = 'featured';
	return $columns;
}
add_filter( 'manage_edit-lemon_product_sortable_columns', 'lemon_concentrate_sortable_featured_column' );

function lemon_concentrate_featured_orderby( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'featured' === $query->get( 'orderby' ) ) {
		$query->set( 'meta_key', '_lemon_featured' );
		$query->set( 'orderby', 'meta_value' );
	}
}
add_action( 'pre_get_posts', 'lemon_concentrate_featured_orderby' );

/**
 * Modify posts per page for product category archives.
 */
function lemon_concentrate_category_posts_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() && is_tax( 'product_category' ) ) {
		$query->set( 'posts_per_page', 25 );
	}
}
add_action( 'pre_get_posts', 'lemon_concentrate_category_posts_per_page' );

/**
 * Enqueue admin scripts for featured toggle.
 */
function lemon_concentrate_enqueue_admin_scripts( $hook ) {
	global $post_type;
	if ( 'edit.php' === $hook && 'lemon_product' === $post_type ) {
		wp_enqueue_script( 'lemon-admin-featured', get_theme_file_uri( 'assets/js/admin-featured-toggle.js' ), array( 'jquery' ), LEMON_CONCENTRATE_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'lemon_concentrate_enqueue_admin_scripts' );

/**
 * AJAX handler to toggle featured status.
 */
function lemon_concentrate_ajax_toggle_featured() {
	if ( ! isset( $_POST['post_id'] ) || ! isset( $_POST['nonce'] ) ) {
		wp_send_json_error( 'Missing parameters' );
	}

	$post_id = intval( $_POST['post_id'] );
	if ( ! wp_verify_nonce( $_POST['nonce'], 'lemon_toggle_featured_' . $post_id ) ) {
		wp_send_json_error( 'Invalid nonce' );
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		wp_send_json_error( 'Permission denied' );
	}

	$is_featured = get_post_meta( $post_id, '_lemon_featured', true );
	$new_status  = '1' === $is_featured ? '0' : '1';

	if ( '1' === $new_status ) {
		update_post_meta( $post_id, '_lemon_featured', '1' );
	} else {
		delete_post_meta( $post_id, '_lemon_featured' );
	}

	wp_send_json_success( array( 'status' => $new_status ) );
}
add_action( 'wp_ajax_lemon_toggle_featured', 'lemon_concentrate_ajax_toggle_featured' );

/**
 * Add styles for admin columns.
 */
function lemon_concentrate_admin_column_styles() {
	$screen = get_current_screen();
	if ( $screen && 'lemon_product' === $screen->post_type ) {
		echo '<style>
			.column-thumb { width: 60px; text-align: center; }
		</style>';
	}
}
add_action( 'admin_head', 'lemon_concentrate_admin_column_styles' );

/**
 * Shortcode to display the Primary Menu in block templates.
 * Usage: [lemon_primary_menu]
 */
function lemon_concentrate_primary_menu_shortcode() {
	if ( has_nav_menu( 'primary' ) ) {
		return wp_nav_menu( array(
			'theme_location' => 'primary',
			'echo'           => false,
			'container_class'=> 'lemon-primary-menu-wrapper',
		) );
	}
	return '';
}
add_shortcode( 'lemon_primary_menu', 'lemon_concentrate_primary_menu_shortcode' );

/**
 * Add custom query var for root URL resolution.
 */
function lemon_concentrate_query_vars( $vars ) {
	$vars[] = 'lemon_custom_slug';
	return $vars;
}
add_filter( 'query_vars', 'lemon_concentrate_query_vars' );

/**
 * Add catch-all rewrite rules to handle root URLs for products and categories.
 */
function lemon_concentrate_root_rewrite_rules() {
	add_rewrite_rule( '^catalogue/(.+?)/page/([0-9]+)/?$', 'index.php?lemon_custom_slug=$matches[1]&paged=$matches[2]', 'top' );
	add_rewrite_rule( '^catalogue/(.+?)/?$', 'index.php?lemon_custom_slug=$matches[1]', 'top' );
}
add_action( 'init', 'lemon_concentrate_root_rewrite_rules' );

/**
 * Resolve the custom slug to a Product, Category, Page, or Post.
 */
function lemon_concentrate_resolve_slug( $query_vars ) {
	// DEBUG: Frontend Inspector
	if ( isset( $_GET['debug_request'] ) && current_user_can( 'manage_options' ) ) {
		echo '<div style="background:#fff; padding:20px; border:2px solid red; position:relative; z-index:99999;">';
		echo '<h3>Debug Request</h3>';
		echo '<pre>' . esc_html( print_r( $query_vars, true ) ) . '</pre>';
	}

	$slug = '';
	$source_var = '';

	if ( isset( $query_vars['lemon_custom_slug'] ) ) {
		$slug = $query_vars['lemon_custom_slug'];
		$source_var = 'lemon_custom_slug';
	} elseif ( isset( $query_vars['pagename'] ) ) {
		$slug = $query_vars['pagename'];
		$source_var = 'pagename';
	} elseif ( isset( $query_vars['name'] ) ) {
		$slug = $query_vars['name'];
		$source_var = 'name';
	}

	if ( $slug ) {
		// 1. Check Product Category
		$slug  = untrailingslashit( $slug );
		
		// Remove prefixes like 'products/' or 'product-category/' if they exist in the URL
		$clean_slug = preg_replace( '/^(products|product-category)\//', '', $slug );
		
		// Handle hierarchical slugs (e.g. parent/child) - take the last part
		$parts = explode( '/', $clean_slug );
		$last_part = end( $parts );
		
		$term_slug = urldecode( $last_part );

		if ( isset( $_GET['debug_request'] ) && current_user_can( 'manage_options' ) ) {
			echo "<p><strong>Slug from URL:</strong> " . esc_html( $slug ) . "</p>";
			echo "<p><strong>Term Slug to find:</strong> " . esc_html( $term_slug ) . "</p>";
		}

		$term = get_term_by( 'slug', $term_slug, 'product_category' );

		// Fallback: Try sanitized slug if raw failed (handles cases like "Fruit & Veg" -> "fruit-veg")
		if ( ! $term ) {
			$term = get_term_by( 'slug', sanitize_title( $term_slug ), 'product_category' );
		}

		// Fallback 2: Try matching Name (e.g. "Fruit Powders" from "fruit-powders")
		if ( ! $term ) {
			$term_name = str_replace( '-', ' ', $term_slug );
			$term = get_term_by( 'name', $term_name, 'product_category' );
		}

		// Fallback 3: Try Capitalized Name (e.g. "Fruit Powders")
		if ( ! $term ) {
			$term_name = str_replace( '-', ' ', $term_slug );
			$term = get_term_by( 'name', ucwords( $term_name ), 'product_category' );
		}

		// Fallback 4: Try slug with suffixes (import artifacts)
		if ( ! $term ) {
			$term = get_term_by( 'slug', $term_slug . '-1', 'product_category' );
		}
		if ( ! $term ) {
			$term = get_term_by( 'slug', $term_slug . '-2', 'product_category' );
		}

		// Fallback 5: Try get_terms (brute force lookup)
		if ( ! $term ) {
			$found_terms = get_terms( array(
				'taxonomy'   => 'product_category',
				'slug'       => $term_slug,
				'hide_empty' => false,
				'number'     => 1,
			) );
			if ( ! empty( $found_terms ) && ! is_wp_error( $found_terms ) ) {
				$term = $found_terms[0];
			}
		}

		// Fallback 6: Check term_exists (direct DB check)
		if ( ! $term ) {
			$exists = term_exists( $term_slug, 'product_category' );
			if ( $exists && is_array( $exists ) ) {
				$term = get_term( $exists['term_id'], 'product_category' );
			}
		}

		// Fallback 7: Direct SQL Query (Bypass WP Cache/Filters)
		if ( ! $term ) {
			global $wpdb;
			$term_id = $wpdb->get_var( $wpdb->prepare(
				"SELECT t.term_id FROM $wpdb->terms t 
				INNER JOIN $wpdb->term_taxonomy tt ON t.term_id = tt.term_id 
				WHERE t.slug = %s AND tt.taxonomy = 'product_category'",
				$term_slug
			) );
			if ( $term_id ) {
				$term = get_term( $term_id, 'product_category' );
			}
		}

		if ( isset( $_GET['debug_request'] ) && current_user_can( 'manage_options' ) ) {
			echo "<p><strong>Term Lookup Result:</strong> " . ( $term ? 'FOUND (ID: ' . $term->term_id . ')' : 'NOT FOUND' ) . "</p>";
		}

		if ( $term && ! is_wp_error( $term ) ) {
			$query_vars['product_category'] = $term->slug;
			$query_vars['taxonomy']         = 'product_category';
			$query_vars['term']             = $term->slug;
			
			// Clear conflicting vars
			unset( $query_vars['lemon_custom_slug'] );
			if ( 'pagename' === $source_var ) unset( $query_vars['pagename'] );
			if ( 'name' === $source_var ) unset( $query_vars['name'] );
			
			return $query_vars;
		}

		// If this is a search query, do not resolve to singular pages/posts.
		if ( ! empty( $query_vars['s'] ) ) {
			unset( $query_vars['lemon_custom_slug'] );
			return $query_vars;
		}

		// 2. Check Lemon Product
		$product = get_page_by_path( $slug, OBJECT, 'lemon_product' );
		if ( $product && 'publish' === $product->post_status ) {
			$query_vars['post_type'] = 'lemon_product';
			$query_vars['name']      = $slug;
			$query_vars['lemon_product'] = $slug;
			unset( $query_vars['lemon_custom_slug'] );
			// If we found a product but came from pagename, we might need to unset pagename, but usually setting post_type is enough.
			return $query_vars;
		}

		// 3. Check Page (Standard WordPress pages)
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page && 'publish' === $page->post_status ) {
			$query_vars['pagename'] = $slug;
			unset( $query_vars['lemon_custom_slug'] );
			return $query_vars;
		}

		// 4. Check Post
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( $post && 'publish' === $post->post_status ) {
			$query_vars['name'] = $slug;
			unset( $query_vars['lemon_custom_slug'] );
			return $query_vars;
		}

		// Only force 404 if we originated from our custom catch-all rule.
		// If we came from 'pagename', let WordPress handle the 404 naturally if no page exists.
		if ( 'lemon_custom_slug' === $source_var ) {
			$query_vars['error'] = '404';
			if ( isset( $_GET['debug_request'] ) && current_user_can( 'manage_options' ) ) {
				echo "<p style='color:red'><strong>Result:</strong> No match found via custom slug. Forcing 404.</p>";
			}
		}
	}
	return $query_vars;
}
add_filter( 'request', 'lemon_concentrate_resolve_slug' );

/**
 * Remove bases from permalinks.
 */
function lemon_concentrate_remove_bases( $permalink, $post_or_term, $taxonomy = null ) {
	// Handle Post Type Link: Remove /catalogue/ from single products
	if ( is_object( $post_or_term ) && isset( $post_or_term->post_type ) && 'lemon_product' === $post_or_term->post_type ) {
		return str_replace( '/catalogue/', '/', $permalink );
	}
	// Handle Term Link: Remove /catalogue/ from product categories
	if ( 'product_category' === $taxonomy && is_object( $post_or_term ) ) {
		return str_replace( '/catalogue/', '/', $permalink );
	}
	return $permalink;
}
add_filter( 'post_type_link', 'lemon_concentrate_remove_bases', 10, 2 );
add_filter( 'term_link', 'lemon_concentrate_remove_bases', 10, 3 );

/**
 * Force has_post_thumbnail to true to enable fallback image.
 *
 * @param bool             $has_thumbnail True if the post has a post thumbnail, otherwise false.
 * @param int|WP_Post|null $post          Post ID or WP_Post object. Default is global $post.
 * @param int|false        $thumbnail_id  Post thumbnail ID or false if the post does not exist.
 * @return bool
 */
function lemon_concentrate_force_has_post_thumbnail( $has_thumbnail, $post, $thumbnail_id ) {
	if ( ! $has_thumbnail ) {
		return true;
	}
	return $has_thumbnail;
}
add_filter( 'has_post_thumbnail', 'lemon_concentrate_force_has_post_thumbnail', 10, 3 );

/**
 * Display default featured image if none exists.
 *
 * @param string       $html              The post thumbnail HTML.
 * @param int          $post_id           The post ID.
 * @param int          $post_thumbnail_id The post thumbnail ID.
 * @param string|array $size              The post thumbnail size.
 * @param array        $attr              Query string of attributes.
 * @return string
 */
function lemon_concentrate_default_featured_image( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	if ( empty( $html ) ) {
		$html = wp_get_attachment_image( 661, $size, false, $attr );
	}
	return $html;
}
add_filter( 'post_thumbnail_html', 'lemon_concentrate_default_featured_image', 10, 5 );

/**
 * Apply ACF hero image to Image block on category pages.
 *
 * @param string $block_content The block content.
 * @param array  $block         The block data.
 * @return string
 */
function lemon_concentrate_apply_category_hero_image( $block_content, $block ) {
	if ( 'core/image' === $block['blockName'] ) {
		$has_class = isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'category-hero-image' ) !== false;
		if ( ! $has_class ) {
			$has_class = strpos( $block_content, 'category-hero-image' ) !== false;
		}

		if ( $has_class ) {
			$term = get_queried_object();
			$image_url = '';
			$image_alt = '';

			if ( function_exists( 'get_field' ) && $term instanceof WP_Term ) {
				$image = get_field( 'hero_image', $term );
				if ( $image ) {
					if ( is_array( $image ) ) {
						$image_url = $image['url'];
						$image_alt = $image['alt'];
					} elseif ( is_numeric( $image ) ) {
						$image_url = wp_get_attachment_image_url( $image, 'large' );
						$image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true );
					} else {
						$image_url = $image;
					}
				}
			}

			// Fallback if no image found.
			if ( empty( $image_url ) ) {
				$image_url = get_theme_file_uri( 'assets/images/placeholder.svg' );
				$image_alt = __( 'Placeholder', 'lemon-concentrate' );
			}

			if ( ! empty( $image_url ) ) {
				$processor = new WP_HTML_Tag_Processor( $block_content );
				if ( $processor->next_tag( 'img' ) ) {
					$processor->set_attribute( 'src', $image_url );
					if ( $image_alt ) {
						$processor->set_attribute( 'alt', $image_alt );
					}
					$processor->remove_attribute( 'srcset' );
					$block_content = $processor->get_updated_html();
				}
			}
		}
	}
	return $block_content;
}
add_filter( 'render_block', 'lemon_concentrate_apply_category_hero_image', 10, 2 );

/**
 * Disable Gutenberg for Lemon Products.
 *
 * @param bool   $use_block_editor Whether the post type can be edited with the block editor.
 * @param string $post_type        The post type being checked.
 */
function lemon_concentrate_disable_gutenberg_for_products( $use_block_editor, $post_type ) {
	if ( 'lemon_product' === $post_type ) {
		return false;
	}
	return $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'lemon_concentrate_disable_gutenberg_for_products', 10, 2 );

/**
 * Modify Rank Math Breadcrumbs to inject "Products" in the trail.
 *
 * @param array  $crumbs The breadcrumb items.
 * @param string $class  The breadcrumb class.
 * @return array
 */
function lemon_concentrate_rank_math_breadcrumbs( $crumbs, $class ) {
	if ( is_tax( 'product_category' ) || is_singular( 'lemon_product' ) ) {
		$products_url = get_post_type_archive_link( 'lemon_product' );

		$found = false;
		foreach ( $crumbs as $key => $crumb ) {
			if ( 'Product Categories' === $crumb[0] || 'Lemon Products' === $crumb[0] ) {
				$crumbs[ $key ][0] = __( 'Products', 'lemon-concentrate' );
				$crumbs[ $key ][1] = $products_url;
				$found              = true;
			}
		}

		if ( ! $found && is_tax( 'product_category' ) ) {
			array_splice( $crumbs, 1, 0, array( array(
				0                => __( 'Products', 'lemon-concentrate' ),
				1                => $products_url,
				'hide_in_schema' => false,
			) ) );
		}
	}
	return $crumbs;
}
add_filter( 'rank_math/frontend/breadcrumb/items', 'lemon_concentrate_rank_math_breadcrumbs', 10, 2 );

/**
 * Register Mega Menu Intro Fields on Menu Items.
 */
function lemon_concentrate_register_mega_menu_options() {
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		acf_add_local_field_group( array(
			'key' => 'group_mega_menu_intro',
			'title' => 'Mega Menu Intro',
			'fields' => array(
				array(
					'key' => 'field_mega_menu_heading',
					'label' => 'Intro Heading',
					'name' => 'mega_menu_intro_heading',
					'type' => 'text',
				),
				array(
					'key' => 'field_mega_menu_text',
					'label' => 'Intro Text',
					'name' => 'mega_menu_intro_text',
					'type' => 'textarea',
					'rows' => 3,
					'default_value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'nav_menu_item',
						'operator' => '==',
						'value' => 'all',
					),
				),
			),
		) );
	}
}
add_action( 'acf/init', 'lemon_concentrate_register_mega_menu_options' );

/**
 * AJAX Search Handler.
 */
function lemon_concentrate_ajax_search() {
	$term = isset( $_GET['term'] ) ? sanitize_text_field( $_GET['term'] ) : '';

	if ( empty( $term ) ) {
		wp_send_json_error();
	}

	$args = array(
		'post_type'      => 'lemon_product',
		'post_status'    => 'publish',
		's'              => $term,
		'posts_per_page' => 5,
	);

	$query = new WP_Query( $args );
	$results = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			
			$image_url = '';
			if ( has_post_thumbnail() ) {
				$image_url = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
			} else {
				$image_url = get_theme_file_uri( 'assets/images/placeholder.svg' );
			}

			$results[] = array(
				'title' => get_the_title(),
				'url'   => get_permalink(),
				'image' => $image_url,
			);
		}
	}

	wp_send_json_success( $results );
}
add_action( 'wp_ajax_lemon_ajax_search', 'lemon_concentrate_ajax_search' );
add_action( 'wp_ajax_nopriv_lemon_ajax_search', 'lemon_concentrate_ajax_search' );

/**
 * Handle Contact Form Submission.
 */
function lemon_concentrate_handle_contact_form() {
	// Verify nonce
	if ( ! isset( $_POST['lemon_contact_nonce'] ) || ! wp_verify_nonce( $_POST['lemon_contact_nonce'], 'lemon_contact_form_submit' ) ) {
		wp_send_json_error( array( 'message' => 'Invalid security token. Please refresh the page.' ) );
	}

	// Sanitize and validate inputs
	$name    = sanitize_text_field( $_POST['contact_name'] ?? '' );
	$phone   = sanitize_text_field( $_POST['contact_phone'] ?? '' );
	$role    = sanitize_text_field( $_POST['contact_role'] ?? '' );
	$email   = sanitize_email( $_POST['contact_email'] ?? '' );
	$company = sanitize_text_field( $_POST['contact_company'] ?? '' );
	$country = sanitize_text_field( $_POST['contact_country'] ?? '' );
	$message = sanitize_textarea_field( $_POST['contact_message'] ?? '' );

	if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
		wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
	}

	// Prepare Email
	$to      = get_option( 'admin_email' ); // Sends to the site admin email
	$subject = 'New Contact Form Submission from ' . $name;
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';

	$body  = '<strong>Name:</strong> ' . $name . '<br>';
	$body .= '<strong>Email:</strong> ' . $email . '<br>';
	$body .= '<strong>Phone:</strong> ' . $phone . '<br>';
	$body .= '<strong>Role:</strong> ' . $role . '<br>';
	$body .= '<strong>Company:</strong> ' . $company . '<br>';
	$body .= '<strong>Country:</strong> ' . $country . '<br><br>';
	$body .= '<strong>Message:</strong><br>' . nl2br( $message );

	if ( wp_mail( $to, $subject, $body, $headers ) ) {
		wp_send_json_success( array( 'message' => 'Thank you! Your message has been sent successfully.' ) );
	} else {
		wp_send_json_error( array( 'message' => 'Failed to send email. Please try again later.' ) );
	}
}
add_action( 'wp_ajax_lemon_contact_form_submit', 'lemon_concentrate_handle_contact_form' );
add_action( 'wp_ajax_nopriv_lemon_contact_form_submit', 'lemon_concentrate_handle_contact_form' );

/**
 * Show current template in Admin Bar.
 */
function lemon_concentrate_show_template_admin_bar( $admin_bar ) {
	if ( ! is_admin() && current_user_can( 'manage_options' ) ) {
		global $template;
		$template_name = basename( $template );
		$object_id     = get_queried_object_id();
		$title         = 'Template: ' . $template_name;
		if ( $object_id ) {
			$title .= ' | ID: ' . $object_id;
		}
		$admin_bar->add_node( array(
			'id'    => 'lemon-current-template',
			'title' => $title,
			'href'  => '#',
			'meta'  => array(
				'title' => $template,
			),
		) );
	}
}
add_action( 'admin_bar_menu', 'lemon_concentrate_show_template_admin_bar', 999 );
