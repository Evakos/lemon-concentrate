<?php
/**
 * Render callback for the Product Category Loop block.
 *
 * @package lemon-concentrate
 */

// Ensure icon helper is loaded.
if ( ! function_exists( 'lemon_concentrate_get_category_icon' ) ) {
	$icon_file = get_theme_file_path( 'inc/blocks/breadcrumbs/category-icons.php' );
	if ( file_exists( $icon_file ) ) {
		require_once $icon_file;
	}
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-concentrate-category-loop facetwp-template' ) );

// Check if "Select All" is enabled.
$show_all = get_field( 'show_all_categories' );

if ( $show_all ) {
	$args = array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
	);
	// Exclude 'uncategorized' category.
	$uncategorized = get_term_by( 'slug', 'uncategorized', 'product_cat' );
	if ( $uncategorized ) {
		$args['exclude'] = array( $uncategorized->term_id );
	}
	$categories = get_terms( $args );
} else {
	$selected = get_field( 'product_categories' );
	$categories = array();
	if ( ! empty( $selected ) ) {
		if ( ! is_array( $selected ) ) {
			$selected = array( $selected );
		}
		$ids = array();
		foreach ( $selected as $cat ) {
			$ids[] = is_object( $cat ) ? $cat->term_id : $cat;
		}
		if ( ! empty( $ids ) ) {
			$categories = get_terms( array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'include'    => $ids,
			) );
		}
	}
}
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
		<?php foreach ( $categories as $category ) : ?>
			<?php
			// Skip 'uncategorized' category.
			if ( 'uncategorized' === $category->slug ) {
				continue;
			}
			$color = '#CCCCCC';
			if ( function_exists( 'lemon_concentrate_get_category_color' ) ) {
				$color = lemon_concentrate_get_category_color( $category->slug );
			}

			// Handle transparent or invalid colors to prevent errors.
			if ( 'transparent' === $color || ! preg_match( '/^#?([a-f0-9]{3}|[a-f0-9]{6})$/i', $color ) ) {
				$r = 204; $g = 204; $b = 204; // Default to #CCCCCC
			} else {
				$hex = ltrim( $color, '#' );
				if ( strlen( $hex ) == 3 ) {
					$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
					$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
					$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
				} else {
					$r = hexdec( substr( $hex, 0, 2 ) );
					$g = hexdec( substr( $hex, 2, 2 ) );
					$b = hexdec( substr( $hex, 4, 2 ) );
				}
			}
			$style = "--category-bg-color: rgba($r, $g, $b, 0.15); --category-title-color: rgb($r, $g, $b); text-align: left; display: flex; flex-direction: column; align-items: flex-start; justify-content: space-between; padding:2rem;";
			?>
			<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="lemon-concentrate-category-item" style="<?php echo esc_attr( $style ); ?>">
				<span class="lemon-concentrate-category-icon">
					<?php
					$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
					if ( $thumbnail_id ) {
						echo wp_get_attachment_image( $thumbnail_id, 'medium', false, array( 'style' => 'width: 50px; height: 50px; object-fit: contain;' ) );
					} else {
						echo '<span style="display:block; width:50px; height:50px; background-color: #E5E5E5; border-radius: 50%;"></span>';
					}
					?>
				</span>
				<div class="lemon-concentrate-category-content">
					<h3 class="lemon-concentrate-category-name" style="color: var(--category-title-color);"><?php echo esc_html( $category->name ); ?></h3>
					<div class="lemon-concentrate-category-description">
						<?php
						if ( ! empty( $category->description ) ) {
							echo wp_kses_post( $category->description );
						} else {
							echo '<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'lemon-concentrate' ) . '</p>';
						}
						?>
					</div>
				</div>
			</a>
		<?php endforeach; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No categories found.', 'lemon-concentrate' ); ?></p>
	<?php endif; ?>
</div>