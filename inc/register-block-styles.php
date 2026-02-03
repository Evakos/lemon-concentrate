<?php
/**
 * Block styles.
 *
 * @package lemon-concentrate
 * @since 1.0.0
 */

/**
 * Register block styles
 *
 * @since 1.0.0
 *
 * @return void
 */
function lemon_concentrate_register_block_styles() {

	register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
		'core/button',
		array(
			'name'  => 'lemon-concentrate-flat-button',
			'label' => __( 'Flat button', 'lemon-concentrate' ),
		)
	);

	register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
		'core/list',
		array(
			'name'  => 'lemon-concentrate-list-underline',
			'label' => __( 'Underlined list items', 'lemon-concentrate' ),
		)
	);

	register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
		'core/group',
		array(
			'name'  => 'lemon-concentrate-box-shadow',
			'label' => __( 'Box shadow', 'lemon-concentrate' ),
		)
	);

	register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
		'core/column',
		array(
			'name'  => 'lemon-concentrate-box-shadow',
			'label' => __( 'Box shadow', 'lemon-concentrate' ),
		)
	);

	register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
		'core/columns',
		array(
			'name'  => 'lemon-concentrate-box-shadow',
			'label' => __( 'Box shadow', 'lemon-concentrate' ),
		)
	);

	register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
		'core/details',
		array(
			'name'  => 'lemon-concentrate-plus',
			'label' => __( 'Plus & minus', 'lemon-concentrate' ),
		)
	);
}
add_action( 'init', 'lemon_concentrate_register_block_styles' );

/**
 * This is an example of how to unregister a core block style.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-styles/
 * @see https://github.com/WordPress/gutenberg/pull/37580
 *
 * @since 1.0.0
 *
 * @return void
 */
function lemon_concentrate_unregister_block_style() {
	wp_enqueue_script(
		'lemon-concentrate-unregister',
		get_stylesheet_directory_uri() . '/assets/js/unregister.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
		LEMON_CONCENTRATE_VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'lemon_concentrate_unregister_block_style' );
