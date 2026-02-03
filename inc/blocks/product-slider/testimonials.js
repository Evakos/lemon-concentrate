document.addEventListener('DOMContentLoaded', function() {
	const carousels = document.querySelectorAll('.lemon-testimonials-carousel');

	carousels.forEach(carousel => {
		const slides = carousel.querySelectorAll('.lemon-testimonial-slide');
		const prevBtn = carousel.querySelector('.lemon-testimonials-prev');
		const nextBtn = carousel.querySelector('.lemon-testimonials-next');
		let currentIndex = 0;

		if (!slides.length || !prevBtn || !nextBtn) return;

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

		nextBtn.addEventListener('click', nextSlide);
		prevBtn.addEventListener('click', prevSlide);
	});
});