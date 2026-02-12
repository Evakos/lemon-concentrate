document.addEventListener('DOMContentLoaded', function() {
	const faqItems = document.querySelectorAll('.lemon-faq-question');
	
	faqItems.forEach(item => {

		item.addEventListener('click', function() {
			const expanded = this.getAttribute('aria-expanded') === 'true';
			const answer = this.nextElementSibling;
			
			// Close any open items
			faqItems.forEach(otherItem => {
				if (otherItem !== this && otherItem.getAttribute('aria-expanded') === 'true') {
					otherItem.setAttribute('aria-expanded', 'false');
					otherItem.nextElementSibling.style.maxHeight = null;
				}
			});

			// Toggle clicked item
			if (expanded) {
				this.setAttribute('aria-expanded', 'false');
				answer.style.maxHeight = null;
			} else {
				this.setAttribute('aria-expanded', 'true');
				answer.style.maxHeight = answer.scrollHeight + "px";
			}
		});
	});
});