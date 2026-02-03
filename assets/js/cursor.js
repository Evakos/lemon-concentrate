document.addEventListener( 'DOMContentLoaded', function() {
	// Check if device supports hover (desktop)
	if ( window.matchMedia( '(hover: none)' ).matches ) {
		return;
	}

	const cursor = document.createElement( 'div' );
	cursor.classList.add( 'custom-cursor' );
	document.body.appendChild( cursor );

	const moveCursor = ( e ) => {
		cursor.style.left = e.clientX + 'px';
		cursor.style.top = e.clientY + 'px';
	};

	window.addEventListener( 'mousemove', moveCursor );

	// Expand on clickable elements
	const clickables = 'a, button, .wp-block-button__link, input[type="submit"], input[type="button"], .clickable';

	document.addEventListener( 'mouseover', function( e ) {
		if ( e.target.closest( clickables ) ) {
			cursor.classList.add( 'is-expanded' );
		}
	} );

	document.addEventListener( 'mouseout', function( e ) {
		if ( e.target.closest( clickables ) ) {
			cursor.classList.remove( 'is-expanded' );
		}
	} );
} );