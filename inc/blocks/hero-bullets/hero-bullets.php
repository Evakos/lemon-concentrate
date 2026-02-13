<?php
/**
 * Hero Bullets Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Retrieve the repeater field from the current post.
$bullets = get_field( 'hero_bullets', $post_id );

// Fallback to default values if no bullets are saved.
if ( empty( $bullets ) ) {
	$bullets = array(
		array(
			'icon'  => 'tag',
			'title' => 'Product type',
			'text'  => 'Orange pulp cells ingredient for industrial food and beverage manufacturing',
		),
		array(
			'icon'  => 'droplet',
			'title' => 'Core spec',
			'text'  => 'ºBrix 08–16 | pH 2.5–4.2 | Acidity 0.4–1.5 % as citric acid w/w',
		),
		array(
			'icon'  => 'shield',
			'title' => 'Supply focus',
			'text'  => 'Bulk aseptic packed orange pulp cells with refrigerated or frozen storage options',
		),
	);
}

$bullet_count = count( $bullets );

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-hero-bullets' ) );

// Icons map
$icons = array(
	'star'    => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
	'leaf'    => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.77 10-10 10Z"></path><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path></svg>',
	'award'   => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
	'shield'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
	'droplet' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>',
	'tag'     => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>',
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php if ( $bullets ) : ?>
		<ul class="lemon-hero-bullets-list" style="--hero-col-count: <?php echo intval( $bullet_count ); ?>">
			<?php foreach ( $bullets as $bullet ) : ?>
				<li class="lemon-hero-bullet-item">
					<?php 
					$icon_key = isset( $bullet['icon'] ) ? $bullet['icon'] : '';
					if ( ! empty( $icon_key ) && isset( $icons[ $icon_key ] ) ) : ?>
						<span class="lemon-hero-bullet-icon"><?php echo $icons[ $icon_key ]; ?></span>
					<?php endif; ?>
					
					<?php if ( ! empty( $bullet['title'] ) ) : ?>
						<strong class="lemon-hero-bullet-title"><?php echo esc_html( $bullet['title'] ); ?></strong>
					<?php endif; ?>
					<span class="lemon-hero-bullet-text"><?php echo esc_html( $bullet['text'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>