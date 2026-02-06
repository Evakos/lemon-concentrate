<?php
/**
 * Category Colors helper.
 *
 * @package lemon-concentrate
 */

/**
 * Retrieve the main color based on the category slug.
 *
 * @param string $slug The category slug.
 * @return string The Hex color code.
 */
if ( ! function_exists( 'lemon_concentrate_get_category_color' ) ) {
	function lemon_concentrate_get_category_color( $slug ) {
		// Check for ACF override first.
		$term = get_term_by( 'slug', $slug, 'product_category' );
		if ( $term && ! is_wp_error( $term ) && function_exists( 'get_field' ) ) {
			$custom_color = get_field( 'category_color', 'product_category_' . $term->term_id );
			if ( $custom_color ) {
				return $custom_color;
			}
		}

		$colors = array(
			'apple'         => '#E57373',
			'aronia'        => '#9575CD',
			'banana'        => '#eee05f',
			'blackcurrant'  => '#7986CB',
			'cherry'        => '#EF5350',
			'coconut'       => '#A1887F',
			'cranberry'     => '#F06292',
			'grapefruit'    => '#FF8A65',
			'green-grape'   => '#C5E1A5',
			'lemon'         => '#e8d528',
			'lime'          => '#DCE775',
			'mandarin'      => '#FFB74D',
			'mango'         => '#FFD54F',
			'multifruit'    => '#FF8A65',
			'orange'        => '#FFB74D',
			'passion-fruit' => '#BA68C8',
			'peach'         => '#FFE0B2',
			'pear'          => '#AED581',
			'pineapple'     => '#FFF176',
			'pomegranate'   => '#E57373',
			'raspberry'     => '#F06292',
			'red-grape'     => '#CE93D8',
			'default'       => '#CCCCCC',
		);

		$slug = strtolower( $slug );
		return isset( $colors[ $slug ] ) ? $colors[ $slug ] : $colors['default'];
	}
}