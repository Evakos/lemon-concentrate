document.addEventListener('DOMContentLoaded', function() {
	const toggles = document.querySelectorAll('.lemon-mobile-menu-toggle');
	const closes = document.querySelectorAll('.lemon-mobile-menu-close');

	toggles.forEach(toggle => {
		toggle.addEventListener('click', function(e) {
			e.preventDefault();
			const wrapper = this.closest('.lemon-mobile-menu');
			const modal = wrapper.querySelector('.lemon-mobile-menu-modal');
			
			if (modal) {
				const isOpen = modal.classList.contains('is-open');
				modal.classList.toggle('is-open');
				this.classList.toggle('is-active');
				document.body.style.overflow = isOpen ? '' : 'hidden';
			}
		});
	});

	closes.forEach(close => {
		close.addEventListener('click', function(e) {
			e.preventDefault();
			const wrapper = this.closest('.lemon-mobile-menu');
			const modal = wrapper.querySelector('.lemon-mobile-menu-modal');
			const toggle = wrapper.querySelector('.lemon-mobile-menu-toggle');
			
			if (modal) modal.classList.remove('is-open');
			if (toggle) toggle.classList.remove('is-active');
			document.body.style.overflow = '';
		});
	});
});