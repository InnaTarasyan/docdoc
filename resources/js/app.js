import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

function debounce(fn, wait) {
	let t;
	return function (...args) {
		clearTimeout(t);
		t = setTimeout(() => fn.apply(this, args), wait);
	};
}

async function ajaxLoadList(form, url) {
	const resultsSel = form.getAttribute('data-results') || '#results';
	const citySelectSel = form.getAttribute('data-city-select') || null;
	const results = document.querySelector(resultsSel);
	if (!results) return;

	const u = new URL(url || form.action, window.location.origin);
	const formData = new FormData(form);
	
	// Check if 'q' parameter is empty
	let qValue = formData.get('q') || '';
	if (qValue) {
		qValue = qValue.trim();
	}
	
	// If 'q' is empty and we're on search page, redirect to home
	if (!qValue && u.pathname === '/search') {
		history.pushState({}, '', '/');
		// Optionally reload the page or load home content
		window.location.href = '/';
		return;
	}
	
	for (const [key, value] of formData.entries()) {
		// Remove empty 'q' parameter instead of setting it
		if (key === 'q' && (!value || value.trim() === '')) {
			u.searchParams.delete('q');
		} else {
			u.searchParams.set(key, value);
		}
	}

	const res = await fetch(u.toString(), { headers: { 'Accept': 'application/json' } });
	if (!res.ok) return;
	const data = await res.json();

	if (data.html) {
		results.innerHTML = data.html;
	}
	if (citySelectSel && data.citiesHtml) {
		const citySelect = document.querySelector(citySelectSel);
		if (citySelect) {
			citySelect.innerHTML = data.citiesHtml;
		}
	}
	if (data.url) {
		// Update URL - if it's home page, navigate there
		const urlObj = new URL(data.url, window.location.origin);
		if (urlObj.pathname === '/' || urlObj.pathname === '') {
			history.pushState({}, '', '/');
			window.location.href = '/';
		} else {
			history.pushState({}, '', urlObj.toString());
		}
	}
}

function wireAjaxFilters() {
	document.querySelectorAll('form.ajax-filter-form[data-ajax-list="true"]').forEach(form => {
		const handler = debounce(() => ajaxLoadList(form), 250);
		form.addEventListener('input', handler);
		form.addEventListener('change', handler);
		form.addEventListener('submit', (e) => {
			e.preventDefault();
			ajaxLoadList(form);
		});

		// Pagination delegation
		const resultsSel = form.getAttribute('data-results') || '#results';
		const results = document.querySelector(resultsSel);
		if (results) {
			results.addEventListener('click', (e) => {
				const a = e.target.closest('a');
				if (!a) return;
				// Laravel paginator links have query params; intercept only same-path links
				if (a.href && a.getAttribute('href').includes('?')) {
					e.preventDefault();
					ajaxLoadList(form, a.href);
				}
			});
		}
	});

	window.addEventListener('popstate', () => {
		document.querySelectorAll('form.ajax-filter-form[data-ajax-list="true"]').forEach(form => {
			ajaxLoadList(form, location.href);
		});
	});
}

document.addEventListener('DOMContentLoaded', wireAjaxFilters);

