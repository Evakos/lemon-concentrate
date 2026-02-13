<?php
/**
 * Register ACF Fields programmatically.
 *
 * @package lemon-concentrate
 */

/**
 * Register ACF fields for Product Categories programmatically.
 */
function lemon_concentrate_register_taxonomy_fields() {
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		acf_add_local_field_group( array(
			'key' => 'group_product_category_extras',
			'title' => __( 'Category Settings', 'lemon-concentrate' ),
			'fields' => array(
				array(
					'key' => 'field_product_category_icon',
					'label' => __( 'Icon / Image', 'lemon-concentrate' ),
					'name' => 'icon',
					'type' => 'image',
					'instructions' => __( 'Upload an image or icon for this category.', 'lemon-concentrate' ),
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array(
					'key' => 'field_product_category_color',
					'label' => __( 'Category Color', 'lemon-concentrate' ),
					'name' => 'category_color',
					'type' => 'color_picker',
					'instructions' => __( 'Override the default dynamic color for this category.', 'lemon-concentrate' ),
				),
				array(
					'key' => 'field_product_category_hero_background_image',
					'label' => __( 'Hero Background Image', 'lemon-concentrate' ),
					'name' => 'hero_background_image',
					'type' => 'image',
					'instructions' => __( 'Upload a background image for the category header.', 'lemon-concentrate' ),
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
				),
				array(
					'key' => 'field_product_category_hero_image',
					'label' => __( 'Hero Image', 'lemon-concentrate' ),
					'name' => 'hero_image',
					'type' => 'image',
					'instructions' => __( 'Upload an image for the category content area.', 'lemon-concentrate' ),
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'taxonomy',
						'operator' => '==',
						'value' => 'product_category',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		) );
	}
}
add_action( 'acf/init', 'lemon_concentrate_register_taxonomy_fields' );

/**
 * Register Options Page.
 */
function lemon_concentrate_register_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'page_title' => 'Settings',
			'menu_slug'  => 'settings',
			'position'   => '2.1',
			'redirect'   => false,
			'icon_url'   => 'dashicons-admin-tools',
		) );
	}
}
add_action( 'acf/init', 'lemon_concentrate_register_options_page' );

