document.addEventListener('DOMContentLoaded', function() {
	// Testimonials Slider
	const carousels = document.querySelectorAll('.lemon-testimonials-carousel');

	carousels.forEach(carousel => {
		const slides = carousel.querySelectorAll('.lemon-testimonial-slide');
		const prevBtn = carousel.querySelector('.lemon-testimonials-prev');
		const nextBtn = carousel.querySelector('.lemon-testimonials-next');
		let currentIndex = 0;
		let interval;

		if (slides.length === 0) return;

		// Ensure first slide is active if not already
		if (!carousel.querySelector('.lemon-testimonial-slide.is-active')) {
			slides[0].classList.add('is-active');
		}

		function showSlide(index) {
			slides.forEach(slide => slide.classList.remove('is-active'));
			slides[index].classList.add('is-active');
		}

		function nextSlide() {
			currentIndex = (currentIndex + 1) % slides.length;
			showSlide(currentIndex);
		}

		function prevSlide() {
			currentIndex = (currentIndex - 1 + slides.length) % slides.length;
			showSlide(currentIndex);
		}

		if (nextBtn) {
			nextBtn.addEventListener('click', (e) => {
				e.preventDefault();
				nextSlide();
				resetInterval();
			});
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', (e) => {
				e.preventDefault();
				prevSlide();
				resetInterval();
			});
		}

		function startInterval() {
			interval = setInterval(nextSlide, 5000);
		}

		function resetInterval() {
			clearInterval(interval);
			startInterval();
		}

		startInterval();
	});

	// Contact Form Submission
	const forms = document.querySelectorAll('.lemon-contact-form-inner');
	forms.forEach(form => {
		form.addEventListener('submit', function(e) {
			e.preventDefault();
			const container = form.closest('.lemon-contact-form');
			const messageContainer = container.querySelector('.lemon-contact-message');
			const submitBtn = form.querySelector('button[type="submit"]');
			const originalBtnText = submitBtn.innerText;
			const ajaxUrl = container.getAttribute('data-ajax-url');

			submitBtn.disabled = true;
			submitBtn.innerText = 'Sending...';
			messageContainer.style.display = 'none';
			messageContainer.className = 'lemon-contact-message'; // Reset classes

			const formData = new FormData(form);

			fetch(ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				submitBtn.disabled = false;
				submitBtn.innerText = originalBtnText;
				messageContainer.style.display = 'block';
				messageContainer.innerHTML = data.data.message || data.data;

				if (data.success) {
					messageContainer.classList.add('success');
					form.reset();
				} else {
					messageContainer.classList.add('error');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				submitBtn.disabled = false;
				submitBtn.innerText = originalBtnText;
				messageContainer.style.display = 'block';
				messageContainer.classList.add('error');
				messageContainer.innerText = 'An error occurred. Please try again.';
			});
		});
	});
});