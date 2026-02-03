document.addEventListener('DOMContentLoaded', function() {
	const sliders = document.querySelectorAll('.lemon-product-slider-container');

	sliders.forEach(slider => {
		const track = slider.querySelector('.lemon-product-slider-track');
		// Get original slides before cloning
		const slides = slider.querySelectorAll('.lemon-product-slide');
		const dotsContainer = slider.querySelector('.lemon-product-slider-dots');
		
		if (!track || slides.length === 0) return;

		let currentIndex = 0;
		const slideCount = slides.length;
		const clonesCount = 5; // Number of visible slides on desktop
		let isTransitioning = false;
		let autoPlayInterval;

		// Clone slides for infinite loop
		for (let i = 0; i < clonesCount; i++) {
			const clone = slides[i % slideCount].cloneNode(true);
			clone.classList.add('is-clone');
			clone.setAttribute('aria-hidden', 'true');
			track.appendChild(clone);
		}

		// Create dots for original slides only
		slides.forEach((_, index) => {
			const dot = document.createElement('div');
			dot.classList.add('lemon-product-slider-dot');
			if (index === 0) dot.classList.add('is-active');
			dot.addEventListener('click', () => {
				if (isTransitioning) return;
				goToSlide(index);
				resetAutoPlay();
			});
			dotsContainer.appendChild(dot);
		});

		const dots = dotsContainer.querySelectorAll('.lemon-product-slider-dot');

		function updateDots(index) {
			// Normalize index for dots
			if (index >= slideCount) index = 0;
			
			dots.forEach(dot => dot.classList.remove('is-active'));
			if (dots[index]) {
				dots[index].classList.add('is-active');
			}
		}

		function goToSlide(index) {
			// Handle loop bounds
			if (index < 0) index = slideCount - 1;
			if (index > slideCount) index = 0;

			currentIndex = index;
			const slideWidth = slides[0].clientWidth;
			const translateX = -(currentIndex * slideWidth);
			
			track.style.transition = 'transform 0.5s ease-in-out';
			track.style.transform = `translateX(${translateX}px)`;
			updateDots(currentIndex);

			// If we reached the clone, snap back to start
			if (currentIndex === slideCount) {
				isTransitioning = true;
				setTimeout(() => {
					track.style.transition = 'none';
					currentIndex = 0;
					const resetTranslateX = 0;
					track.style.transform = `translateX(${resetTranslateX}px)`;
					isTransitioning = false;
				}, 500);
			}
		}

		function nextSlide() {
			if (isTransitioning) return;
			goToSlide(currentIndex + 1);
		}

		function startAutoPlay() {
			autoPlayInterval = setInterval(nextSlide, 5000); // 5 seconds loop
		}

		function resetAutoPlay() {
			clearInterval(autoPlayInterval);
			startAutoPlay();
		}

		// Handle resize to update slide width calculations
		window.addEventListener('resize', () => {
			track.style.transition = 'none';
			const slideWidth = slides[0].clientWidth;
			const translateX = -(currentIndex * slideWidth);
			track.style.transform = `translateX(${translateX}px)`;
		});

		// Initialize
		startAutoPlay();
	});
});