// Initialize Select2 for home search
function initHomeSearchSelect2() {
	const select = document.getElementById('home-search-select');
	if (!select || typeof $ === 'undefined') return;

	const prefersDesktop = window.matchMedia('(min-width: 640px)').matches;

	const $select = $(select);

	if (!prefersDesktop) {
		if ($select.data('select2')) {
			$select.select2('destroy');
		}
		return;
	}

	// Destroy existing Select2 instance if any
	if ($select.data('select2')) {
		$select.select2('destroy');
	}

	$select.select2({
		theme: 'bootstrap-5',
		placeholder: select.getAttribute('data-placeholder') || 'Search doctors, specialties, or cities',
		allowClear: true,
		minimumInputLength: 2, // Require 2 characters for autocomplete suggestions
		tags: true, // Allow custom text input
		createTag: function (params) {
			// Allow creating tags from user input
			const term = $.trim(params.term);
			if (term === '') {
				return null;
			}
			return {
				id: term,
				text: term,
				newTag: true
			};
		},
		ajax: {
			url: '/api/search/autocomplete',
			dataType: 'json',
			delay: 300,
			data: function (params) {
				return {
					q: params.term,
				};
			},
			processResults: function (data) {
				return {
					results: data.results.map(function(item) {
						return {
							id: item.text,
							text: item.text,
							subtitle: item.subtitle,
							type: item.type,
							url: item.url,
						};
					}),
				};
			},
			cache: true,
		},
		templateResult: function(item) {
			if (item.loading) {
				return item.text;
			}
			const $container = $('<div class="select2-result-item"></div>');
			$container.append($('<div class="select2-result-item-title">' + item.text + '</div>'));
			if (item.subtitle) {
				$container.append($('<div class="select2-result-item-subtitle text-sm text-gray-500">' + item.subtitle + '</div>'));
			}
			return $container;
		},
		templateSelection: function(item) {
			return item.text || item.id;
		},
	});

	// Handle selection - if URL is available, navigate directly, otherwise submit form
	$select.on('select2:select', function (e) {
		const data = e.params.data;
		if (data.url) {
			window.location.href = data.url;
		} else {
			// For custom text input, submit the form
			const form = document.getElementById('home-search-form');
			if (form) {
				form.submit();
			}
		}
	});

	// Handle Enter key in Select2 search input to submit form
	$select.on('select2:open', function() {
		setTimeout(function() {
			const searchInput = $select.data('select2').$dropdown.find('.select2-search__field');
			if (searchInput) {
				searchInput.on('keydown', function(e) {
					if (e.which === 13) { // Enter key
						const term = $(this).val().trim();
						if (term) {
							// Create option and select it
							const newOption = new Option(term, term, true, true);
							$select.append(newOption).trigger('change');
							// Close dropdown and submit form
							$select.select2('close');
							const form = document.getElementById('home-search-form');
							if (form) {
								form.submit();
							}
							e.preventDefault();
							return false;
						}
					}
				});
			}
		}, 100);
	});

	// Handle form submission - ensure the value is set correctly
	const form = document.getElementById('home-search-form');
	if (form) {
		form.addEventListener('submit', function(e) {
			let selectedValue = $select.val();
			
			// If no value selected, try to get from the search input
			if (!selectedValue || selectedValue === '') {
				try {
					const select2Data = $select.data('select2');
					if (select2Data && select2Data.$dropdown) {
						const searchInput = select2Data.$dropdown.find('.select2-search__field');
						if (searchInput && searchInput.val()) {
							selectedValue = searchInput.val().trim();
							if (selectedValue) {
								// Create a new option with this value
								const newOption = new Option(selectedValue, selectedValue, true, true);
								$select.append(newOption).trigger('change');
							}
						}
					}
				} catch(err) {
					// If dropdown is closed, we can't access it - that's okay
				}
			}
			
			if (!selectedValue || selectedValue === '') {
				e.preventDefault();
				return false;
			}
			
			// Ensure the select has the value
			if (select.value !== selectedValue) {
				select.value = selectedValue;
			}
		});
	}
}

// Helper function for quick search buttons
window.setSearchAndSubmit = function(value) {
	const select = document.getElementById('home-search-select');
	if (select) {
		const $select = $(select);
		// Create option if it doesn't exist
		if ($select.find('option[value="' + value + '"]').length === 0) {
			const newOption = new Option(value, value, true, true);
			$select.append(newOption);
		}
		$select.val(value).trigger('change');
		document.getElementById('home-search-form').submit();
	}
};

