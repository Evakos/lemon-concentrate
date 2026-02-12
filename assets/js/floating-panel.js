document.addEventListener('DOMContentLoaded', function() {
	const panel = document.getElementById('lemonFloatingPanel');
	if (!panel) return;

	const triggers = panel.querySelectorAll('.lemon-fp-trigger');
	const contents = panel.querySelectorAll('.lemon-fp-tab-content');
	const closeBtn = panel.querySelector('.lemon-fp-close');

	triggers.forEach(trigger => {
		trigger.addEventListener('click', function() {
			const targetId = this.getAttribute('data-target');
			const targetContent = document.getElementById(targetId);

			// If clicking the already active trigger, close the panel
			if (this.classList.contains('is-active') && panel.classList.contains('is-open')) {
				closePanel();
				return;
			}

			// Reset all
			triggers.forEach(t => t.classList.remove('is-active'));
			contents.forEach(c => c.classList.remove('is-visible'));

			// Activate clicked
			this.classList.add('is-active');
			if (targetContent) {
				targetContent.classList.add('is-visible');
			}

			// Open panel
			panel.classList.add('is-open');
		});
	});

	closeBtn.addEventListener('click', closePanel);

	// Close when clicking outside
	document.addEventListener('click', function(e) {
		if (panel.classList.contains('is-open') && !panel.contains(e.target)) {
			closePanel();
		}
	});

	function closePanel() {
		panel.classList.remove('is-open');
		triggers.forEach(t => t.classList.remove('is-active'));
	}

	// Handle scroll bump
	window.addEventListener('scroll', function() {
		if (window.scrollY > 50) {
			panel.classList.add('is-scrolled-down');
		} else {
			panel.classList.remove('is-scrolled-down');
		}
	});
});