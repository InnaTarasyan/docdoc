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
