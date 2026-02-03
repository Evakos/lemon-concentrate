<?php
/**
 * Ticker Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$items = get_field( 'ticker_items' );

// Fallback for preview or empty state
if ( ! $items ) {
	$items = array(
		array( 'ticker_item' => 'Add "ticker_items" repeater field in ACF to start...' ),
		array( 'ticker_item' => 'News Ticker Block' ),
		array( 'ticker_item' => 'Continuous Scrolling' ),
	);
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'ticker-container' ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<div class="ticker-track">
		<?php foreach ( $items as $item ) : ?>
			<div class="ticker-item">
				<?php echo esc_html( $item['ticker_item'] ?? '' ); ?>
			</div>
		<?php endforeach; ?>
		<?php foreach ( $items as $item ) : ?>
			<div class="ticker-item">
				<?php echo esc_html( $item['ticker_item'] ?? '' ); ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>