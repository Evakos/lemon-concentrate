<?php
/**
 * Migration script to move WooCommerce products to Custom Post Type.
 *
 * Usage: Visit your site URL with ?migrate_products=1 logged in as admin.
 * Example: https://example.com/?migrate_products=1
 */

function lemon_concentrate_run_migration() {
	if ( ! isset( $_GET['migrate_products'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Ensure taxonomies are registered before running.
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		wp_die( 'Error: WooCommerce "product_cat" taxonomy not found. Please ensure WooCommerce is active.' );
	}

	// 1. Migrate Categories (Terms)
	$product_cats = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
	) );

	$term_map = array(); // Old ID => New ID

	if ( ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ) {
		// First pass: Create terms
		foreach ( $product_cats as $cat ) {
			$exists = term_exists( $cat->slug, 'product_category' );
			
			if ( $exists ) {
				$term_id = is_array( $exists ) ? $exists['term_id'] : $exists;
			} else {
				$new_term = wp_insert_term(
					$cat->name,
					'product_category',
					array(
						'slug'        => $cat->slug,
						'description' => $cat->description,
					)
				);
				if ( ! is_wp_error( $new_term ) ) {
					$term_id = $new_term['term_id'];
				} else {
					continue;
				}
			}
			$term_map[ $cat->term_id ] = $term_id;
		}

		// Second pass: Fix hierarchy
		foreach ( $product_cats as $cat ) {
			if ( $cat->parent && isset( $term_map[ $cat->parent ] ) && isset( $term_map[ $cat->term_id ] ) ) {
				wp_update_term( $term_map[ $cat->term_id ], 'product_category', array(
					'parent' => $term_map[ $cat->parent ],
				) );
			}
		}
	}

	// 2. Migrate Products (Posts)
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => -1,
		'post_status'    => 'any',
	);
	
	$products = get_posts( $args );
	$count    = 0;

	foreach ( $products as $product ) {
		// Get old terms
		$old_terms = get_the_terms( $product->ID, 'product_cat' );
		$new_term_ids = array();

		if ( $old_terms && ! is_wp_error( $old_terms ) ) {
			foreach ( $old_terms as $term ) {
				if ( isset( $term_map[ $term->term_id ] ) ) {
					$new_term_ids[] = $term_map[ $term->term_id ];
				}
			}
		}

		// Check if product was featured in WooCommerce (product_visibility taxonomy)
		if ( has_term( 'featured', 'product_visibility', $product->ID ) ) {
			update_post_meta( $product->ID, '_lemon_featured', '1' );
		}

		$post_data = array(
			'ID'        => $product->ID,
			'post_type' => 'lemon_product',
		);

		if ( empty( $product->post_content ) ) {
			$post_data['post_content'] = '<!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><!-- /wp:paragraph -->';
		}

		// Update Post Type
		$updated = wp_update_post( $post_data );

		if ( $updated && ! is_wp_error( $updated ) ) {
			// Assign new terms
			if ( ! empty( $new_term_ids ) ) {
				wp_set_object_terms( $product->ID, $new_term_ids, 'product_category' );
			}
			$count++;
		}
	}

	echo "<h1>Migration Complete</h1>";
	echo "<p>Successfully migrated <strong>$count</strong> products to 'lemon_product' post type.</p>";
	echo '<p><a href="' . esc_url( admin_url( 'edit.php?post_type=lemon_product' ) ) . '">View Products</a></p>';
	exit;
}
add_action( 'init', 'lemon_concentrate_run_migration', 20 );

/**
 * Script to just fill empty content for existing Lemon Products.
 *
 * Usage: Visit your site URL with ?fill_content=1 logged in as admin.
 * To overwrite existing content: ?fill_content=1&force_update=1
 */
function lemon_concentrate_fill_content_only() {
	if ( ! isset( $_GET['fill_content'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$args = array(
		'post_type'      => 'lemon_product',
		'posts_per_page' => -1,
		'post_status'    => 'any',
	);
	
	$products = get_posts( $args );
	$count    = 0;

	foreach ( $products as $product ) {
		if ( empty( $product->post_content ) || isset( $_GET['force_update'] ) ) {
			$content = '<!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><!-- /wp:paragraph -->';
			
			wp_update_post( array(
				'ID'           => $product->ID,
				'post_content' => $content,
			) );
			$count++;
		}
	}

	echo "<h1>Content Update Complete</h1>";
	echo "<p>Successfully updated content for <strong>$count</strong> lemon products.</p>";
	echo '<p><a href="' . esc_url( admin_url( 'edit.php?post_type=lemon_product' ) ) . '">View Products</a></p>';
	exit;
}
add_action( 'init', 'lemon_concentrate_fill_content_only', 20 );