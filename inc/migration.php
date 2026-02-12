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

/**
 * Script to convert Pages by a specific Author to Lemon Products.
 *
 * Usage: Visit your site URL with ?convert_author={USER_ID} logged in as admin.
 * Example: https://example.com/?convert_author=5
 */
function lemon_concentrate_convert_pages_by_author() {
	if ( ! isset( $_GET['convert_author'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$author_id = intval( $_GET['convert_author'] );
	
	if ( 0 === $author_id ) {
		wp_die( 'Error: Invalid Author ID.' );
	}

	$args = array(
		'post_type'      => 'page',
		'posts_per_page' => -1,
		'author'         => $author_id,
		'post_status'    => 'any',
	);
	
	$pages = get_posts( $args );
	$count = 0;

	foreach ( $pages as $page ) {
		$update_args = array(
			'ID'        => $page->ID,
			'post_type' => 'lemon_product',
		);

		$updated = wp_update_post( $update_args );

		if ( $updated && ! is_wp_error( $updated ) ) {
			// Try to set Featured Image if missing
			if ( ! has_post_thumbnail( $page->ID ) ) {
				$attachment_id = 0;

				// 1. Check for attached images (children)
				$attachments = get_posts( array(
					'post_parent'    => $page->ID,
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'posts_per_page' => 1,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'fields'         => 'ids',
				) );

				if ( ! empty( $attachments ) ) {
					$attachment_id = $attachments[0];
				} else {
					// 2. Check content for <img> tags
					if ( preg_match( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $page->post_content, $matches ) ) {
						$image_url = $matches[1];
						$attachment_id = attachment_url_to_postid( $image_url );
					}
				}

				if ( $attachment_id ) {
					set_post_thumbnail( $page->ID, $attachment_id );
				}
			}
			$count++;
		}
	}

	echo "<h1>Conversion Complete</h1>";
	echo "<p>Successfully converted <strong>$count</strong> pages owned by User ID $author_id to 'lemon_product' post type.</p>";
	echo '<p><a href="' . esc_url( admin_url( 'edit.php?post_type=lemon_product' ) ) . '">View Products</a></p>';
	exit;
}
add_action( 'init', 'lemon_concentrate_convert_pages_by_author', 20 );

/**
 * Helper to list authors and their page counts to help identify the import user.
 * Usage: Visit your site URL with ?list_authors=1 logged in as admin.
 */
function lemon_concentrate_list_authors_stats() {
	if ( ! isset( $_GET['list_authors'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$users = get_users();
	echo '<h1>Author Stats</h1><ul>';
	foreach ( $users as $user ) {
		$query = new WP_Query( array(
			'post_type' => 'page',
			'author'    => $user->ID,
			'fields'    => 'ids',
			'posts_per_page' => -1,
		) );
		echo '<li>ID: <strong>' . esc_html( $user->ID ) . '</strong> | Name: ' . esc_html( $user->display_name ) . ' | Pages: <strong>' . esc_html( $query->found_posts ) . '</strong></li>';
	}
	echo '</ul>';
	exit;
}
add_action( 'init', 'lemon_concentrate_list_authors_stats', 20 );

/**
 * Script to delete all content by a specific Author (Undo Import).
 *
 * Usage: Visit your site URL with ?undo_import_author={USER_ID} logged in as admin.
 * Example: https://example.com/?undo_import_author=4
 */
function lemon_concentrate_undo_import_by_author() {
	if ( ! isset( $_GET['undo_import_author'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$author_id = intval( $_GET['undo_import_author'] );

	if ( 0 === $author_id ) {
		wp_die( 'Error: Invalid Author ID.' );
	}

	$args = array(
		'post_type'      => 'any', // Catch pages, products, attachments, etc.
		'posts_per_page' => -1,
		'author'         => $author_id,
		'post_status'    => 'any',
		'fields'         => 'ids',
	);

	$posts = get_posts( $args );
	$count = 0;

	foreach ( $posts as $post_id ) {
		wp_delete_post( $post_id, true ); // True to force delete (skip trash)
		$count++;
	}

	echo "<h1>Undo Complete</h1>";
	echo "<p>Successfully deleted <strong>$count</strong> items owned by User ID $author_id.</p>";
	exit;
}
add_action( 'init', 'lemon_concentrate_undo_import_by_author', 20 );

/**
 * DEEP SLUG INSPECTOR: Checks all taxonomies and rewrite rules.
 *
 * Usage: Visit your site URL with ?inspect_slug=fruit-powders logged in as admin.
 */
function lemon_concentrate_inspect_slug() {
	if ( ! isset( $_GET['inspect_slug'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$target_slug = sanitize_title( $_GET['inspect_slug'] );
	echo "<h1>Inspecting Slug: " . esc_html( $target_slug ) . "</h1>";

	// 1. Check ALL Post Types
	echo "<h2>1. Post Type Collisions</h2>";
	$collisions = get_posts( array(
		'name'           => $target_slug,
		'post_type'      => 'any',
		'post_status'    => 'any',
		'posts_per_page' => -1,
	) );
	if ( ! empty( $collisions ) ) {
		foreach ( $collisions as $collision ) {
			echo "<p style='color:red'><strong>FOUND:</strong> ID={$collision->ID}, Type=<strong>{$collision->post_type}</strong>, Status={$collision->post_status}</p>";
		}
	} else {
		echo "<p style='color:green'>No post collisions found.</p>";
	}

	// 2. Check ALL Taxonomies
	echo "<h2>2. Taxonomy Collisions</h2>";
	$taxonomies = get_taxonomies();
	$found_tax = false;
	foreach ( $taxonomies as $tax ) {
		$term = get_term_by( 'slug', $target_slug, $tax );
		if ( $term ) {
			$color = ( 'product_category' === $tax ) ? 'green' : 'red';
			echo "<p style='color:{$color}'><strong>FOUND in '{$tax}':</strong> ID={$term->term_id}, Name={$term->name}, Slug={$term->slug}</p>";
			$found_tax = true;
		}
	}
	if ( ! $found_tax ) echo "<p>No taxonomy terms found.</p>";

	// 3. Check Matching Rewrite Rules
	echo "<h2>3. Matching Rewrite Rules</h2>";
	global $wp_rewrite;
	$rules = $wp_rewrite->wp_rewrite_rules();
	$found_rule = false;
	foreach ( $rules as $pattern => $query ) {
		if ( preg_match( "#^$pattern#", $target_slug ) ) {
			echo "<p style='color:orange'><strong>MATCH:</strong> Rule: <code>{$pattern}</code> <br>Query: <code>{$query}</code></p>";
			$found_rule = true;
		}
	}
	if ( ! $found_rule ) echo "<p>No specific rewrite rules matched.</p>";
	
	exit;
}
add_action( 'init', 'lemon_concentrate_inspect_slug', 20 );