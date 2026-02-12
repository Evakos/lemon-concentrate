<?php
/**
 * AJAX Search Block Template.
 */

$wrapper_attributes = get_block_wrapper_attributes( array(
	'class' => 'lemon-ajax-search wp-block-search',
	'data-ajax-url' => admin_url( 'admin-ajax.php' ),
	'data-category-icons' => '{}', // Placeholder, populated below
) );

$placeholder = get_field( 'placeholder_text' ) ?: __( 'Search products...', 'lemon-concentrate' );
$unique_id   = wp_unique_id( 'lemon-ajax-search-input-' );

// Fetch categories for jackpot animation
$categories = get_terms( array(
	'taxonomy'   => 'product_category',
	'hide_empty' => true,
) );

$jackpot_items = array();
$category_icons = array();

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
	foreach ( $categories as $cat ) {
		$icon = get_field( 'icon', 'product_category_' . $cat->term_id );
		if ( $icon ) {
			$url = is_array( $icon ) ? $icon['url'] : $icon;
			if ( $url ) {
				if ( count( $jackpot_items ) < 10 ) {
					$jackpot_items[] = sprintf(
						'<div class="lemon-search-jackpot-item"><img src="%s" alt="%s"></div>',
						esc_url( $url ),
						esc_attr( $cat->name )
					);
				}
				$category_icons[ strtolower( $cat->name ) ] = $url;
			}
		}
	}
}

$has_jackpot = ! empty( $jackpot_items );
$jackpot_count = count( $jackpot_items );
$input_class = 'wp-block-search__input lemon-ajax-search-input';
if ( $has_jackpot ) {
	$input_class .= ' has-jackpot';
}

// Update wrapper attributes with real data
$wrapper_attributes = get_block_wrapper_attributes( array(
	'class' => 'lemon-ajax-search wp-block-search',
	'data-ajax-url' => admin_url( 'admin-ajax.php' ),
	'data-category-icons' => wp_json_encode( $category_icons ),
) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<form role="search" method="get" class="lemon-ajax-search-form wp-block-search__button-inside wp-block-search__icon-button" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="wp-block-search__inside-wrapper" style="width: 100%;border-width: 0px;border-style: none;border-top-left-radius: calc(5px + 4px);border-top-right-radius: calc(5px + 4px);border-bottom-left-radius: calc(5px + 4px);border-bottom-right-radius: calc(5px + 4px)">
			<input class="<?php echo esc_attr( $input_class ); ?>" id="<?php echo esc_attr( $unique_id ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" type="search" name="s" required="" style="border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px" autocomplete="off" />
			
			<?php if ( $has_jackpot ) : ?>
				<div class="lemon-search-jackpot">
					<div class="lemon-search-jackpot-track" style="--jackpot-count: <?php echo intval( $jackpot_count ); ?>;">
						<?php
						// Output items multiple times for seamless loop
						echo implode( '', $jackpot_items );
						echo implode( '', $jackpot_items );
						echo implode( '', $jackpot_items );
						?>
					</div>
				</div>
			<?php endif; ?>

			<div class="lemon-search-match-icon"></div>

			<input type="hidden" name="post_type" value="lemon_product" />
			<button aria-label="<?php esc_attr_e( 'Search', 'lemon-concentrate' ); ?>" class="wp-block-search__button has-text-color has-white-color has-background has-secondary-background-color has-icon wp-element-button lemon-ajax-search-submit" type="submit" style="border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px">
				<svg class="search-icon" viewBox="0 0 24 24" width="24" height="24">
					<path d="M13 5c-3.3 0-6 2.7-6 6 0 1.4.5 2.7 1.3 3.7l-3.8 3.8 1.1 1.1 3.8-3.8c1 .8 2.3 1.3 3.7 1.3 3.3 0 6-2.7 6-6S16.3 5 13 5zm0 10.5c-2.5 0-4.5-2-4.5-4.5s2-4.5 4.5-4.5 4.5 2 4.5 4.5-2 4.5-4.5 4.5z"></path>
				</svg>
				<div class="lemon-ajax-search-spinner"></div>
			</button>
		</div>
		<div class="lemon-ajax-search-results"></div>
	</form>
</div>