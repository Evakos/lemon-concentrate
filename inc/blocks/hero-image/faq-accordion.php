<?php
/**
 * FAQ Accordion Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$items = get_field( 'faq_items' );

// Fallback for preview or empty state
if ( ! $items ) {
	$items = array(
		array(
			'question' => 'What is your return policy?',
			'answer'   => 'We offer a 30-day return policy for all unused items.',
		),
		array(
			'question' => 'Do you ship internationally?',
			'answer'   => 'Yes, we ship to over 50 countries worldwide.',
		),
	);
}

// Generate FAQ Schema
$schema = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array(),
);

foreach ( $items as $item ) {
	if ( ! empty( $item['question'] ) && ! empty( $item['answer'] ) ) {
		$schema['mainEntity'][] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $item['question'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $item['answer'],
			),
		);
	}
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'faq-accordion' ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php foreach ( $items as $item ) : ?>
		<details class="faq-item">
			<summary class="faq-question">
				<?php echo esc_html( $item['question'] ?? '' ); ?>
				<span class="faq-icon" aria-hidden="true">+</span>
			</summary>
			<div class="faq-answer">
				<?php echo wp_kses_post( $item['answer'] ?? '' ); ?>
			</div>
		</details>
	<?php endforeach; ?>

	<?php if ( ! empty( $schema['mainEntity'] ) && ! $is_preview ) : ?>
		<script type="application/ld+json">
			<?php echo wp_json_encode( $schema ); ?>
		</script>
	<?php endif; ?>
</div>