add_action( 'acf/init', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key' => 'group_6979f0f1dceb0',
		'title' => 'Breadcrumbs',
		'fields' => array(
			array(
				'key' => 'field_6979f0f2916e1',
				'label' => '',
				'name' => '',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'allow_in_bindings' => 0,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/breadcrumbs',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
		'display_title' => '',
	) );

	acf_add_local_field_group( array(
		'key' => 'group_698091aba12c4',
		'title' => 'Global Settings',
		'fields' => array(
			array(
				'key' => 'field_698091aba2ae0',
				'label' => 'Testimonials',
				'name' => 'testimonials',
				'aria-label' => '',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => array(
					array(
						'quote' => 'This is a sample testimonial quote.',
					),
				),
				'layout' => 'table',
				'pagination' => 0,
				'min' => 0,
				'max' => 0,
				'collapsed' => '',
				'button_label' => 'Add Row',
				'rows_per_page' => 20,
				'sub_fields' => array(
					array(
						'key' => 'field_698091b7a2ae1',
						'label' => 'Quote',
						'name' => 'quote',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'parent_repeater' => 'field_698091aba2ae0',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
		'display_title' => '',
	) );

	acf_add_local_field_group( array(
		'key' => 'group_697333eadc5b5',
		'title' => 'Nav Bar',
		'fields' => array(
			array(
				'key' => 'field_697333ebd3ed4',
				'label' => 'Nav Bar',
				'name' => 'nav_bar',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => 'Main Navigation',
				'maxlength' => '',
				'allow_in_bindings' => 0,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'acf/lemon-nav-fixed',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
		'display_title' => '',
	) );

	acf_add_local_field_group( array(
		'key' => 'group_6979e23692bf7',
		'title' => 'Product',
		'fields' => array(
			array(
				'key' => 'field_product_settings_tab',
				'label' => 'Settings',
				'name' => '',
				'aria-label' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
				'selected' => 0,
			),
			array(
				'key' => 'field_product_color_override',
				'label' => 'Product Color Override',
				'name' => 'product_color_override',
				'type' => 'color_picker',
				'instructions' => 'Override the default category color for this product.',
				'return_format' => 'string',
			),
			array(
				'key' => 'field_6982f7a7e4e3d',
				'label' => 'Hero',
				'name' => '',
				'aria-label' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
				'selected' => 0,
			),
			array(
				'key' => 'field_6980f8d86e7ec',
				'label' => 'Hero Image',
				'name' => 'hero_image',
				'aria-label' => '',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'url',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
				'allow_in_bindings' => 0,
				'preview_size' => 'medium',
			),
			array(
				'key' => 'field_hero_bullets',
				'label' => 'Hero Bullets',
				'name' => 'hero_bullets',
				'type' => 'repeater',
				'instructions' => 'Add bullet points to display in the hero section.',
				'layout' => 'table',
				'button_label' => 'Add Bullet',
				'sub_fields' => array(
					array(
						'key' => 'field_hero_bullet_icon',
						'label' => 'Icon',
						'name' => 'icon',
						'type' => 'select',
						'choices' => array(
							'none'    => 'None',
							'star'    => 'Star',
							'leaf'    => 'Leaf',
							'award'   => 'Award',
							'shield'  => 'Shield',
							'droplet' => 'Droplet',
							'tag'     => 'Tag',
						),
						'return_format' => 'value',
						'allow_null' => 1,
					),
					array(
						'key' => 'field_hero_bullet_title',
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_hero_bullet_text',
						'label' => 'Text',
						'name' => 'text',
						'type' => 'text',
					),
				),
				'default_value' => array(
					array(
						'icon'  => 'tag',
						'title' => 'Product type',
						'text'  => '%s ingredient for industrial food and beverage manufacturing',
					),
					array(
						'icon'  => 'droplet',
						'title' => 'Core spec',
						'text'  => 'ºBrix 08–16 | pH 2.5–4.2 | Acidity 0.4–1.5 % as citric acid w/w',
					),
					array(
						'icon'  => 'shield',
						'title' => 'Supply focus',
						'text'  => 'Bulk aseptic packed %s with refrigerated or frozen storage options',
					),
				),
			),
			array(
				'key' => 'field_6982f7bde4e3e',
				'label' => 'Techical Specifications',
				'name' => '',
				'aria-label' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
				'selected' => 0,
			),
			array(
				'key' => 'field_6982f24957239',
				'label' => 'Technical Specifications',
				'name' => 'technical_specifications',
				'aria-label' => '',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_tech_specs_hide',
						'label' => 'Hide Section',
						'name' => 'hide_section',
						'type' => 'true_false',
						'ui' => 1,
					),
					array(
						'key' => 'field_tech_specs_transparent_bg',
						'label' => 'Transparent Background',
						'name' => 'transparent_background',
						'type' => 'true_false',
						'ui' => 1,
					),
					array(
						'key' => 'field_6982f2955723a',
						'label' => 'Title',
						'name' => 'title',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
					'default_value' => 'Technical Specifications',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_6982f2a05723b',
						'label' => 'Introduction',
						'name' => 'introduction',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
					'default_value' => 'Detailed information about the product specifications and requirements.',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_tech_specs_columns',
						'label' => 'Data Columns',
						'name' => 'data_columns',
						'type' => 'repeater',
						'layout' => 'block',
						'button_label' => 'Add Column',
						'default_value' => array(
							array(
								'column_title' => 'Key analytical parameters',
								'items' => array(
									array( 'icon' => 'droplet', 'text' => 'Soluble solids: ºBrix 08–16' ),
									array( 'icon' => 'droplet', 'text' => 'pH range: 2.5–4.2' ),
									array( 'icon' => 'droplet', 'text' => 'Titratable acidity: 0.4–1.5 % as citric acid w/w' ),
								),
							),
							array(
								'column_title' => 'Appearance and sensory',
								'items' => array(
									array( 'icon' => 'tag', 'text' => 'Visual aspect: Characteristic orange cells with defined structure' ),
									array( 'icon' => 'material', 'text' => 'Texture: Uniform orange pulp fiber content supporting mouthfeel and visual pulp level' ),
								),
							),
							array(
								'column_title' => 'Supply formats and storage',
								'items' => array(
									array( 'icon' => 'dimensions', 'text' => 'Packaging format: Aseptic bulk packaging for integration into industrial processing' ),
									array( 'icon' => 'temperature', 'text' => 'Storage options: Refrigerated storage at 4–10 °C; Frozen storage at –18 °C' ),
								),
							),
						),
						'sub_fields' => array(
							array(
								'key' => 'field_column_title',
								'label' => 'Column Title',
								'name' => 'column_title',
								'type' => 'text',
							),
							array(
								'key' => 'field_column_items',
								'label' => 'Items',
								'name' => 'items',
								'type' => 'repeater',
								'layout' => 'table',
								'button_label' => 'Add Item',
								'sub_fields' => array(
									array(
										'key' => 'field_column_item_icon',
										'label' => 'Icon',
										'name' => 'icon',
										'type' => 'select',
										'choices' => array(
											'none'        => 'None',
											'weight'      => 'Weight',
											'dimensions'  => 'Dimensions',
											'material'    => 'Material',
											'temperature' => 'Temperature',
											'warranty'    => 'Warranty',
											'tag'         => 'Tag',
											'droplet'     => 'Droplet',
										),
										'return_format' => 'value',
									),
									array(
										'key' => 'field_column_item_text',
										'label' => 'Text',
										'name' => 'text',
										'type' => 'text',
									),
								),
							),
						),
					),
					array(
						'key' => 'field_698321ec1a49b',
						'label' => 'PDF Download',
						'name' => 'url',
						'aria-label' => '',
						'type' => 'url',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
					),
				),
			),
			array(
				'key' => 'field_mirror_sections_tab',
				'label' => 'Mirror Sections',
				'name' => '',
				'type' => 'tab',
			),
			array(
				'key' => 'field_mirror_sections_repeater',
				'label' => 'Mirror Sections',
				'name' => 'sections',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Row',
				'sub_fields' => array(
					array(
						'key' => 'field_mirror_section_order',
						'label' => 'Order',
						'name' => 'order',
						'type' => 'true_false',
						'ui' => 1,
						'ui_on_text' => 'Left',
						'ui_off_text' => 'Right',
						'default_value' => 1,
					),
					array(
						'key' => 'field_mirror_section_title',
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_mirror_section_image',
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'return_format' => 'url',
						'preview_size' => 'medium',
						'library' => 'all',
					),
					array(
						'key' => 'field_mirror_section_text',
						'label' => 'Text',
						'name' => 'text',
						'type' => 'wysiwyg',
					),
				),
				'default_value' => array(
					array(
						'title' => 'Industrial Processing',
						'text'  => '<p>Our orange pulp cells are processed using state-of-the-art technology to ensure maximum integrity and flavor retention. Suitable for a wide range of industrial applications including beverages, dairy products, and bakery items.</p>',
						'image' => '', 
						'order' => 1,
					),
					array(
						'title' => 'Quality Assurance',
						'text'  => '<p>We adhere to strict quality control measures throughout the manufacturing process. From fruit selection to final packaging, every step is monitored to guarantee a premium product that meets international standards.</p>',
						'image' => '',
						'order' => 0,
					),
				),
			),
			array(
				'key' => 'field_6982f7f1e4e3f',
				'label' => 'Double Sections',
				'name' => '',
				'aria-label' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
				'selected' => 0,
			),
			array(
				'key' => 'field_69806c798ea2c',
				'label' => 'Double Sections',
				'name' => 'double_sections',
				'aria-label' => '',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => array(
					array(
						'title_left' => 'Why Choose LemonConcentrate for %s Supply',
						'text_left' => '<p>LemonConcentrate competes directly with major global producers thanks to its large-scale processing capacity, consistent quality and competitive pricing. Our operations offer full traceability, strict adherence to food-safety regulations, flexible packaging options and the logistical capacity to ship worldwide. We also provide technical support for custom specifications, including adjusted Brix levels, acidity modification and bespoke blends tailored to industrial requirements.</p>',
						'title_right' => 'Ordering, Documentation and Vendor Approval for %s',
						'text_right' => '<p>To support procurement, QA onboarding and repeatable supply, we can provide documentation commonly required in industrial purchasing processes, such as:</p><ul><li>Specification sheet reflecting the commercial and analytical parameters agreed</li><li>Certificate of Analysis per batch on request</li><li>Traceability information and export documentation aligned with destination-market requirements</li><li>Packaging and storage guidance for frozen and aseptic handling</li></ul><p>Lead time, Incoterms, sampling and contract supply planning can be discussed based on format, volume and destination.</p>',
					),
				),
				'layout' => 'block',
				'pagination' => 0,
				'min' => 0,
				'max' => 0,
				'collapsed' => '',
				'button_label' => 'Add Row',
				'rows_per_page' => 20,
				'sub_fields' => array(
					array(
						'key' => 'field_69806c7e8ea2d',
						'label' => 'Title (Left)',
						'name' => 'title_left',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Why Choose LemonConcentrate for %s Supply',
						'parent_repeater' => 'field_69806c798ea2c',
					),
					array(
						'key' => 'field_double_title_right',
						'label' => 'Title (Right)',
						'name' => 'title_right',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => 'Ordering, Documentation and Vendor Approval for %s',
						'parent_repeater' => 'field_69806c798ea2c',
					),
					array(
						'key' => 'field_69806d2fb1ae5',
						'label' => 'Text (Left)',
						'name' => 'text_left',
						'aria-label' => '',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>LemonConcentrate competes directly with major global producers thanks to its large-scale processing capacity, consistent quality and competitive pricing. Our operations offer full traceability, strict adherence to food-safety regulations, flexible packaging options and the logistical capacity to ship worldwide. We also provide technical support for custom specifications, including adjusted Brix levels, acidity modification and bespoke blends tailored to industrial requirements.</p>',
						'allow_in_bindings' => 0,
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
						'parent_repeater' => 'field_69806c798ea2c',
					),
					array(
						'key' => 'field_double_text_right',
						'label' => 'Text (Right)',
						'name' => 'text_right',
						'aria-label' => '',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '<p>To support procurement, QA onboarding and repeatable supply, we can provide documentation commonly required in industrial purchasing processes, such as:</p><ul><li>Specification sheet reflecting the commercial and analytical parameters agreed</li><li>Certificate of Analysis per batch on request</li><li>Traceability information and export documentation aligned with destination-market requirements</li><li>Packaging and storage guidance for frozen and aseptic handling</li></ul><p>Lead time, Incoterms, sampling and contract supply planning can be discussed based on format, volume and destination.</p>',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'parent_repeater' => 'field_69806c798ea2c',
					),
				),
			),
			array(
				'key' => 'field_product_faq_tab',
				'label' => 'FAQ',
				'name' => '',
				'aria-label' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
				'selected' => 0,
			),
			array(
				'key' => 'field_product_faq_header_title',
				'label' => 'Title',
				'name' => 'header_title',
				'type' => 'text',
				'default_value' => 'Key facts about %s supply',
			),
			array(
				'key' => 'field_product_faq_header_intro',
				'label' => 'Intro',
				'name' => 'header_intro',
				'type' => 'textarea',
				'default_value' => 'LemonConcentrate combines European citrus processing expertise with a strong focus on industrial-scale reliability for %s. The company is specialised in supplying bulk citrus ingredients to beverage and food manufacturers, maintaining tight control of ºBrix, pH and acidity so that orange cells perform predictably in-line with existing formulations. Aseptic packaging and cold chain handling are designed for integration into modern, automated plants, while technical documentation supports QA, R&D and procurement evaluations. With a dedicated focus on citrus ingredients such as %s, orange pulp and related components, LemonConcentrate offers a stable, process-ready supply suited to demanding industrial environments.',
				'rows' => 3,
			),
			array(
				'key' => 'field_69832433f6133',
				'label' => 'FAQ',
				'name' => 'faq',
				'aria-label' => '',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => array(
					array(
						'question' => 'What is %s in industrial manufacturing?',
						'answer' => '%s is a high-quality ingredient processed to provide specific texture, mouthfeel, and nutritional value in beverages and foods, supplied as a process-ready bulk ingredient.',
					),
					array(
						'question' => 'What is the typical ºBrix range for %s?',
						'answer' => '%s is produced within a standard soluble solids range, allowing formulators to align the ingredient with the overall beverage brix profile.',
					),
					array(
						'question' => 'How does %s differ from other industrial citrus ingredients?',
						'answer' => 'Compared with other ingredients such as NFC juice or essential oils, this product is focused on delivering structure and visible characteristics rather than just driving flavour intensity.',
					),
					array(
						'question' => 'Which packaging and storage formats are available for %s?',
						'answer' => 'The product is supplied in aseptic bulk packaging, with refrigerated or frozen storage conditions specified so customers can integrate it into their preferred cold chain setup.',
					),
					array(
						'question' => 'Can %s be used together with NFC juices or concentrates?',
						'answer' => 'Yes, it is commonly blended with NFC juices, concentrates, or juice bases to standardise texture while the juice component controls flavour and sweetness.',
					),
					array(
						'question' => 'Are there options for customising specifications for %s?',
						'answer' => 'Customisation options depend on the application and can be evaluated based on process feasibility and volume requirements.',
					),
					array(
						'question' => 'Is %s suitable for applications that require visible pulp fiber?',
						'answer' => 'Yes, the product is specifically developed to provide visible characteristics and fiber in finished beverages and fruit-based foods.',
					),
				),
				'layout' => 'table',
				'pagination' => 0,
				'min' => 0,
				'max' => 0,
				'collapsed' => '',
				'button_label' => 'Add Row',
				'rows_per_page' => 20,
				'sub_fields' => array(
					array(
						'key' => 'field_product_faq_question',
						'label' => 'Question',
						'name' => 'question',
						'type' => 'text',
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
					),
					array(
						'key' => 'field_product_faq_answer',
						'label' => 'Answer',
						'name' => 'answer',
						'type' => 'text',
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'lemon_product',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'excerpt',
			1 => 'discussion',
			2 => 'comments',
			3 => 'revisions',
			4 => 'slug',
			5 => 'author',
			6 => 'format',
			7 => 'page_attributes',
			8 => 'categories',
			9 => 'tags',
			10 => 'send-trackbacks',
		),
		'active' => true,
		'description' => '',
		'show_in_rest' => 1,
		'display_title' => '',
	) );

	acf_add_local_field_group( array(
		'key' => 'group_69732c9a269c4',
		'title' => 'Product Category Loop',
		'fields' => array(
			array(
				'key' => 'field_69732c9ac907c',
				'label' => 'Product Catgegories',
				'name' => 'product_categories',
				'aria-label' => '',
				'type' => 'taxonomy',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'taxonomy' => 'product_category',
				'add_term' => 1,
				'save_terms' => 0,
				'load_terms' => 0,
				'return_format' => 'id',
				'field_type' => 'multi_select',
				'allow_null' => 1,
				'allow_in_bindings' => 0,
				'bidirectional' => 0,
				'multiple' => 0,
				'bidirectional_target' => array(
				),
			),
			array(
				'key' => 'field_697efb02b5586',
				'label' => 'Show All Categories',
				'name' => 'show_all_categories',
				'aria-label' => '',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'allow_in_bindings' => 0,
				'ui' => 0,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/product-category-loop',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
		'display_title' => '',
	) );

	acf_add_local_field_group( array(
		'key' => 'group_697b3c47b816b',
		'title' => 'Ticker',
		'fields' => array(
			array(
				'key' => 'field_697b3c48a8fd4',
				'label' => 'Ticker Item',
				'name' => 'ticker_items',
				'aria-label' => '',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => array(),
				'layout' => 'table',
				'pagination' => 0,
				'min' => 0,
				'max' => 0,
				'collapsed' => '',
				'button_label' => 'Add Row',
				'rows_per_page' => 20,
				'sub_fields' => array(
					array(
						'key' => 'field_697b3c54a8fd5',
						'label' => 'Ticker Item',
						'name' => 'ticker_item',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'parent_repeater' => 'field_697b3c48a8fd4',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/ticker',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
		'display_title' => '',
	) );

	acf_add_local_field_group( array(
		'key' => 'group_6978fbd674ed8',
		'title' => 'FAQ',
		'fields' => array(
			array(
				'key' => 'field_faq_header_label',
				'label' => 'Header Label',
				'name' => 'header_label',
				'type' => 'text',
				'default_value' => 'FAQs',
			),
			array(
				'key' => 'field_faq_header_title',
				'label' => 'Title',
				'name' => 'header_title',
				'type' => 'text',
				'default_value' => 'Key facts about %s supply',
			),
			array(
				'key' => 'field_faq_header_intro',
				'label' => 'Intro',
				'name' => 'header_intro',
				'type' => 'textarea',
				'default_value' => 'LemonConcentrate combines European citrus processing expertise with a strong focus on industrial-scale reliability for %s. The company is specialised in supplying bulk citrus ingredients to beverage and food manufacturers, maintaining tight control of ºBrix, pH and acidity so that orange cells perform predictably in-line with existing formulations. Aseptic packaging and cold chain handling are designed for integration into modern, automated plants, while technical documentation supports QA, R&D and procurement evaluations. With a dedicated focus on citrus ingredients such as %s, orange pulp and related components, LemonConcentrate offers a stable, process-ready supply suited to demanding industrial environments.',
				'rows' => 3,
			),
			array(
				'key' => 'field_faq_button_label',
				'label' => 'Button Label',
				'name' => 'button_label',
				'type' => 'text',
				'default_value' => 'Learn More',
			),
			array(
				'key' => 'field_faq_button_url',
				'label' => 'Button URL',
				'name' => 'button_url',
				'type' => 'url',
				'default_value' => '/shop/',
			),
			array(
				'key' => 'field_6978fbd66c08c',
				'label' => 'FAQ Items',
				'name' => 'faq_items',
				'aria-label' => '',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => array(
					array(
						'question' => 'What is %s in industrial manufacturing?',
						'answer' => '%s is a high-quality ingredient processed to provide specific texture, mouthfeel, and nutritional value in beverages and foods, supplied as a process-ready bulk ingredient.',
					),
					array(
						'question' => 'What is the typical ºBrix range for %s?',
						'answer' => '%s is produced within a standard soluble solids range, allowing formulators to align the ingredient with the overall beverage brix profile.',
					),
					array(
						'question' => 'How does %s differ from other industrial citrus ingredients?',
						'answer' => 'Compared with other ingredients such as NFC juice or essential oils, this product is focused on delivering structure and visible characteristics rather than just driving flavour intensity.',
					),
					array(
						'question' => 'Which packaging and storage formats are available for %s?',
						'answer' => 'The product is supplied in aseptic bulk packaging, with refrigerated or frozen storage conditions specified so customers can integrate it into their preferred cold chain setup.',
					),
					array(
						'question' => 'Can %s be used together with NFC juices or concentrates?',
						'answer' => 'Yes, it is commonly blended with NFC juices, concentrates, or juice bases to standardise texture while the juice component controls flavour and sweetness.',
					),
					array(
						'question' => 'Are there options for customising specifications for %s?',
						'answer' => 'Customisation options depend on the application and can be evaluated based on process feasibility and volume requirements.',
					),
					array(
						'question' => 'Is %s suitable for applications that require visible pulp fiber?',
						'answer' => 'Yes, the product is specifically developed to provide visible characteristics and fiber in finished beverages and fruit-based foods.',
					),
				),
				'layout' => 'table',
				'pagination' => 0,
				'min' => 0,
				'max' => 0,
				'collapsed' => '',
				'button_label' => 'Add Row',
				'rows_per_page' => 20,
				'sub_fields' => array(
					array(
						'key' => 'field_6978fbf96c08d',
						'label' => 'Question',
						'name' => 'question',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'parent_repeater' => 'field_6978fbd66c08c',
					),
					array(
						'key' => 'field_6978fc0b6c08e',
						'label' => 'Answer',
						'name' => 'answer',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'parent_repeater' => 'field_6978fbd66c08c',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/faq',
				),
			),
		),
		'menu_order' => 20,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
		'display_title' => '',
	) );

	acf_add_local_field_group( array(
		'key' => 'group_simple_menu_block',
		'title' => 'Simple Menu Block',
		'fields' => array(
			array(
				'key' => 'field_simple_menu_select',
				'label' => 'Select Menu',
				'name' => 'selected_menu',
				'type' => 'select',
				'instructions' => 'Select the menu to display.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(), // Populated via filter
				'default_value' => false,
				'allow_null' => 1,
				'multiple' => 0,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'id',
				'placeholder' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/simple-menu',
				),
			),
		),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_floating_panel',
		'title' => 'Floating Panel',
		'fields' => array(
			array(
				'key' => 'field_fp_contact',
				'label' => 'Contact Content',
				'name' => 'floating_panel_contact',
				'type' => 'wysiwyg',
				'media_upload' => 0,
				'toolbar' => 'basic',
			),
			array(
				'key' => 'field_fp_map',
				'label' => 'Map Embed Code',
				'name' => 'floating_panel_map',
				'type' => 'textarea',
				'instructions' => 'Paste the Google Maps iframe embed code here.',
			),
			array(
				'key' => 'field_fp_whatsapp',
				'label' => 'WhatsApp Number',
				'name' => 'floating_panel_whatsapp',
				'type' => 'text',
				'instructions' => 'Enter phone number with country code (e.g., 34600000000).',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'settings',
				),
			),
		),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_ajax_search_block',
		'title' => 'AJAX Search Settings',
		'fields' => array(
			array(
				'key' => 'field_ajax_search_placeholder',
				'label' => 'Placeholder Text',
				'name' => 'placeholder_text',
				'type' => 'text',
				'instructions' => 'Text to display inside the search input.',
				'default_value' => 'Search products...',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/ajax-search',
				),
			),
		),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_contact_form_block',
		'title' => 'Contact Form Settings',
		'fields' => array(
			array(
				'key' => 'field_contact_label',
				'label' => 'Label',
				'name' => 'label',
				'type' => 'text',
				'default_value' => 'Contact us',
			),
			array(
				'key' => 'field_contact_title',
				'label' => 'Title',
				'name' => 'title',
				'type' => 'text',
				'default_value' => 'We will be happy to assist you',
			),
			array(
				'key' => 'field_contact_text',
				'label' => 'Introduction Text',
				'name' => 'text',
				'type' => 'textarea',
				'default_value' => 'Email us and our team will answer all your needs.',
				'rows' => 3,
			),
			array(
				'key' => 'field_contact_bg_color',
				'label' => 'Info Background Color',
				'name' => 'info_background_color',
				'type' => 'text',
				'instructions' => 'Enter a hex color (e.g. #000000) or a CSS gradient (e.g. linear-gradient(...)).',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/contact',
				),
			),
		),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_category_button',
		'title' => 'Category Button Settings',
		'fields' => array(
			array(
				'key' => 'field_cat_btn_label',
				'label' => 'Label Format',
				'name' => 'label_format',
				'type' => 'text',
				'instructions' => 'Use %s to include the category name (e.g., "Back to %s").',
				'default_value' => 'Related Products',
			),
			array(
				'key' => 'field_cat_btn_style',
				'label' => 'Button Style',
				'name' => 'button_style',
				'type' => 'select',
				'choices' => array(
					'dark'  => 'Dark',
					'light' => 'Light (White)',
				),
				'default_value' => 'dark',
			),
			array(
				'key' => 'field_cat_btn_no_shadow',
				'label' => 'Remove Box Shadow',
				'name' => 'remove_box_shadow',
				'type' => 'true_false',
				'ui' => 1,
				'default_value' => 1,
			),
			array(
				'key' => 'field_cat_btn_hide_icon',
				'label' => 'Hide Icon',
				'name' => 'hide_icon',
				'type' => 'true_false',
				'ui' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/category-button',
				),
			),
		),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_mirror_section_block_settings',
		'title' => 'Mirror Section Settings',
		'fields' => array(
			array(
				'key' => 'field_mirror_display_mode',
				'label' => 'Rows to Display',
				'name' => 'mirror_section_display_mode',
				'type' => 'select',
				'instructions' => 'Select which rows from the product data to display in this block instance.',
				'choices' => array(
					'all'      => 'Show All',
					'first_2'  => 'First 2 Rows',
					'offset_2' => 'Skip First 2 Rows',
				),
				'default_value' => 'all',
				'ui' => 0,
			),
			array(
				'key' => 'field_mirror_transparent_bg',
				'label' => 'Transparent Background',
				'name' => 'mirror_section_transparent_bg',
				'type' => 'true_false',
				'ui' => 1,
			),
			array(
				'key' => 'field_mirror_include_contact',
				'label' => 'Include Contact Form',
				'name' => 'mirror_section_include_contact',
				'type' => 'true_false',
				'ui' => 1,
			),
			array(
				'key' => 'field_mirror_contact_position',
				'label' => 'Contact Form Position',
				'name' => 'mirror_section_contact_position',
				'type' => 'number',
				'instructions' => 'Insert the contact form after this row number.',
				'default_value' => 2,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_mirror_include_contact',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
			),
			array(
				'key' => 'field_mirror_contact_label',
				'label' => 'Contact Label',
				'name' => 'mirror_contact_label',
				'type' => 'text',
				'default_value' => 'Contact us',
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_mirror_include_contact',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
			),
			array(
				'key' => 'field_mirror_contact_title',
				'label' => 'Contact Title',
				'name' => 'mirror_contact_title',
				'type' => 'text',
				'default_value' => 'We will be happy to assist you',
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_mirror_include_contact',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
			),
			array(
				'key' => 'field_mirror_contact_text',
				'label' => 'Contact Text',
				'name' => 'mirror_contact_text',
				'type' => 'textarea',
				'default_value' => 'Email us and our team will answer all your needs.',
				'rows' => 3,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_mirror_include_contact',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
			),
			array(
				'key' => 'field_mirror_contact_bg_color',
				'label' => 'Contact Info Background',
				'name' => 'mirror_contact_bg_color',
				'type' => 'text',
				'instructions' => 'Enter a hex color (e.g. #000000) or a CSS gradient (e.g. linear-gradient(...)).',
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_mirror_include_contact',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/mirror-section',
				),
			),
		),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_double_section_block_settings',
		'title' => 'Double Section Settings',
		'fields' => array(
			array(
				'key' => 'field_double_transparent_bg',
				'label' => 'Transparent Background',
				'name' => 'double_section_transparent_bg',
				'type' => 'true_false',
				'ui' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/double-section',
				),
			),
		),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_product_slider_settings',
		'title' => 'Product Slider Settings',
		'fields' => array(
			array(
				'key' => 'field_product_slider_minimal',
				'label' => 'Minimal Style (No Background)',
				'name' => 'minimal_style',
				'type' => 'true_false',
				'ui' => 1,
			),
			array(
				'key' => 'field_product_slider_hide_title',
				'label' => 'Hide Product Title',
				'name' => 'hide_title',
				'type' => 'true_false',
				'ui' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'lemon-concentrate/product-slider',
				),
			),
		),
	) );
} );

function lemon_concentrate_populate_menu_select( $field ) {
	$field['choices'] = array();
	$menus = wp_get_nav_menus();
	if ( $menus ) {
		foreach ( $menus as $menu ) {
			$field['choices'][ $menu->term_id ] = $menu->name;
		}
	}
	return $field;
}
add_filter( 'acf/load_field/name=selected_menu', 'lemon_concentrate_populate_menu_select' );

/**
 * Temporary data update for Product 283.
 * This can be removed after the update has run.
 */
add_action( 'init', function() {
	// Only run if ACF is active
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	// Run once
	if ( get_option( 'lemon_product_283_data_imported_mirror' ) ) {
		return;
	}

	$post_id = 283;
	
	// Ensure post exists
	if ( ! get_post( $post_id ) ) {
		return;
	}

	$mirror_sections = array(
		array(
			'title' => 'Specifications',
			'text'  => '<ul><li>Soluble solids: 51.0–55.0 °Brix</li><li>Titratable acidity: 12.0–15.0% (as citric acid)</li><li>pH: &lt; 4.0</li><li>Product type: Cranberry Concentrate</li><li>Intended use: Diluted use in industrial food applications</li><li>Storage conditions: Refrigerated (4–10°C) or frozen (-18°C) recommended</li></ul>',
			'order' => 1, // Left
			'image' => '',
		),
		array(
			'title' => 'Process & Quality',
			'text'  => '<ul><li>Filled using aseptic filling to support product safety and shelf-life performance under recommended conditions.</li><li>Formulated and supplied as allergen-free according to EU Regulation 1169/2011 Annex II (as stated).</li><li>Manufactured using raw materials not produced from GMO origins (as stated).</li><li>Not subjected to irradiation processes (as stated).</li><li>Compliant with pesticide residue limits according to EC 396/2005 (as amended).</li><li>Compliant with contaminant limits according to EC 915/2023 (as amended).</li><li>Where applicable, flavor-related aspects are aligned with EC 1334/2008.</li></ul>',
			'order' => 0, // Right
			'image' => '',
		),
		array(
			'title' => 'Packaging & Logistics',
			'text'  => '<ul><li>Packaging formats offered: metal drums with inner aluminum laminated bag and outer PE protective bag.</li><li>Transport and storage conditions: refrigerated at 4–10°C or frozen at -18°C.</li><li>Shelf life under recommended conditions: 9 months refrigerated; 18 months frozen.</li></ul>',
			'order' => 1, // Left
			'image' => '',
		),
		array(
			'title' => 'Applications',
			'text'  => '<ul><li>Diluted use in food industrial applications requiring standardized cranberry concentrate.</li><li>RTD beverage formulation based on cranberry profiles, with recommended dosage guidance available for 1000 L RTD batches.</li><li>Use as a cranberry flavor and color base in multi-fruit beverage systems.</li><li>Component in syrups or concentrates for further dilution by co-packers and industrial blenders.</li><li>Ingredient in functional-style beverage concepts where cranberry character is required.</li><li>Acidic fruit base for culinary or sauce-type industrial preparations that are further processed.</li><li>Use in industrial-scale trials and pilot formulations requiring controlled Brix and acidity input.</li></ul>',
			'order' => 0, // Right
			'image' => '',
		),
		array(
			'title' => 'Ordering & Documents',
			'text'  => '<ul><li>Product Technical Specification available to support formulation, QA review and regulatory assessment.</li></ul>',
			'order' => 1, // Left
			'image' => '',
		),
	);

	update_field( 'sections', $mirror_sections, $post_id );
	update_option( 'lemon_product_283_data_imported_mirror', true );
} );

/**
 * Temporary data update for Product 283 FAQs.
 */
add_action( 'init', function() {
	// Only run if ACF is active
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	// Run once
	if ( get_option( 'lemon_product_283_data_imported_faq' ) ) {
		return;
	}

	$post_id = 283;
	
	// Ensure post exists
	if ( ! get_post( $post_id ) ) {
		return;
	}

	$faqs = array(
		array(
			'question' => 'What are the key analytical specifications of this cranberry concentrate?',
			'answer'   => 'The concentrate is standardized to 51.0–55.0 °Brix, with titratable acidity at 12.0–15.0% expressed as citric acid, and pH below 4.0. These parameters enable predictable performance when designing dilution ratios and balancing sweetness–acidity in finished products.',
		),
		array(
			'question' => 'How should the cranberry concentrate be stored and handled?',
			'answer'   => 'It should be transported and stored either refrigerated at 4–10°C or frozen at -18°C. Under these conditions, the shelf life is 9 months in refrigeration and 18 months when frozen. Industrial users should maintain the cold chain and follow standard thawing and handling practices for concentrates.',
		),
		array(
			'question' => 'Is the product suitable for allergen-sensitive formulations?',
			'answer'   => 'Yes. The cranberry concentrate is declared allergen-free in line with EU Regulation 1169/2011 Annex II (as stated), making it suitable for use in formulations where exclusion of listed allergens is required, subject to the customer’s own risk assessment and validation.',
		),
		array(
			'question' => 'Can this cranberry concentrate be used in RTD beverages?',
			'answer'   => 'Yes. It is intended for diluted industrial use, including RTD beverage formulation. Recommended dosage guidance is available for 1000 L RTD batches, helping formulators to achieve the desired cranberry character while respecting the defined Brix and acidity ranges.',
		),
		array(
			'question' => 'Does the product comply with EU pesticide and contaminant regulations?',
			'answer'   => 'The product is aligned with EU requirements, with pesticides according to EC 396/2005 and contaminants according to EC 915/2023 (both as amended). This supports regulatory compliance checks for food and beverage manufacturers operating in or supplying to the EU market.',
		),
		array(
			'question' => 'What packaging is offered for industrial supply?',
			'answer'   => 'The cranberry concentrate is supplied in metal drums incorporating an inner aluminum laminated bag and an outer PE protective bag. This configuration is designed for food-contact suitability, product protection during transport, and compatibility with typical industrial emptying and transfer systems.',
		),
		array(
			'question' => 'Is the concentrate GMO or irradiated?',
			'answer'   => 'The product is stated as non-GMO, meaning it is not produced from GMO-origin raw materials, and it is not irradiated (as stated). These attributes assist manufacturers in meeting internal standards and external market expectations related to GMO and irradiation policies.',
		),
	);

	update_field( 'faq', $faqs, $post_id );
	update_option( 'lemon_product_283_data_imported_faq', true );
} );