function initMobileSearchPopup() {
	const popup = document.getElementById('mobile-search-popup');
	const trigger = document.getElementById('mobile-search-trigger');
	const input = document.getElementById('mobile-search-input');

	if (!popup || !trigger) {
		return;
	}

	const closeButtons = popup.querySelectorAll('[data-mobile-search-close]');
	const clearButton = popup.querySelector('[data-mobile-search-clear]');
	const items = Array.from(popup.querySelectorAll('[data-mobile-search-item]'));
	const list = popup.querySelector('[data-mobile-search-list]');
	const emptyState = popup.querySelector('[data-mobile-search-empty]');
	const chips = popup.querySelectorAll('[data-mobile-search-chip]');
	const resultsContainer = popup.querySelector('[data-mobile-search-results]');
	const resultsList = popup.querySelector('[data-mobile-search-results-list]');
	const resultsEmpty = popup.querySelector('[data-mobile-search-results-empty]');
	const resultsStatus = popup.querySelector('[data-mobile-search-results-status]');
	const defaultResultsEmptyText = resultsEmpty ? resultsEmpty.textContent.trim() : '';
	let suggestionsAbortController = null;

	const toggleBodyScroll = (lock) => {
		if (lock) {
			document.body.classList.add('mobile-popup-open');
		} else {
			document.body.classList.remove('mobile-popup-open');
		}
	};

	const openPopup = () => {
		popup.classList.add('open');
		popup.setAttribute('aria-hidden', 'false');
		toggleBodyScroll(true);
		setTimeout(() => {
			if (input) {
				input.focus();
				input.select();
			}
		}, 150);
	};

	const closePopup = () => {
		popup.classList.remove('open');
		popup.setAttribute('aria-hidden', 'true');
		toggleBodyScroll(false);
	};

	const filterList = (term) => {
		if (!list || !items.length) return;
		const needle = term.trim().toLowerCase();
		let visibleCount = 0;

		items.forEach((item) => {
			const haystack = (item.getAttribute('data-value') || '').toLowerCase();
			const matches = !needle || haystack.includes(needle);
			item.style.display = matches ? 'flex' : 'none';
			if (matches) {
				visibleCount += 1;
			}
		});

		if (emptyState) {
			if (visibleCount === 0) {
				emptyState.classList.add('is-visible');
			} else {
				emptyState.classList.remove('is-visible');
			}
		}
	};

	const showResultsContainer = (show) => {
		if (!resultsContainer) return;
		if (show) {
			resultsContainer.hidden = false;
			resultsContainer.classList.add('is-visible');
		} else {
			resultsContainer.hidden = true;
			resultsContainer.classList.remove('is-visible');
		}
	};

	const setResultsStatus = (text) => {
		if (resultsStatus) {
			resultsStatus.textContent = text;
		}
	};

	const setResultsEmpty = (visible, text) => {
		if (!resultsEmpty) return;
		resultsEmpty.textContent = text || defaultResultsEmptyText;
		if (visible) {
			resultsEmpty.classList.add('is-visible');
		} else {
			resultsEmpty.classList.remove('is-visible');
		}
	};

	const resetResults = () => {
		if (suggestionsAbortController) {
			suggestionsAbortController.abort();
			suggestionsAbortController = null;
		}
		if (resultsList) {
			resultsList.innerHTML = '';
		}
		setResultsEmpty(true, defaultResultsEmptyText || 'Start typing to search.');
		setResultsStatus('Start typing…');
		showResultsContainer(false);
	};

	const handleResultAction = (item) => {
		if (!item) return;
		if (item.url) {
			window.location.href = item.url;
		} else if (item.text) {
			window.setSearchAndSubmit(item.text);
		}
		closePopup();
	};

	const renderResults = (results = []) => {
		if (!resultsContainer || !resultsList) return;
		resultsList.innerHTML = '';
		if (!results.length) {
			setResultsEmpty(true, 'No matches yet. Try another term.');
			return;
		}

		const fragment = document.createDocumentFragment();
		results.forEach((result) => {
			const button = document.createElement('button');
			button.type = 'button';
			button.className = 'mpopup-result-item';

			const info = document.createElement('div');
			info.className = 'mpopup-result-item__info';

			const title = document.createElement('div');
			title.className = 'mpopup-result-item__title';
			title.textContent = result.text;

			info.appendChild(title);

			if (result.subtitle) {
				const subtitle = document.createElement('div');
				subtitle.className = 'mpopup-result-item__subtitle';
				subtitle.textContent = result.subtitle;
				info.appendChild(subtitle);
			}

			const chip = document.createElement('div');
			chip.className = 'mpopup-result-item__chip';
			chip.textContent = result.type || 'match';

			button.appendChild(info);
			button.appendChild(chip);

			button.addEventListener('click', () => handleResultAction(result));
			fragment.appendChild(button);
		});

		resultsList.appendChild(fragment);
		setResultsEmpty(false);
	};

	const fetchSuggestions = debounce(async (term) => {
		if (!resultsContainer) {
			return;
		}
		if (suggestionsAbortController) {
			suggestionsAbortController.abort();
		}
		suggestionsAbortController = new AbortController();
		setResultsStatus('Searching…');
		setResultsEmpty(false);

		try {
			const response = await fetch(`/api/search/autocomplete?q=${encodeURIComponent(term)}`, {
				signal: suggestionsAbortController.signal,
				headers: {
					'Accept': 'application/json',
				},
			});
			if (!response.ok) {
				throw new Error('Failed to load suggestions');
			}
			const data = await response.json();
			renderResults(Array.isArray(data.results) ? data.results : []);
			setResultsStatus('Suggestions ready');
		} catch (err) {
			if (err.name === 'AbortError') {
				return;
			}
			setResultsStatus('Offline? Try again');
			setResultsEmpty(true, 'Unable to load suggestions right now.');
		}
	}, 350);

	const handleDynamicSuggestions = (term) => {
		const value = term.trim();
		if (!resultsContainer) return;
		if (value.length < 2) {
			resetResults();
			return;
		}
		showResultsContainer(true);
		setResultsStatus('Searching…');
		setResultsEmpty(false);
		fetchSuggestions(value);
	};

	trigger.addEventListener('click', openPopup);
	closeButtons.forEach((btn) => btn.addEventListener('click', closePopup));

	popup.addEventListener('click', (event) => {
		if (event.target === popup) {
			closePopup();
		}
	});

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && popup.classList.contains('open')) {
			closePopup();
		}
	});

	if (input) {
		input.addEventListener('input', (e) => {
			const value = e.target.value;
			filterList(value);
			handleDynamicSuggestions(value);
		});

		input.addEventListener('keydown', (e) => {
			if (e.key === 'Enter') {
				const value = input.value.trim();
				if (value) {
					e.preventDefault();
					window.setSearchAndSubmit(value);
					closePopup();
				}
			}
		});
	}

	if (clearButton) {
		clearButton.addEventListener('click', () => {
			if (!input) return;
			input.value = '';
			filterList('');
			resetResults();
			input.focus();
		});
	}

	items.forEach((item) => {
		item.addEventListener('click', () => {
			const value = item.getAttribute('data-value');
			if (value) {
				window.setSearchAndSubmit(value);
				closePopup();
			}
		});
	});

	chips.forEach((chip) => {
		chip.addEventListener('click', () => {
			const value = chip.getAttribute('data-mobile-search-chip');
			if (value) {
				window.setSearchAndSubmit(value);
				closePopup();
			}
		});
	});

	const form = document.getElementById('home-search-form');
	if (form) {
		form.addEventListener('submit', closePopup);
	}

	filterList('');
	resetResults();
	closePopup();
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
	initMobileSearchPopup();

	// Wait for jQuery and Select2 to be available
	function tryInit() {
		if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
			initHomeSearchSelect2();
		} else {
			setTimeout(tryInit, 50);
		}
	}
	tryInit();

	const mq = window.matchMedia('(min-width: 640px)');
	const handleMqChange = () => {
		if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
			initHomeSearchSelect2();
		}
	};

	if (typeof mq.addEventListener === 'function') {
		mq.addEventListener('change', handleMqChange);
	} else if (typeof mq.addListener === 'function') {
		mq.addListener(handleMqChange);
	}
});

