document.addEventListener('DOMContentLoaded', function() {
	const toggles = document.querySelectorAll('.lemon-mobile-menu-toggle');
	
	toggles.forEach(toggle => {
		const block = toggle.closest('.lemon-mobile-menu-block');
		const drawer = block.querySelector('.lemon-mobile-menu-drawer');
		const closeBtn = block.querySelector('.lemon-mobile-menu-close');
		const overlay = block.querySelector('.lemon-mobile-menu-overlay');

		function openMenu() {
			drawer.classList.add('is-open');
			overlay.classList.add('is-open');
			document.body.style.overflow = 'hidden';
		}

		function closeMenu() {
			drawer.classList.remove('is-open');
			overlay.classList.remove('is-open');
			document.body.style.overflow = '';
		}

		toggle.addEventListener('click', openMenu);
		closeBtn.addEventListener('click', closeMenu);
		overlay.addEventListener('click', closeMenu);
	});
});