<?php
/**
 * FAQ Block Template.
 */

$header_label = get_field( 'header_label' ) ?: 'FAQ';
$header_title = get_field( 'header_title' ) ?: 'Key facts about %s supply';
$header_intro = get_field( 'header_intro' ) ?: 'LemonConcentrate combines European citrus processing expertise with a strong focus on industrial-scale reliability for %s. The company is specialised in supplying bulk citrus ingredients to beverage and food manufacturers, maintaining tight control of ºBrix, pH and acidity so that orange cells perform predictably in-line with existing formulations. Aseptic packaging and cold chain handling are designed for integration into modern, automated plants, while technical documentation supports QA, R&D and procurement evaluations. With a dedicated focus on citrus ingredients such as %s, orange pulp and related components, LemonConcentrate offers a stable, process-ready supply suited to demanding industrial environments.';
$button_label = get_field( 'button_label' ) ?: 'Learn More';
$button_url   = get_field( 'button_url' ) ?: '#';

$product_title = get_the_title();
if ( empty( $product_title ) ) {
	$product_title = 'the product';
}

// Replace placeholders in header
$header_title = str_replace( '%s', $product_title, $header_title );
$header_intro = str_replace( '%s', $product_title, $header_intro );
$header_title = str_ireplace( 'orange pulp cells', $product_title, $header_title );
$header_intro = str_ireplace( 'orange pulp cells', $product_title, $header_intro );

$faq_items = get_field( 'faq_items' );

if ( empty( $faq_items ) ) {
	$faq_items = get_field( 'faq', $post_id );
}

if ( empty( $faq_items ) && ! empty( $is_preview ) ) {
	$faq_items = array(
		array(
			'question' => sprintf( 'What is %s in industrial manufacturing?', $product_title ),
			'answer'   => sprintf( '%s is a high-quality ingredient processed to provide specific texture, mouthfeel, and nutritional value in beverages and foods, supplied as a process-ready bulk ingredient.', $product_title ),
		),
		array(
			'question' => sprintf( 'What is the typical ºBrix range for %s?', $product_title ),
			'answer'   => sprintf( '%s is produced within a standard soluble solids range, allowing formulators to align the ingredient with the overall beverage brix profile.', $product_title ),
		),
		array(
			'question' => sprintf( 'How does %s differ from other industrial citrus ingredients?', $product_title ),
			'answer'   => 'Compared with other ingredients such as NFC juice or essential oils, this product is focused on delivering structure and visible characteristics rather than just driving flavour intensity.',
		),
		array(
			'question' => sprintf( 'Which packaging and storage formats are available for %s?', $product_title ),
			'answer'   => 'The product is supplied in aseptic bulk packaging, with refrigerated or frozen storage conditions specified so customers can integrate it into their preferred cold chain setup.',
		),
		array(
			'question' => sprintf( 'Can %s be used together with NFC juices or concentrates?', $product_title ),
			'answer'   => 'Yes, it is commonly blended with NFC juices, concentrates, or juice bases to standardise texture while the juice component controls flavour and sweetness.',
		),
		array(
			'question' => sprintf( 'Are there options for customising specifications for %s?', $product_title ),
			'answer'   => 'Customisation options depend on the application and can be evaluated based on process feasibility and volume requirements.',
		),
		array(
			'question' => sprintf( 'Is %s suitable for applications that require visible pulp fiber?', $product_title ),
			'answer'   => 'Yes, the product is specifically developed to provide visible characteristics and fiber in finished beverages and fruit-based foods.',
		),
	);
}

if ( empty( $faq_items ) ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-faq-block' ) );

$schema = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array(),
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<div class="lemon-faq-header">
		<h5 class="lemon-faq-label"><?php echo esc_html( $header_label ); ?></h5>
		
		<div class="lemon-faq-intro">
			<h2 class="lemon-faq-title"><?php echo esc_html( $header_title ); ?></h2>
			<p class="lemon-faq-text"><?php echo esc_html( $header_intro ); ?></p>
		</div>

		<div class="lemon-faq-actions">
			<a class="wp-block-button__link lemon-faq-button" href="<?php echo esc_url( $button_url ); ?>">
				<?php echo esc_html( $button_label ); ?>
			</a>
		</div>
	</div>

	<?php if ( $faq_items ) : ?>
		<div class="lemon-faq-accordion">
			<?php foreach ( $faq_items as $index => $item ) : ?>
				<?php
				// Allow %s placeholder in custom text to be replaced by product title
				$question = str_replace( '%s', $product_title, $item['question'] );
				$answer   = str_replace( '%s', $product_title, $item['answer'] );

				// Also replace hardcoded "Orange pulp cells" if present (case-insensitive)
				$question = str_ireplace( 'orange pulp cells', $product_title, $question );
				$answer   = str_ireplace( 'orange pulp cells', $product_title, $answer );

				$schema['mainEntity'][] = array(
					'@type'          => 'Question',
					'name'           => wp_strip_all_tags( $question ),
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => $answer,
					),
				);
				?>
				<div class="lemon-faq-item">
					<button class="lemon-faq-question" aria-expanded="false">
						<span class="lemon-faq-question-text"><?php echo esc_html( $question ); ?></span>
						<span class="lemon-faq-icon"></span>
					</button>
					<div class="lemon-faq-answer">
						<div class="lemon-faq-answer-inner">
							<?php echo wp_kses_post( $answer ); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if ( ! empty( $schema['mainEntity'] ) && ! $is_preview ) : ?>
		<script type="application/ld+json">
			<?php echo wp_json_encode( $schema ); ?>
		</script>
	<?php endif; ?>
</div>
<style>
	.lemon-faq-header {
		display: grid;
		grid-template-columns: 1fr 970px 1fr;
		align-items: start;
		margin-bottom: 3rem;
	}
	.lemon-faq-label {
		font-size: 1.1rem;
		text-transform: uppercase;
		letter-spacing: 1px;
		margin: 0;
		font-weight: 500;
	}
	.lemon-faq-accordion {
		background-color: #F9F9F9;
		padding: 0rem 2rem;
		border-radius: 8px;
		margin: 0 auto;
		border: 1px solid #bdbdbd;
		max-width: 1000px;
		width: 970px;
	}
	.lemon-faq-button {
		box-shadow: none !important;
	}
	.lemon-faq-intro {
		grid-column: 2;
	}
	.lemon-faq-actions {
		justify-self: end;
	}
	@media (max-width: 1300px) {
		.lemon-faq-header {
			display: flex;
			flex-direction: column;
			gap: 2rem;
		}
		.lemon-faq-accordion {
			width: 100%;
		}
	}
	.lemon-faq-question[aria-expanded="true"] .lemon-faq-icon {
		transform: none;
		background-color: white;
		width: 30px;
		height: 30px;
		display: flex;
		justify-content: center;
		align-items: center;
		border-radius: 100px;
	}
</style>