function initAjaxReviewForms() {
	const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
	const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;

	document.querySelectorAll('form[data-ajax-review="true"]').forEach((form) => {
		// Find success/error boxes relative to the form
		const formParent = form.closest('.rounded-2xl, .space-y-4, .space-y-6');
		const successBox = formParent ? formParent.querySelector('[data-review-success]') : document.querySelector('[data-review-success]');
		const errorsBox = formParent ? formParent.querySelector('[data-review-errors]') : document.querySelector('[data-review-errors]');
		
		// Try to find reviews container - check for both doctor and organization
		let reviewsContainer = document.getElementById('doctor-reviews-list');
		if (!reviewsContainer) {
			reviewsContainer = document.getElementById('organization-reviews-list');
		}

		if (!reviewsContainer) {
			return;
		}

		form.addEventListener('submit', async (event) => {
			// If fetch is not available, fall back to normal submit
			if (typeof fetch !== 'function') {
				return;
			}

			event.preventDefault();

			if (successBox) {
				successBox.classList.add('hidden');
				successBox.textContent = '';
			}
			if (errorsBox) {
				errorsBox.classList.add('hidden');
				errorsBox.textContent = '';
			}

			const formData = new FormData(form);

			const headers = {
				'Accept': 'application/json',
				'X-Requested-With': 'XMLHttpRequest',
			};
			if (csrfToken) {
				headers['X-CSRF-TOKEN'] = csrfToken;
			}

			try {
				const response = await fetch(form.action, {
					method: 'POST',
					headers,
					body: formData,
				});

				if (response.status === 422) {
					const data = await response.json();
					if (errorsBox && data && data.errors) {
						const messages = [];
						Object.keys(data.errors).forEach((field) => {
							data.errors[field].forEach((msg) => messages.push(msg));
						});
						errorsBox.textContent = messages.join(' ');
						errorsBox.classList.remove('hidden');
					}
					return;
				}

				if (!response.ok) {
					if (errorsBox) {
						errorsBox.textContent = 'Something went wrong while submitting your review. Please try again.';
						errorsBox.classList.remove('hidden');
					}
					return;
				}

				const data = await response.json();

				if (data.html) {
					reviewsContainer.innerHTML = data.html;
				}

				if (successBox && data.status) {
					successBox.textContent = data.status;
					successBox.classList.remove('hidden');
				}

				// Reset form fields after successful submit
				form.reset();
			} catch (error) {
				if (errorsBox) {
					errorsBox.textContent = 'Unable to submit review right now. Please check your connection and try again.';
					errorsBox.classList.remove('hidden');
				}
			}
		});
	});
}

