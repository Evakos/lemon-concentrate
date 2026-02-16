document.addEventListener('DOMContentLoaded', function() {
	const filterToggle = document.querySelector('.lemon-filter-toggle-btn');
	const filterModal = document.querySelector('.lemon-filter-modal');
	const filterClose = document.querySelector('.lemon-filter-close-btn');

	if (filterToggle && filterModal && filterClose) {
		function openFilters() {
			filterModal.classList.add('is-open');
			document.body.style.overflow = 'hidden';
		}

		function closeFilters() {
			filterModal.classList.remove('is-open');
			document.body.style.overflow = '';
		}

		filterToggle.addEventListener('click', function(e) {
			e.preventDefault();
			openFilters();
		});

		filterClose.addEventListener('click', function(e) {
			e.preventDefault();
			closeFilters();
		});
	}
});