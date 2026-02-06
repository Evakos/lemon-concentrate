<?php
/**
 * Simple Menu Block Template.
 *
 * @package lemon-concentrate
 */

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'lemon-simple-menu-block' ) );
$menu_id            = get_field( 'selected_menu' );
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php
	if ( $menu_id ) {
		wp_nav_menu( array(
			'menu'        => $menu_id,
			'container'   => false,
			'menu_class'  => 'lemon-simple-menu',
			'fallback_cb' => false,
			'depth'       => 1,
		) );
	} elseif ( isset( $is_preview ) && $is_preview ) {
		?>
		<ul class="lemon-simple-menu">
			<li><a href="#">Menu Item 1</a></li>
			<li><a href="#">Menu Item 2</a></li>
			<li><a href="#">Menu Item 3</a></li>
		</ul>
		<?php
	} else {
		echo '<p>' . esc_html__( 'Please select a menu in the block settings.', 'lemon-concentrate' ) . '</p>';
	}
	?>
</div>