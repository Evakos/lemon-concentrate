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
	_wp_menu_item_classes_by_context( $menu_items );
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
	<div class="lemon-mega-menu-desktop">
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
				if ( ! empty( $item->classes ) && is_array( $item->classes ) ) {
					$item_classes .= ' ' . implode( ' ', $item->classes );
				}
				if ( $has_children ) {
					$item_classes .= ' has-children';
				}

				// Get Intro fields for this specific menu item
				$intro_heading = function_exists( 'get_field' ) ? get_field( 'mega_menu_intro_heading', $item->ID ) : '';
				$intro_text    = function_exists( 'get_field' ) ? get_field( 'mega_menu_intro_text', $item->ID ) : '';

				if ( empty( $intro_text ) ) {
					$intro_text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
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
							<?php if ( $intro_heading || $intro_text ) : ?>
								<div class="lemon-mega-menu-intro">
									<?php if ( $intro_heading ) : ?>
										<h3><?php echo esc_html( $intro_heading ); ?></h3>
									<?php endif; ?>
									<?php if ( $intro_text ) : ?>
										<p><?php echo esc_html( $intro_text ); ?></p>
									<?php endif; ?>
								</div>
							<?php endif; ?>
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
	</div>

	<div class="lemon-mega-menu-mobile">
		<?php echo do_blocks( '<!-- wp:lemon-concentrate/mobile-menu /-->' ); ?>
	</div>
	<style>
		.lemon-mega-menu-nav {
			display: flex;
			list-style: none;
			margin: 0;
			padding: 0;
			gap: 0;
			align-items: stretch;
			border: 1px solid white;
			border-radius: 100px;
		}
		.lemon-mega-menu-item {
			display: flex;
			align-items: stretch;
		}
		.lemon-mega-menu-link {
			display: flex;
			align-items: center;
			padding: 0.45rem 2rem;
			transition: background-color 0.3s ease, color 0.3s ease;
		}
		.lemon-mega-menu-item:hover .lemon-mega-menu-link,
		.lemon-mega-menu-item.current-menu-item .lemon-mega-menu-link,
		.lemon-mega-menu-item.current-menu-ancestor .lemon-mega-menu-link,
		.lemon-mega-menu-item.active .lemon-mega-menu-link {
			background-color: rgba(255, 255, 255, 0.7);
			color: var(--wp--preset--color--primary, #000);
		}
		.lemon-mega-menu-item:first-child .lemon-mega-menu-link {
			border-radius: 100px 0 0 100px;
		}
		.lemon-mega-menu-item:last-child .lemon-mega-menu-link {
			border-radius: 0 100px 100px 0;
		}
		.lemon-mega-menu-intro h3 {
			position: relative;
			margin-bottom: 1rem;
			display: inline-block;
		}
		.lemon-mega-menu-intro h3::after {
			content: '';
			display: none;
			margin-top: 8px;
			width: 60px;
			height: 12px;
			background-image: url("data:image/svg+xml,%3Csvg width='60' height='12' viewBox='0 0 60 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='6' cy='6' r='6' fill='%23F6B501' fill-opacity='0.4'/%3E%3Ccircle cx='22' cy='6' r='4' fill='%23FF9500' fill-opacity='0.6'/%3E%3Ccircle cx='34' cy='6' r='3' fill='%23FFB74D' fill-opacity='0.8'/%3E%3Ccircle cx='44' cy='6' r='2' fill='%23F6B501' fill-opacity='1'/%3E%3C/svg%3E");
			background-repeat: no-repeat;
			background-size: contain;
		}
		.lemon-mega-menu-mobile {
			display: none;
		}
		@media (max-width: 1024px) {
			.lemon-mega-menu-desktop { display: none; }
			.lemon-mega-menu-mobile { display: block; }
		}
	</style>
</nav>
