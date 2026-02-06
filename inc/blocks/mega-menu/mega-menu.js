document.addEventListener('DOMContentLoaded', function() {
	// Toggle on click for items with children
	var toggles = document.querySelectorAll('.lemon-mega-menu-item.has-children > a');
	
	toggles.forEach(function(toggle) {
		toggle.addEventListener('click', function(e) {
			e.preventDefault();
			var parent = this.parentElement;
			
			// Close others
			document.querySelectorAll('.lemon-mega-menu-item.is-open').forEach(function(item) {
				if (item !== parent) {
					item.classList.remove('is-open');
				}
			});
			
			parent.classList.toggle('is-open');
		});
	});

	// Close when clicking outside
	document.addEventListener('click', function(e) {
		if (!e.target.closest('.lemon-mega-menu-item')) {
			document.querySelectorAll('.lemon-mega-menu-item.is-open').forEach(function(item) {
				item.classList.remove('is-open');
			});
		}
	});
});
