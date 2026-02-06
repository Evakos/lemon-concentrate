<?php
/**
 * Hero Bullets Block Template.
 *
 * @package lemon-concentrate
 */

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-hero-bullets' ) );

// Get bullets from current post.
$bullets = get_field( 'hero_bullets', $post_id );

// Fallback if empty.
if ( ! $bullets ) {
	$bullets = array(
		array( 'text' => 'Premium Quality' ),
		array( 'text' => '100% Organic' ),
		array( 'text' => 'Sustainably Sourced' ),
	);
}
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( $bullets ) : ?>
		<ul class="lemon-hero-bullets-list">
			<?php foreach ( $bullets as $item ) : ?>
				<?php if ( ! empty( $item['text'] ) ) : ?>
					<li>
						<span class="lemon-bullet-text"><?php echo esc_html( $item['text'] ); ?></span>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	<?php else : ?>
		<p><?php esc_html_e( 'No bullets found. Add them in the Product Hero tab.', 'lemon-concentrate' ); ?></p>
	<?php endif; ?>
</div>