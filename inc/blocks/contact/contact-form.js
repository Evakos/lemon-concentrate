document.addEventListener('DOMContentLoaded', function() {
	const forms = document.querySelectorAll('.lemon-contact-form');

	forms.forEach(wrapper => {
		const form = wrapper.querySelector('form');
		const ajaxUrl = wrapper.getAttribute('data-ajax-url');
		const messageContainer = wrapper.querySelector('.lemon-contact-message');
		const submitButton = form.querySelector('button[type="submit"]');
		const originalButtonText = submitButton.innerText;

		form.addEventListener('submit', function(e) {
			e.preventDefault();

			// Disable button and show loading state
			submitButton.disabled = true;
			submitButton.innerText = 'Sending...';
			messageContainer.style.display = 'none';
			messageContainer.className = 'lemon-contact-message'; // Reset classes

			const formData = new FormData(form);

			fetch(ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				submitButton.disabled = false;
				submitButton.innerText = originalButtonText;
				messageContainer.style.display = 'block';

				if (data.success) {
					messageContainer.innerHTML = data.data.message;
					messageContainer.style.color = 'green';
					form.reset();
				} else {
					messageContainer.innerHTML = data.data.message || 'An error occurred.';
					messageContainer.style.color = 'red';
				}
			})
			.catch(error => {
				console.error('Error:', error);
				submitButton.disabled = false;
				submitButton.innerText = originalButtonText;
				messageContainer.style.display = 'block';
				messageContainer.innerHTML = 'An error occurred. Please try again.';
				messageContainer.style.color = 'red';
			});
		});
	});
});