<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
            (function(m,e,t,r,i,k,a){
                m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
            })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=105613401', 'ym');

            ym(105613401, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/105613401" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->

		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-MQ76X6QL');</script>
		<!-- End Google Tag Manager -->

		<title>@yield('title', config('app.name', 'Doc Directory'))</title>
		<!-- jQuery (required for Select2) -->
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
		<!-- Select2 CSS -->
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<!-- Select2 JS -->
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<style>
			/* Custom Select2 styling to match the design */
			.select2-container--bootstrap-5 .select2-selection {
				min-height: 3.5rem;
				border: 1px solid #d1d5db;
				border-radius: 0.5rem;
				padding: 0.5rem;
			}
			.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
				line-height: 2.5rem;
				padding-left: 0.75rem;
			}
			.select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
				height: 2.5rem;
				right: 0.75rem;
			}
			.select2-container--bootstrap-5 .select2-dropdown {
				border: 1px solid #d1d5db;
				border-radius: 0.5rem;
			}
			.select2-result-item-title {
				font-weight: 500;
				color: #111827;
			}
			.select2-result-item-subtitle {
				margin-top: 0.25rem;
			}
			.select2-results__option--highlighted .select2-result-item-title {
				color: white;
			}
			.select2-results__option--highlighted .select2-result-item-subtitle {
				color: rgba(255, 255, 255, 0.8);
			}
			@media (min-width: 640px) {
				.select2-container--bootstrap-5 .select2-selection {
					min-height: 3rem;
				}
				.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
					line-height: 2rem;
				}
				.select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
					height: 2rem;
				}
			}
		</style>
	</head>
	<body class="min-h-screen bg-gray-50 text-gray-900 antialiased flex flex-col">
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQ76X6QL"
					  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

		<header class="app-header">
			<div class="container-tight" x-data="{ open: false }">
				<div class="flex items-center justify-between h-16 gap-4">
					<div class="flex items-center gap-3 min-w-0">
						<a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-semibold text-lg text-brand-700 group">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 text-brand-600 group-hover:text-brand-700 transition-colors">
								<path d="M12 4v16M4 12h16" stroke-width="2" stroke-linecap="round"/>
							</svg>
							<span>PrimeDoctors</span>
						</a>
						<!--
						<button
							type="button"
							class="hidden sm:inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1.5 text-xs font-semibold text-gray-800 shadow-sm hover:border-emerald-400 hover:text-emerald-800 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50"
							data-open-state-modal
							aria-haspopup="dialog"
							aria-controls="state-picker-modal"
						>
							<svg class="w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7Z" stroke-linecap="round" stroke-linejoin="round"/>
								<circle cx="12" cy="9" r="2.5" />
							</svg>
							<span
								class="text-sm font-semibold text-emerald-800"
								data-selected-state-label
							>{{ $preferredStateName ?? 'California' }}</span>
						</button>
						-->
					</div>
					<nav class="hidden sm:flex items-center gap-6 text-sm">
						<a href="{{ route('doctors.index') }}" class="text-gray-700 hover:text-brand-700 transition-colors font-medium">Doctors</a>
						<a href="{{ route('organizations.index') }}" class="text-gray-700 hover:text-brand-700 transition-colors font-medium">Organizations</a>
						<a href="{{ route('specialties.index') }}" class="text-gray-700 hover:text-brand-700 transition-colors font-medium">Specialties</a>
						<a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-brand-700 transition-colors font-medium">Blog</a>
						<a href="{{ route('about') }}" class="text-gray-700 hover:text-brand-700 transition-colors font-medium">About</a>
					</nav>
					<button
						@click="open = !open"
						class="sm:hidden mb-2 inline-flex items-center gap-2 px-4 py-2 rounded-full border border-transparent text-sm font-semibold text-white transition-all mobile-menu-toggle focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500"
						:aria-label="open ? 'Close menu' : 'Open menu'"
						aria-expanded="false"
						:aria-expanded="open">
						<span class="mobile-menu-toggle__icon" aria-hidden="true">
							<svg x-cloak x-show="!open" x-transition.opacity xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
							</svg>
							<svg x-cloak x-show="open" x-transition.opacity xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
							</svg>
						</span>
						<span class="mobile-menu-toggle__label" x-text="open ? 'Close' : 'Menu'" aria-live="polite"></span>
					</button>
				</div>
				<div x-cloak x-show="open" 
					 x-transition:enter="transition ease-out duration-200"
					 x-transition:enter-start="opacity-0 transform -translate-y-1"
					 x-transition:enter-end="opacity-100 transform translate-y-0"
					 x-transition:leave="transition ease-in duration-150"
					 x-transition:leave-start="opacity-100 transform translate-y-0"
					 x-transition:leave-end="opacity-0 transform -translate-y-1"
					 class="sm:hidden border-t">
					<div class="py-2">
						<div class="flex items-center gap-2 px-4 py-2.5">
							<div class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
								<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7Z" stroke-linecap="round" stroke-linejoin="round"/>
									<circle cx="12" cy="9" r="2.5" />
								</svg>
							</div>
							<div class="flex-1">
								<button
									type="button"
									class="text-left"
									data-open-state-modal
									aria-haspopup="dialog"
									aria-controls="state-picker-modal"
								>
									<span class="sr-only">Preferred state</span>
									<span
										class="text-sm font-semibold text-emerald-800 hover:text-emerald-900 underline-offset-2 hover:underline"
										data-selected-state-label
									>{{ $preferredStateName ?? 'California' }}</span>
								</button>
							</div>
						</div>
						<a href="{{ route('doctors.index') }}" class="block px-4 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-gray-700 hover:text-gray-900">Doctors</a>
						<a href="{{ route('organizations.index') }}" class="block px-4 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-gray-700 hover:text-gray-900">Organizations</a>
						<a href="{{ route('specialties.index') }}" class="block px-4 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-gray-700 hover:text-gray-900">Specialties</a>
						<a href="{{ route('blog.index') }}" class="block px-4 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-gray-700 hover:text-gray-900">Blog</a>
						<a href="{{ route('about') }}" class="block px-4 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-gray-700 hover:text-gray-900">About</a>
					</div>
				</div>
			</div>
		</header>

		<main class="container-tight py-4 sm:py-6 md:py-8 flex-grow">
			@hasSection('breadcrumbs')
				<nav class="mb-4 sm:mb-6 text-sm text-gray-600">
					@yield('breadcrumbs')
				</nav>
			@endif
			@yield('content')
		</main>

	<footer class="app-footer">
		<div class="container-tight py-8 sm:py-10">
			<div class="footer-content">
				<!-- Copyright and Developer Info -->
				<div class="footer-section">
					<p class="footer-copyright">
						&copy; {{ date('Y') }} Inna Tarasyan. All rights reserved.
					</p>
					<p class="footer-developer">
						Website developed and maintained by <strong>Inna Tarasyan</strong>, Web Developer.
					</p>
				</div>

				<!-- Contact Request -->
				<div class="footer-section">
					<p class="footer-contact">
						🤝 We kindly ask that you do not use or share information from this site without first reaching out to the author. If you have questions or would like to use any content, please contact <strong>Inna Tarasyan</strong>—I'm always happy to connect!
					</p>
				</div>

				<!-- Legal Links -->
				<div class="footer-section footer-links-wrapper">
					<div class="footer-links">
						<a href="{{ route('legal.privacy') }}" class="footer-link">Privacy Policy</a>
						<span class="footer-link-separator">|</span>
						<a href="{{ route('legal.terms') }}" class="footer-link">Terms of Use</a>
					</div>
				</div>

				<!-- Security Status -->
				<div class="footer-section footer-security">
					<div class="security-badge">
						<span class="security-icon">✅</span>
						<span>Site status: No unsafe content detected by Google Safe Browsing.</span>
					</div>
					<div class="security-badge">
						<span class="security-icon">🔒</span>
						<span>Our SSL security has been rated A by Qualys SSL Labs.</span>
					</div>
					<div class="security-badge">
						<span class="security-icon">✅</span>
						<span>Checked by Google Safe Browsing</span>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- State picker modal -->
	<div
		id="state-picker-modal"
		class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-4 bg-black/60 backdrop-blur-sm"
		role="dialog"
		aria-modal="true"
		aria-labelledby="state-picker-title"
	>
		<div
			class="vfm__content w-full max-w-3xl rounded-3xl bg-white shadow-2xl max-h-[90vh] sm:max-h-[85vh] flex flex-col overflow-hidden"
			data-state-modal-panel
		>
			<div class="popup__wrap relative flex flex-col h-full">
				<button
					type="button"
					class="popup__close"
					data-close-state-modal
					aria-label="Close state picker"
				></button>
				<div class="popup__title flex items-center justify-between gap-2 pr-10 px-4 pt-4 sm:px-6 sm:pt-6">
					<div>
						<p class="text-xs text-emerald-700 font-semibold uppercase tracking-wide">Location</p>
						<span id="state-picker-title" class="text-lg font-semibold text-gray-900">Choose your state</span>
					</div>
					<span class="text-xs text-gray-500 font-medium rounded-full bg-gray-100 px-3 py-1">{{ count($statePickerOptions ?? []) }} available</span>
				</div>
				<div class="popup__scroller max-h-[75vh] sm:max-h-[70vh] overflow-y-auto px-4 pb-4 sm:px-6 sm:pb-6 flex-1">
					<div class="popup__content space-y-4">
						<div class="field field-text">
							<div class="field-text__wrap">
								<input
									type="search"
									id="state-picker-search"
									class="field-text__input"
									placeholder="Type the state name"
									autocomplete="off"
								>
								<div class="field-text__wrap_search">
									<img src="/img/icons/search_16x16.svg" alt="">
								</div>
							</div>
						</div>
						<div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3" id="state-picker-list">
							@forelse($statePickerOptions ?? [] as $state)
								<button
									type="button"
									class="cities-link flex items-center justify-between rounded-xl border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-800 hover:border-emerald-500 hover:text-emerald-800 transition"
									data-state-option
									data-state-abbr="{{ $state['abbr'] }}"
									data-state-name="{{ $state['name'] }}"
								>
									<span>{{ $state['name'] }}</span>
									<span class="text-xs text-gray-500 font-medium">{{ $state['abbr'] }}</span>
								</button>
							@empty
								<p class="text-sm text-gray-600">No states available.</p>
							@endforelse
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', () => {
			const modal = document.getElementById('state-picker-modal');
			const modalPanel = modal?.querySelector('[data-state-modal-panel]');
			const openButtons = document.querySelectorAll('[data-open-state-modal]');
			const closeButtons = modal?.querySelectorAll('[data-close-state-modal]') || [];
			const searchInput = document.getElementById('state-picker-search');
			const stateButtons = Array.from(modal?.querySelectorAll('[data-state-option]') || []);
			const stateLabels = Array.from(document.querySelectorAll('[data-selected-state-label]'));
			const homeUrl = "{{ route('home') }}";
			const urlParams = new URLSearchParams(window.location.search);

			const openModal = () => {
				if (!modal) return;
				modal.classList.remove('hidden');
				modal.classList.add('flex');
				document.body.classList.add('overflow-hidden');
				if (searchInput) {
					setTimeout(() => searchInput.focus(), 50);
				}
			};

			const updateSelectedStateLabels = (name) => {
				if (!name) return;
				stateLabels.forEach((label) => {
					label.textContent = name;
				});
			};

			const findStateNameByAbbr = (abbr) => {
				if (!abbr) return null;
				const target = abbr.toUpperCase();
				const match = stateButtons.find((btn) => (btn.dataset.stateAbbr || '').toUpperCase() === target);
				return match?.dataset.stateName || null;
			};

			const closeModal = () => {
				if (!modal) return;
				modal.classList.add('hidden');
				modal.classList.remove('flex');
				document.body.classList.remove('overflow-hidden');
				if (searchInput) {
					searchInput.value = '';
					filterStates('');
				}
			};

			const filterStates = (query) => {
				const term = query.trim().toLowerCase();
				stateButtons.forEach((btn) => {
					const name = (btn.dataset.stateName || '').toLowerCase();
					const abbr = (btn.dataset.stateAbbr || '').toLowerCase();
					const match = name.includes(term) || abbr.includes(term);
					btn.classList.toggle('hidden', !match);
				});
			};

			openButtons.forEach((btn) => {
				btn.addEventListener('click', (e) => {
					e.preventDefault();
					openModal();
				});
			});

			closeButtons.forEach((btn) => {
				btn.addEventListener('click', (e) => {
					e.preventDefault();
					closeModal();
				});
			});

			if (modal) {
				modal.addEventListener('click', (e) => {
					if (e.target === modal) {
						closeModal();
					}
				});
			}

			document.addEventListener('keydown', (e) => {
				if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
					closeModal();
				}
			});

			if (searchInput) {
				searchInput.addEventListener('input', (e) => filterStates(e.target.value));
			}

			stateButtons.forEach((btn) => {
				btn.addEventListener('click', () => {
					const abbr = btn.dataset.stateAbbr;
					const name = btn.dataset.stateName;
					if (!abbr) return;
					if (name) {
						updateSelectedStateLabels(name);
					}
					const url = homeUrl.includes('?')
						? `${homeUrl}&state=${encodeURIComponent(abbr)}`
						: `${homeUrl}?state=${encodeURIComponent(abbr)}`;
					window.location.href = url;
				});
			});

			// Sync label with state query param or route param on initial load
			let stateAbbr = urlParams.get('state');
			
			// If no query param, check if we're on a /states/{state} page
			if (!stateAbbr) {
				const pathMatch = window.location.pathname.match(/^\/states\/([a-z]{2})$/i);
				if (pathMatch) {
					stateAbbr = pathMatch[1];
				}
			}
			
			if (stateAbbr) {
				const nameFromParam = findStateNameByAbbr(stateAbbr);
				if (nameFromParam) {
					updateSelectedStateLabels(nameFromParam);
				}
			}
		});
	</script>
	</body>
	</html>


