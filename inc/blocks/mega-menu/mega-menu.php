<?php
/**
 * Mega Menu Block Template.
 */

// Ensure icon helper is loaded.
if ( ! function_exists( 'lemon_concentrate_get_category_icon' ) ) {
	$icon_file = get_theme_file_path( 'inc/blocks/mega-menu/category-icons.php' );
	if ( file_exists( $icon_file ) ) {
		require_once $icon_file;
	}
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-mega-menu-block' ) );

$menu_items = array();
$locations  = get_nav_menu_locations();

if ( isset( $locations['primary'] ) ) {
	$menu = wp_get_nav_menu_object( $locations['primary'] );
	if ( $menu ) {
		$menu_items = wp_get_nav_menu_items( $menu->term_id );
	}
}

$menu_tree = array();
$children  = array();

if ( $menu_items ) {
	foreach ( $menu_items as $item ) {
		if ( $item->menu_item_parent ) {
			$children[ $item->menu_item_parent ][] = $item;
		} else {
			$menu_tree[] = $item;
		}
	}
}
?>
<nav <?php echo $wrapper_attributes; ?>>
	<?php if ( ! empty( $menu_tree ) ) : ?>
		<ul class="lemon-mega-menu-nav">
			<?php foreach ( $menu_tree as $item ) : ?>
				<?php
				$child_items = array();
				
				// 1. Check for manually added children in the menu
				if ( isset( $children[ $item->ID ] ) ) {
					$child_items = $children[ $item->ID ];
				}

				// 3. Pre-fetch parent image for fallback
				$parent_image_html = '';
				if ( 'taxonomy' === $item->type && ( 'product_category' === $item->object || 'product_cat' === $item->object ) ) {
					$p_term_id = $item->object_id;
					$p_term    = get_term( $p_term_id, 'product_category' );
					
					if ( $p_term && ! is_wp_error( $p_term ) ) {
						$p_icon_svg     = function_exists( 'lemon_concentrate_get_category_icon' ) ? lemon_concentrate_get_category_icon( $p_term->slug ) : '';
						$p_acf_icon     = get_field( 'icon', 'product_category_' . $p_term_id );
						$p_thumbnail_id = get_term_meta( $p_term_id, 'thumbnail_id', true );

						if ( $p_acf_icon ) {
							if ( is_array( $p_acf_icon ) ) {
								$parent_image_html = wp_get_attachment_image( $p_acf_icon['ID'], 'medium' );
							} elseif ( is_numeric( $p_acf_icon ) ) {
								$parent_image_html = wp_get_attachment_image( $p_acf_icon, 'medium' );
							} else {
								$parent_image_html = '<img src="' . esc_url( $p_acf_icon ) . '" alt="' . esc_attr( $p_term->name ) . '" />';
							}
						} elseif ( $p_thumbnail_id ) {
							$parent_image_html = wp_get_attachment_image( $p_thumbnail_id, 'medium' );
						} elseif ( $p_icon_svg ) {
							$parent_image_html = $p_icon_svg;
						}
					}
				}

				$has_children = ! empty( $child_items );
				$item_classes = 'lemon-mega-menu-item';
				if ( $has_children ) {
					$item_classes .= ' has-children';
				}
				?>
				<li class="<?php echo esc_attr( $item_classes ); ?>">
					<a href="<?php echo esc_url( $item->url ); ?>" class="lemon-mega-menu-link">
						<?php echo esc_html( $item->title ); ?>
						<?php if ( $has_children ) : ?>
							<span class="lemon-mega-menu-arrow">
								<svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</span>
						<?php endif; ?>
					</a>

					<?php if ( $has_children ) : ?>
						<div class="lemon-mega-menu-dropdown">
							<div class="lemon-mega-menu-container">
								<ul class="lemon-mega-menu-grid">
									<?php foreach ( $child_items as $child ) : ?>
										<?php
										$image_html = '';
										$title      = '';
										$url        = '';
										$term_id    = 0;

										// Handle WP_Term object (automatic) vs WP_Post object (menu item)
										if ( is_a( $child, 'WP_Term' ) ) {
											$term_id = $child->term_id;
											$title   = $child->name;
											$url     = get_term_link( $child );
											$slug    = $child->slug;
										} else {
											// Menu Item
											$title = $child->title;
											$url   = $child->url;
											if ( 'taxonomy' === $child->type && ( 'product_category' === $child->object || 'product_cat' === $child->object ) ) {
												$term_id = $child->object_id;
												$term    = get_term( $term_id, 'product_category' );
												$slug    = $term ? $term->slug : '';
											} elseif ( 'post_type' === $child->type && 'lemon_product' === $child->object ) {
												// Handle Lemon Product Featured Image
												$image_html = get_the_post_thumbnail( $child->object_id, 'medium' );
											}
										}

										if ( $term_id ) {
											$icon_svg     = function_exists( 'lemon_concentrate_get_category_icon' ) ? lemon_concentrate_get_category_icon( $slug ) : '';
											$acf_icon     = get_field( 'icon', 'product_category_' . $term_id );
											$thumbnail_id = get_term_meta( $term_id, 'thumbnail_id', true );

											if ( $acf_icon ) {
												if ( is_array( $acf_icon ) ) {
													$image_html = wp_get_attachment_image( $acf_icon['ID'], 'medium' );
												} elseif ( is_numeric( $acf_icon ) ) {
													$image_html = wp_get_attachment_image( $acf_icon, 'medium' );
												} else {
													$image_html = '<img src="' . esc_url( $acf_icon ) . '" alt="' . esc_attr( $title ) . '" />';
												}
											} elseif ( $thumbnail_id ) {
												$image_html = wp_get_attachment_image( $thumbnail_id, 'medium' );
											} elseif ( $icon_svg ) {
												$image_html = $icon_svg;
											}
										}
										
										if ( empty( $image_html ) ) {
											if ( ! empty( $parent_image_html ) ) {
												$image_html = $parent_image_html;
											} else {
												$image_html = '<img src="' . esc_url( get_theme_file_uri( 'assets/images/placeholder.svg' ) ) . '" alt="" class="lemon-mega-menu-placeholder" />';
											}
										}
										?>
										<li class="lemon-mega-menu-subitem">
											<a href="<?php echo esc_url( $url ); ?>">
												<div class="lemon-mega-menu-item-image">
													<?php echo $image_html; ?>
												</div>
												<span class="lemon-mega-menu-item-title"><?php echo esc_html( $title ); ?></span>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php else : ?>
		<p><?php esc_html_e( 'Please assign a menu to the Primary location.', 'lemon-concentrate' ); ?></p>
	<?php endif; ?>
</nav>
