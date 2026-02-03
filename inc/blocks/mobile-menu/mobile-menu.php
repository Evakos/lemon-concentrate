<?php
/**
 * Mobile Menu Block Template.
 */
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-mobile-menu' ) );
?>
<div <?php echo $wrapper_attributes; ?>>
	<button class="lemon-mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Open Menu', 'lemon-concentrate' ); ?>">
		<span class="lemon-mobile-menu-icon"></span>
	</button>
	
	<div class="lemon-mobile-menu-modal">
		<div class="lemon-mobile-menu-content">
			<button class="lemon-mobile-menu-close" aria-label="<?php esc_attr_e( 'Close Menu', 'lemon-concentrate' ); ?>">&times;</button>
			<InnerBlocks />
		</div>
	</div>
</div>