document.addEventListener('DOMContentLoaded', function() {
	const sliders = document.querySelectorAll('.lemon-product-slider-container');

	sliders.forEach(slider => {
		const track = slider.querySelector('.lemon-product-slider-track');
		// Get original slides before cloning
		const slides = slider.querySelectorAll('.lemon-product-slide');
		const dotsContainer = slider.querySelector('.lemon-product-slider-dots');
		const prevBtn = slider.querySelector('.lemon-product-slider-prev');
		const nextBtn = slider.querySelector('.lemon-product-slider-next');
		
		if (!track || slides.length === 0) return;

		let currentIndex = 0;
		const slideCount = slides.length;
		const clonesCount = 5; // Number of visible slides on desktop
		let isTransitioning = false;
		let autoPlayInterval;

		// Drag variables
		let isDragging = false;
		let startPos = 0;
		let currentTranslate = 0;
		let prevTranslate = 0;
		let animationID;
		let slideWidth = slides[0].clientWidth;

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

		function getSlideWidth() {
			return slides[0].clientWidth;
		}

		function setSliderPosition() {
			track.style.transform = `translateX(${currentTranslate}px)`;
		}

		function goToSlide(index) {
			// Handle loop bounds
			if (index < 0) index = slideCount - 1;
			// Allow going to slideCount (first clone) for smooth transition
			if (index > slideCount) index = 0;

			currentIndex = index;
			slideWidth = getSlideWidth();
			currentTranslate = -(currentIndex * slideWidth);
			prevTranslate = currentTranslate;
			
			track.style.transition = 'transform 0.5s ease-in-out';
			setSliderPosition();
			updateDots(currentIndex);

			// If we reached the clone, snap back to start
			if (currentIndex === slideCount) {
				isTransitioning = true;
				setTimeout(() => {
					track.style.transition = 'none';
					currentIndex = 0;
					currentTranslate = 0;
					prevTranslate = 0;
					setSliderPosition();
					isTransitioning = false;
				}, 500);
			}
		}

		function nextSlide() {
			if (isTransitioning) return;
			goToSlide(currentIndex + 1);
		}

		function prevSlide() {
			if (isTransitioning) return;
			goToSlide(currentIndex - 1);
		}

		function startAutoPlay() {
			clearInterval(autoPlayInterval);
			autoPlayInterval = setInterval(nextSlide, 5000); // 5 seconds loop
		}

		function resetAutoPlay() {
			clearInterval(autoPlayInterval);
			startAutoPlay();
		}

		// Drag Functions
		function getPositionX(event) {
			return event.type.includes('mouse') ? event.pageX : event.touches[0].pageX;
		}

		function touchStart(event) {
			isDragging = true;
			startPos = getPositionX(event);
			slideWidth = getSlideWidth();
			// Disable transition for direct 1:1 movement
			track.style.transition = 'none';
			animationID = requestAnimationFrame(animation);
			track.style.cursor = 'grabbing';
			clearInterval(autoPlayInterval);
		}

		function touchMove(event) {
			if (isDragging) {
				const currentPosition = getPositionX(event);
				const diff = currentPosition - startPos;
				currentTranslate = prevTranslate + diff;
			}
		}

		function touchEnd() {
			isDragging = false;
			cancelAnimationFrame(animationID);
			track.style.cursor = 'grab';
			
			const movedBy = currentTranslate - prevTranslate;
			
			// Determine snap
			if (movedBy < -50) {
				currentIndex += 1;
			} else if (movedBy > 50) {
				currentIndex -= 1;
			}

			goToSlide(currentIndex);
			startAutoPlay();
		}

		function animation() {
			setSliderPosition();
			if (isDragging) requestAnimationFrame(animation);
		}

		// Event Listeners
		if (prevBtn) {
			prevBtn.addEventListener('click', () => {
				prevSlide();
				resetAutoPlay();
			});
		}

		if (nextBtn) {
			nextBtn.addEventListener('click', () => {
				nextSlide();
				resetAutoPlay();
			});
		}

		track.addEventListener('touchstart', touchStart, {passive: true});
		track.addEventListener('touchend', touchEnd);
		track.addEventListener('touchmove', touchMove, {passive: true});

		track.addEventListener('mousedown', touchStart);
		track.addEventListener('mouseup', touchEnd);
		track.addEventListener('mouseleave', () => { if(isDragging) touchEnd() });
		track.addEventListener('mousemove', touchMove);

		track.style.cursor = 'grab';

		// Handle resize to update slide width calculations
		window.addEventListener('resize', () => {
			track.style.transition = 'none';
			slideWidth = getSlideWidth();
			currentTranslate = -(currentIndex * slideWidth);
			prevTranslate = currentTranslate;
			setSliderPosition();
		});

		// Initialize
		startAutoPlay();
	});
});