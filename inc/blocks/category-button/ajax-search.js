document.addEventListener('DOMContentLoaded', function() {
	const searchBlocks = document.querySelectorAll('.lemon-ajax-search');

	searchBlocks.forEach(block => {
		const input = block.querySelector('.lemon-ajax-search-input');
		const resultsContainer = block.querySelector('.lemon-ajax-search-results');
		const ajaxUrl = block.getAttribute('data-ajax-url');
		const categoryIcons = JSON.parse(block.getAttribute('data-category-icons') || '{}');
		const matchContainer = block.querySelector('.lemon-search-match-icon');
		let debounceTimer;

		// Hide results on click outside
		document.addEventListener('click', function(e) {
			if (!block.contains(e.target)) {
				resultsContainer.classList.remove('has-results');
			}
		});

		input.addEventListener('input', function() {
			const query = this.value.trim().toLowerCase();

			// Icon Matching Logic
			let matchedUrl = null;
			if (query.length > 1) {
				for (const [name, url] of Object.entries(categoryIcons)) {
					if (name.includes(query)) {
						matchedUrl = url;
						break;
					}
				}
			}

			if (matchedUrl && matchContainer) {
				matchContainer.innerHTML = `<img src="${matchedUrl}" alt="">`;
				matchContainer.classList.add('is-visible');
			} else if (matchContainer) {
				matchContainer.classList.remove('is-visible');
			}

			clearTimeout(debounceTimer);

			if (query.length < 3) {
				resultsContainer.classList.remove('has-results');
				resultsContainer.innerHTML = '';
				block.classList.remove('is-loading');
				return;
			}

			block.classList.add('is-loading');

			debounceTimer = setTimeout(() => {
				fetchResults(query, ajaxUrl, resultsContainer, block);
			}, 500); // 500ms debounce
		});

		input.addEventListener('focus', function() {
			if (resultsContainer.innerHTML !== '' && this.value.length >= 3) {
				resultsContainer.classList.add('has-results');
			}
		});
	});

	function fetchResults(query, url, container, block) {
		const params = new URLSearchParams({
			action: 'lemon_ajax_search',
			term: query
		});

		fetch(`${url}?${params.toString()}`)
			.then(response => response.json())
			.then(data => {
				block.classList.remove('is-loading');
				
				if (data.success && data.data.length > 0) {
					renderResults(data.data, container);
				} else {
					renderNoResults(container);
				}
			})
			.catch(error => {
				console.error('Search Error:', error);
				block.classList.remove('is-loading');
			});
	}

	function renderResults(items, container) {
		let html = '';
		items.forEach(item => {
			html += `
				<a href="${item.url}" class="lemon-search-result-item">
					${item.image ? `<img src="${item.image}" class="lemon-search-result-thumb" alt="">` : ''}
					<span class="lemon-search-result-title">${item.title}</span>
				</a>
			`;
		});
		container.innerHTML = html;
		container.classList.add('has-results');
	}

	function renderNoResults(container) {
		container.innerHTML = '<div class="lemon-search-no-results">No products found.</div>';
		container.classList.add('has-results');
	}
});