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
	for (const [key, value] of formData.entries()) {
		u.searchParams.set(key, value);
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
		history.pushState({}, '', data.url);
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
