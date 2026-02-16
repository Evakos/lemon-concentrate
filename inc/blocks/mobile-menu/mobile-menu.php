<?php
/**
 * Mobile Menu Block Template.
 */

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-mobile-menu-block' ) );

$locations = get_nav_menu_locations();
$menu_id   = isset( $locations['primary'] ) ? $locations['primary'] : 0;
?>
<div <?php echo $wrapper_attributes; ?>>
	<button class="lemon-mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Open Menu', 'lemon-concentrate' ); ?>">
		<span class="lemon-mobile-menu-icon"></span>
	</button>

	<div class="lemon-mobile-menu-drawer">
		<div class="lemon-mobile-menu-header">
			<button class="lemon-mobile-menu-close" aria-label="<?php esc_attr_e( 'Close Menu', 'lemon-concentrate' ); ?>">
				<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
			</button>
		</div>
		<div class="lemon-mobile-menu-content">
			<?php
			if ( $menu_id ) {
				wp_nav_menu( array(
					'menu'            => $menu_id,
					'container'       => 'nav',
					'container_class' => 'lemon-mobile-nav',
					'menu_class'      => 'lemon-mobile-menu-list',
					'depth'           => 2,
				) );
			} else {
				if ( is_user_logged_in() ) {
					echo '<p>' . esc_html__( 'Please assign a menu to the Primary location.', 'lemon-concentrate' ) . '</p>';
				}
			}
			?>
			<div class="lemon-mobile-menu-actions">
				<a class="wp-block-button__link has-white-color has-secondary-background-color has-text-color has-background has-link-color wp-element-button" href="/contact/" style="border-radius:10px; width: 100%; text-align: center; display: block; box-sizing: border-box;">
					<?php esc_html_e( 'Contact Us', 'lemon-concentrate' ); ?>
				</a>
			</div>
		</div>
	</div>
	<div class="lemon-mobile-menu-overlay"></div>
</div>