document.addEventListener('DOMContentLoaded', initAjaxReviewForms);

// Share Story Modal and AJAX Form
function initShareStoryModal() {
	const modal = document.getElementById('share-story-modal');
	const trigger = document.getElementById('share-story-trigger');
	const closeBtn = document.getElementById('share-story-close');
	const form = document.getElementById('share-story-form');
	const successBox = document.getElementById('share-story-success');
	const errorsBox = document.getElementById('share-story-errors');
	const submitBtn = document.getElementById('share-story-submit');
	const spinner = document.getElementById('share-story-spinner');
	const submitText = submitBtn?.querySelector('.submit-text');

	if (!modal || !trigger || !form) {
		return;
	}

	const openModal = () => {
		modal.classList.remove('hidden');
		modal.classList.add('flex');
		modal.setAttribute('aria-hidden', 'false');
		document.body.style.overflow = 'hidden';
		// Focus first input
		const firstInput = form.querySelector('input[name="name"]');
		if (firstInput) {
			setTimeout(() => firstInput.focus(), 100);
		}
	};

	const closeModal = () => {
		modal.classList.add('hidden');
		modal.classList.remove('flex');
		modal.setAttribute('aria-hidden', 'true');
		document.body.style.overflow = '';
		// Reset form and messages
		form.reset();
		if (successBox) successBox.classList.add('hidden');
		if (errorsBox) errorsBox.classList.add('hidden');
		if (spinner) spinner.classList.add('hidden');
		if (submitText) submitText.textContent = 'Share Story';
		if (submitBtn) submitBtn.disabled = false;
	};

	// Open modal
	if (trigger) {
		trigger.addEventListener('click', (e) => {
			e.preventDefault();
			openModal();
		});
	}

	// Close modal
	if (closeBtn) {
		closeBtn.addEventListener('click', closeModal);
	}

	// Close on backdrop click
	modal.addEventListener('click', (e) => {
		if (e.target === modal) {
			closeModal();
		}
	});

	// Close on Escape key
	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
			closeModal();
		}
	});

	// AJAX form submission
	if (form) {
		const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
		const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;

		form.addEventListener('submit', async (e) => {
			e.preventDefault();

			if (typeof fetch !== 'function') {
				form.submit();
				return;
			}

			// Hide previous messages
			if (successBox) {
				successBox.classList.add('hidden');
				successBox.textContent = '';
			}
			if (errorsBox) {
				errorsBox.classList.add('hidden');
				errorsBox.textContent = '';
			}

			// Show loading state
			if (submitBtn) submitBtn.disabled = true;
			if (spinner) spinner.classList.remove('hidden');
			if (submitText) submitText.textContent = 'Sharing...';

			const formData = new FormData(form);
			const headers = {
				'Accept': 'application/json',
				'X-Requested-With': 'XMLHttpRequest',
			};
			if (csrfToken) {
				headers['X-CSRF-TOKEN'] = csrfToken;
			}

			try {
				const response = await fetch(form.action, {
					method: 'POST',
					headers,
					body: formData,
				});

				if (response.status === 422) {
					const data = await response.json();
					if (errorsBox && data && data.errors) {
						const messages = [];
						Object.keys(data.errors).forEach((field) => {
							data.errors[field].forEach((msg) => messages.push(msg));
						});
						errorsBox.textContent = messages.join(' ');
						errorsBox.classList.remove('hidden');
					}
					// Reset loading state
					if (submitBtn) submitBtn.disabled = false;
					if (spinner) spinner.classList.add('hidden');
					if (submitText) submitText.textContent = 'Share Story';
					return;
				}

				if (!response.ok) {
					if (errorsBox) {
						errorsBox.textContent = 'Something went wrong while submitting your story. Please try again.';
						errorsBox.classList.remove('hidden');
					}
					// Reset loading state
					if (submitBtn) submitBtn.disabled = false;
					if (spinner) spinner.classList.add('hidden');
					if (submitText) submitText.textContent = 'Share Story';
					return;
				}

				const data = await response.json();

				// Show success message
				if (successBox && data.status) {
					successBox.textContent = data.status;
					successBox.classList.remove('hidden');
				}

				// Reset form
				form.reset();

				// If story HTML is provided, prepend it to testimonials
				if (data.storyHtml) {
					const testimonialsContainer = document.getElementById('patient-stories-container') || 
						document.querySelector('[role="list"][aria-label="Patient testimonials"]');
					if (testimonialsContainer) {
						// Create a temporary container to parse HTML
						const temp = document.createElement('div');
						temp.innerHTML = data.storyHtml;
						const newStory = temp.firstElementChild;
						if (newStory) {
							testimonialsContainer.insertBefore(newStory, testimonialsContainer.firstChild);
							// Smooth scroll to new story
							setTimeout(() => {
								newStory.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
							}, 100);
						}
					}
				}

				// Close modal after 2 seconds
				setTimeout(() => {
					closeModal();
				}, 2000);

			} catch (error) {
				if (errorsBox) {
					errorsBox.textContent = 'Unable to submit story right now. Please check your connection and try again.';
					errorsBox.classList.remove('hidden');
				}
				// Reset loading state
				if (submitBtn) submitBtn.disabled = false;
				if (spinner) spinner.classList.add('hidden');
				if (submitText) submitText.textContent = 'Share Story';
			}
		});
	}
}

