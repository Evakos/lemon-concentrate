document.addEventListener( 'DOMContentLoaded', function() {
	const header = document.querySelector( 'header' ) || document.querySelector( '.wp-block-template-part' );

	if ( ! header ) {
		return;
	}

	// Toggle class on scroll
	window.addEventListener( 'scroll', function() {
		if ( window.scrollY > 30 ) {
			header.classList.add( 'is-scrolled' );
		} else {
			header.classList.remove( 'is-scrolled' );
		}
	} );
} );