document.addEventListener('DOMContentLoaded', initShareStoryModal);

// AJAX pagination for states page
function initStatesAjaxPagination() {
	const doctorsContainer = document.getElementById('doctors-list-container');
	const organizationsContainer = document.getElementById('organizations-list-container');

	// Handle doctors pagination
	if (doctorsContainer) {
		doctorsContainer.addEventListener('click', async (e) => {
			const link = e.target.closest('a');
			if (!link) return;

			// Check if it's a pagination link
			const href = link.getAttribute('href');
			if (!href) return;
			
			// Check if link is within pagination container
			const isInPagination = link.closest('.pagination') || link.closest('[role="navigation"]');
			if (!isInPagination) return;
			
			// Make sure it's a pagination link (has doctors_page parameter)
			try {
				const url = new URL(href, window.location.origin);
				if (!url.searchParams.has('doctors_page')) return;
			} catch (e) {
				// If URL parsing fails, skip
				return;
			}

			e.preventDefault();

			try {
				const url = new URL(href, window.location.origin);
				url.searchParams.set('type', 'doctors');

				const response = await fetch(url.toString(), {
					headers: {
						'Accept': 'application/json',
					},
				});

				if (!response.ok) return;

				const data = await response.json();

				if (data.html) {
					doctorsContainer.innerHTML = data.html;
					// Scroll to top of doctors section
					doctorsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
				}

				// Update URL without reload
				if (data.url) {
					const currentUrl = new URL(window.location.href);
					const newUrl = new URL(data.url, window.location.origin);
					// Preserve organizations_page if it exists
					if (currentUrl.searchParams.has('organizations_page')) {
						newUrl.searchParams.set('organizations_page', currentUrl.searchParams.get('organizations_page'));
					}
					history.pushState({}, '', newUrl.toString());
				}
			} catch (error) {
				console.error('Error loading doctors page:', error);
			}
		});
	}

	// Handle organizations pagination
	if (organizationsContainer) {
		organizationsContainer.addEventListener('click', async (e) => {
			const link = e.target.closest('a');
			if (!link) return;

			// Check if it's a pagination link
			const href = link.getAttribute('href');
			if (!href) return;
			
			// Check if link is within pagination container
			const isInPagination = link.closest('.pagination') || link.closest('[role="navigation"]');
			if (!isInPagination) return;
			
			// Make sure it's a pagination link (has organizations_page parameter)
			try {
				const url = new URL(href, window.location.origin);
				if (!url.searchParams.has('organizations_page')) return;
			} catch (e) {
				// If URL parsing fails, skip
				return;
			}

			e.preventDefault();

			try {
				const url = new URL(href, window.location.origin);
				url.searchParams.set('type', 'organizations');

				const response = await fetch(url.toString(), {
					headers: {
						'Accept': 'application/json',
					},
				});

				if (!response.ok) return;

				const data = await response.json();

				if (data.html) {
					organizationsContainer.innerHTML = data.html;
					// Scroll to top of organizations section
					organizationsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
				}

				// Update URL without reload
				if (data.url) {
					const currentUrl = new URL(window.location.href);
					const newUrl = new URL(data.url, window.location.origin);
					// Preserve doctors_page if it exists
					if (currentUrl.searchParams.has('doctors_page')) {
						newUrl.searchParams.set('doctors_page', currentUrl.searchParams.get('doctors_page'));
					}
					history.pushState({}, '', newUrl.toString());
				}
			} catch (error) {
				console.error('Error loading organizations page:', error);
			}
		});
	}

	// Handle browser back/forward buttons
	window.addEventListener('popstate', async () => {
		const url = new URL(window.location.href);
		const doctorsPage = url.searchParams.get('doctors_page') || '1';
		const organizationsPage = url.searchParams.get('organizations_page') || '1';

		// Reload doctors if page changed
		if (doctorsContainer) {
			const state = doctorsContainer.getAttribute('data-state');
			if (state) {
				try {
					const fetchUrl = new URL(`/states/${state}`, window.location.origin);
					fetchUrl.searchParams.set('doctors_page', doctorsPage);
					fetchUrl.searchParams.set('organizations_page', organizationsPage);
					fetchUrl.searchParams.set('type', 'doctors');
					
					const response = await fetch(fetchUrl.toString(), {
						headers: {
							'Accept': 'application/json',
						},
					});

					if (response.ok) {
						const data = await response.json();
						if (data.html) {
							doctorsContainer.innerHTML = data.html;
						}
					}
				} catch (error) {
					console.error('Error loading doctors on popstate:', error);
				}
			}
		}

		// Reload organizations if page changed
		if (organizationsContainer) {
			const state = organizationsContainer.getAttribute('data-state');
			if (state) {
				try {
					const fetchUrl = new URL(`/states/${state}`, window.location.origin);
					fetchUrl.searchParams.set('doctors_page', doctorsPage);
					fetchUrl.searchParams.set('organizations_page', organizationsPage);
					fetchUrl.searchParams.set('type', 'organizations');
					
					const response = await fetch(fetchUrl.toString(), {
						headers: {
							'Accept': 'application/json',
						},
					});

					if (response.ok) {
						const data = await response.json();
						if (data.html) {
							organizationsContainer.innerHTML = data.html;
						}
					}
				} catch (error) {
					console.error('Error loading organizations on popstate:', error);
				}
			}
		}
	});
}

document.addEventListener('DOMContentLoaded', initStatesAjaxPagination);

// AJAX search for blog page
function initBlogAjaxSearch() {
	const searchForm = document.getElementById('blog-search-form');
	const searchInput = document.getElementById('blog-search-input');
	const clearButton = document.getElementById('blog-search-clear');
	const articlesContainer = document.getElementById('blog-articles-container');
	const loadingIndicator = document.getElementById('blog-loading');
	
	if (!searchForm || !searchInput || !articlesContainer) {
		return;
	}

	let searchAbortController = null;

	const showLoading = () => {
		if (loadingIndicator) {
			loadingIndicator.classList.remove('hidden');
		}
		if (articlesContainer) {
			articlesContainer.style.opacity = '0.5';
			articlesContainer.style.pointerEvents = 'none';
		}
	};

	const hideLoading = () => {
		if (loadingIndicator) {
			loadingIndicator.classList.add('hidden');
		}
		if (articlesContainer) {
			articlesContainer.style.opacity = '1';
			articlesContainer.style.pointerEvents = 'auto';
		}
	};

	const performSearch = debounce(async (searchTerm) => {
		if (searchAbortController) {
			searchAbortController.abort();
		}
		searchAbortController = new AbortController();

		showLoading();

		try {
			const url = new URL(searchForm.action, window.location.origin);
			const formData = new FormData(searchForm);
			
			// Add all form data to URL
			for (const [key, value] of formData.entries()) {
				if (value && value.trim() !== '') {
					url.searchParams.set(key, value);
				} else {
					url.searchParams.delete(key);
				}
			}

			const response = await fetch(url.toString(), {
				headers: {
					'Accept': 'application/json',
					'X-Requested-With': 'XMLHttpRequest',
				},
				signal: searchAbortController.signal,
			});

			if (!response.ok) {
				throw new Error('Search failed');
			}

			const data = await response.json();

			if (data.html) {
				articlesContainer.innerHTML = data.html;
				
				// Smooth scroll to top of articles
				articlesContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}

			// Update URL without reload
			if (data.url) {
				history.pushState({}, '', data.url);
			}

			// Update clear button visibility
			if (clearButton) {
				const currentValue = searchInput.value.trim();
				if (currentValue !== '') {
					clearButton.classList.remove('hidden');
				} else {
					clearButton.classList.add('hidden');
				}
			}

		} catch (error) {
			if (error.name !== 'AbortError') {
				console.error('Search error:', error);
			}
		} finally {
			hideLoading();
		}
	}, 350);

	// Handle input
	searchInput.addEventListener('input', (e) => {
		const value = e.target.value.trim();
		performSearch(value);
	});

	// Handle clear button
	if (clearButton) {
		clearButton.addEventListener('click', (e) => {
			e.preventDefault();
			searchInput.value = '';
			searchInput.focus();
			clearButton.classList.add('hidden');
			performSearch('');
		});
	}

	// Handle form submission (prevent default)
	searchForm.addEventListener('submit', (e) => {
		e.preventDefault();
		performSearch(searchInput.value.trim());
	});

	// Handle pagination clicks (delegation)
	articlesContainer.addEventListener('click', async (e) => {
		const link = e.target.closest('a');
		if (!link) return;

		// Check if it's a pagination link
		const href = link.getAttribute('href');
		if (!href) return;

		// Check if link is within pagination container
		const isInPagination = link.closest('.pagination') || link.closest('[role="navigation"]');
		if (!isInPagination) return;

		// Check if it's a pagination link (has page parameter or is a pagination link)
		try {
			const url = new URL(href, window.location.origin);
			if (!url.searchParams.has('page') && !href.includes('page=')) {
				return;
			}
		} catch (e) {
			return;
		}

		e.preventDefault();

		showLoading();

		try {
			const url = new URL(href, window.location.origin);
			
			// Preserve search query and topic
			if (searchInput.value.trim()) {
				url.searchParams.set('q', searchInput.value.trim());
			}
			const formData = new FormData(searchForm);
			if (formData.get('topic')) {
				url.searchParams.set('topic', formData.get('topic'));
			}

			const response = await fetch(url.toString(), {
				headers: {
					'Accept': 'application/json',
					'X-Requested-With': 'XMLHttpRequest',
				},
			});

			if (!response.ok) {
				throw new Error('Pagination failed');
			}

			const data = await response.json();

			if (data.html) {
				articlesContainer.innerHTML = data.html;
				articlesContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}

			if (data.url) {
				history.pushState({}, '', data.url);
			}

		} catch (error) {
			console.error('Pagination error:', error);
		} finally {
			hideLoading();
		}
	});

	// Handle browser back/forward buttons
	window.addEventListener('popstate', () => {
		const url = new URL(window.location.href);
		const searchTerm = url.searchParams.get('q') || '';
		const topic = url.searchParams.get('topic') || '';

		// Update input value
		searchInput.value = searchTerm;

		// Update topic hidden input if exists
		const topicInput = searchForm.querySelector('input[name="topic"]');
		if (topicInput) {
			if (topic) {
				topicInput.value = topic;
			} else {
				topicInput.remove();
			}
		} else if (topic) {
			const hiddenInput = document.createElement('input');
			hiddenInput.type = 'hidden';
			hiddenInput.name = 'topic';
			hiddenInput.value = topic;
			searchForm.appendChild(hiddenInput);
		}

		// Update clear button
		if (clearButton) {
			if (searchTerm) {
				clearButton.classList.remove('hidden');
			} else {
				clearButton.classList.add('hidden');
			}
		}

		// Perform search
		performSearch(searchTerm);
	});

	// Initialize clear button visibility
	if (clearButton) {
		if (searchInput.value.trim()) {
			clearButton.classList.remove('hidden');
		} else {
			clearButton.classList.add('hidden');
		}
	}
}

document.addEventListener('DOMContentLoaded', initBlogAjaxSearch);
