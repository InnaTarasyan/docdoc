@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="about-container">
	<div class="about-wrapper">
		<!-- Hero Section with Photo -->
		<div class="about-hero">
			<div class="about-hero-content">
				<div class="about-photo-wrapper">
					<div class="about-photo-container">
						<img src="{{ asset('img/inna.jpg') }}" alt="Inna Tarasyan" class="about-photo">
						<div class="about-photo-overlay"></div>
					</div>
				</div>
				<div class="about-hero-text">
					<h1 class="about-title">🌐 Inna Tarasyan</h1>
					<p class="about-subtitle">Web Developer & Crypto Enthusiast</p>
					<p class="about-location">🇦🇲 Based in Armenia</p>
				</div>
			</div>
		</div>

		<!-- Main Content -->
		<div class="about-content">
			<!-- Introduction Section -->
			<section class="about-section">
				<div class="about-section-header">
					<div class="about-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-linecap="round" stroke-linejoin="round"/>
							<circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="about-section-title">Hello!</h2>
				</div>
				<div class="about-section-body">
					<p class="about-text">
						I'm a passionate web developer with a strong interest in blockchain and crypto technologies. I focus on building tools that make crypto trading more accessible and data-driven. With experience in creating real-time, user-friendly web applications, I aim to empower traders through better insights and seamless interfaces.
					</p>
				</div>
			</section>

			<!-- Project Overview Section -->
			<section class="about-section">
				<div class="about-section-header">
					<div class="about-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M12 2L2 7l10 5 10-5-10-5z" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2 17l10 5 10-5M2 12l10 5 10-5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="about-section-title">🏥 Project Overview: NPI Registry Data Importer (Laravel)</h2>
				</div>
				<div class="about-section-body">
					<p class="about-text">
						This Laravel-based project is designed to fetch comprehensive healthcare provider data from the official NPI Registry API and store it in a structured and scalable way. The primary goal is to collect and organize information about doctors, healthcare organizations, and their specialties, making it easy to search, analyze, and use in medical directories or booking platforms.
					</p>
				</div>
			</section>

			<!-- Key Features Section -->
			<section class="about-section">
				<div class="about-section-header">
					<div class="about-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M9 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M21 12c-1 0-3-1-3-3s2-3 3-3 3 1 3 3-2 3-3 3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M3 12c1 0 3-1 3-3s-2-3-3-3-3 1-3 3 2 3 3 3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M12 21c0-1-1-3-3-3s-3 2-3 3 1 3 3 3 3-2 3-3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M12 3c0 1-1 3-3 3S6 4 6 3s1-3 3-3 3 2 3 3" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="about-section-title">🔍 Key Features</h2>
				</div>
				<div class="about-section-body">
					<div class="about-feature-item">
						<h3 class="about-feature-title">Dynamic Data Retrieval</h3>
						<p class="about-text">
							Fetches paginated data from the NPI Registry API using valid, customizable filters like location (state) and taxonomy (specialty) to avoid API errors.
						</p>
					</div>
					<div class="about-feature-item">
						<h3 class="about-feature-title">Data Categorization</h3>
						<p class="about-text">
							Organizes imported records into dedicated tables for:
						</p>
						<ul class="about-list">
							<li class="about-list-item">
								<span class="about-list-bullet"></span>
								<span><strong>Doctors</strong></span>
							</li>
							<li class="about-list-item">
								<span class="about-list-bullet"></span>
								<span><strong>Organizations</strong></span>
							</li>
							<li class="about-list-item">
								<span class="about-list-bullet"></span>
								<span><strong>Specialties</strong></span>
							</li>
						</ul>
					</div>
					<div class="about-feature-item">
						<h3 class="about-feature-title">Console Commands</h3>
						<p class="about-text">
							Includes CLI tools to automate data import and refresh routines, ensuring updated information without duplicated entries.
						</p>
					</div>
					<div class="about-feature-item">
						<h3 class="about-feature-title">Caching Support (optional)</h3>
						<p class="about-text">
							Built-in caching layer helps reduce API calls and speeds up data retrieval for repeated queries.
						</p>
					</div>
					<div class="about-feature-item">
						<h3 class="about-feature-title">Error Handling & Validation</h3>
						<p class="about-text">
							Ensures smooth data import through API response validation and structured logging.
						</p>
					</div>
				</div>
			</section>

			<!-- Tech Stack Section -->
			<section class="about-section">
				<div class="about-section-header">
					<div class="about-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M12 2L2 7l10 5 10-5-10-5z" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2 17l10 5 10-5M2 12l10 5 10-5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="about-section-title">🛠 Tech Stack</h2>
				</div>
				<div class="about-section-body">
					<ul class="about-list">
						<li class="about-list-item">
							<span class="about-list-bullet"></span>
							<span>Laravel 10+</span>
						</li>
						<li class="about-list-item">
							<span class="about-list-bullet"></span>
							<span>MySQL / PostgreSQL</span>
						</li>
						<li class="about-list-item">
							<span class="about-list-bullet"></span>
							<span>Artisan Commands</span>
						</li>
						<li class="about-list-item">
							<span class="about-list-bullet"></span>
							<span>JSON REST API Integration</span>
						</li>
						<li class="about-list-item">
							<span class="about-list-bullet"></span>
							<span>Optional Cache (Redis / File)</span>
						</li>
					</ul>
				</div>
			</section>

			<!-- Ownership Section -->
			<section class="about-section">
				<div class="about-section-header">
					<div class="about-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="about-section-title">👤 Ownership</h2>
				</div>
				<div class="about-section-body">
					<p class="about-text">
						"Coin Trading Project" and this NPI data importer are solely built and maintained by me, <strong>Inna Tarasyan</strong> — an independent web developer from Armenia. No company or external organization is involved. I take full responsibility for the project's development, updates, and content.
					</p>
				</div>
			</section>

			<!-- Contact Section -->
			<section class="about-section">
				<div class="about-section-header">
					<div class="about-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="about-section-title">📩 Get in Touch</h2>
				</div>
				<div class="about-section-body">
					<p class="about-text">
						Got ideas, questions, or want to collaborate?
					</p>
					<p class="about-text">
						Feel free to reach out — I'd love to connect!
					</p>
					<div class="about-contact-info">
						<p class="about-text">
							📧 Email: <a href="mailto:innatarasyancryptotrading@gmail.com" class="about-link">innatarasyancryptotrading@gmail.com</a>
						</p>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<style>
.about-container {
	max-width: 1200px;
	margin: 0 auto;
	padding: 2rem 1rem;
}

.about-wrapper {
	background: white;
	border-radius: 1rem;
	box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
	overflow: hidden;
}

/* Hero Section */
.about-hero {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	padding: 3rem 2rem;
	position: relative;
	overflow: hidden;
}

.about-hero::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="2"/></g></svg>');
	opacity: 0.3;
}

.about-hero-content {
	position: relative;
	z-index: 1;
	display: flex;
	flex-direction: column;
	align-items: center;
	gap: 2rem;
}

.about-photo-wrapper {
	position: relative;
}

.about-photo-container {
	position: relative;
	width: 200px;
	height: 200px;
	border-radius: 50%;
	overflow: hidden;
	border: 5px solid rgba(255, 255, 255, 0.3);
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.about-photo-container:hover {
	transform: scale(1.05);
	box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
}

.about-photo {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: block;
}

.about-photo-overlay {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
	pointer-events: none;
}

.about-hero-text {
	text-align: center;
	color: white;
}

.about-title {
	font-size: 2.5rem;
	font-weight: 700;
	margin-bottom: 0.5rem;
	text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.about-subtitle {
	font-size: 1.25rem;
	opacity: 0.95;
	font-weight: 500;
	margin-bottom: 0.25rem;
}

.about-location {
	font-size: 1.125rem;
	opacity: 0.9;
	font-weight: 400;
}

/* Content Sections */
.about-content {
	padding: 3rem 2rem;
}

.about-section {
	margin-bottom: 3rem;
}

.about-section:last-child {
	margin-bottom: 0;
}

.about-section-header {
	display: flex;
	align-items: center;
	gap: 1rem;
	margin-bottom: 1.5rem;
	padding-bottom: 1rem;
	border-bottom: 2px solid #e5e7eb;
}

.about-section-icon {
	width: 2.5rem;
	height: 2.5rem;
	color: #667eea;
	flex-shrink: 0;
}

.about-section-icon svg {
	width: 100%;
	height: 100%;
}

.about-section-title {
	font-size: 1.75rem;
	font-weight: 700;
	color: #1f2937;
	margin: 0;
}

.about-feature-item {
	margin-bottom: 2rem;
}

.about-feature-item:last-child {
	margin-bottom: 0;
}

.about-feature-title {
	font-size: 1.25rem;
	font-weight: 600;
	color: #374151;
	margin-bottom: 0.75rem;
}

.about-section-body {
	color: #4b5563;
	line-height: 1.75;
}

.about-text {
	margin-bottom: 1.25rem;
	font-size: 1rem;
}

.about-text:last-child {
	margin-bottom: 0;
}

.about-list {
	list-style: none;
	padding: 0;
	margin: 1.5rem 0;
}

.about-list-item {
	display: flex;
	align-items: flex-start;
	gap: 0.75rem;
	margin-bottom: 0.75rem;
	padding-left: 0;
}

.about-list-item:last-child {
	margin-bottom: 0;
}

.about-list-bullet {
	width: 0.5rem;
	height: 0.5rem;
	border-radius: 50%;
	background: #667eea;
	flex-shrink: 0;
	margin-top: 0.5rem;
}

.about-link {
	color: #667eea;
	text-decoration: none;
	font-weight: 500;
	transition: color 0.2s ease, text-decoration 0.2s ease;
	border-bottom: 1px solid transparent;
}

.about-link:hover {
	color: #764ba2;
	border-bottom-color: #764ba2;
}

.about-contact-info {
	background: #f9fafb;
	padding: 1.5rem;
	border-radius: 0.5rem;
	margin-top: 1rem;
	border-left: 4px solid #667eea;
}

/* Responsive Design */
@media (max-width: 768px) {
	.about-container {
		padding: 1rem 0.5rem;
	}

	.about-hero {
		padding: 2rem 1.5rem;
	}

	.about-photo-container {
		width: 150px;
		height: 150px;
		border-width: 4px;
	}

	.about-title {
		font-size: 2rem;
	}

	.about-subtitle {
		font-size: 1.125rem;
	}

	.about-location {
		font-size: 1rem;
	}

	.about-content {
		padding: 2rem 1.5rem;
	}

	.about-section {
		margin-bottom: 2.5rem;
	}

	.about-section-header {
		flex-direction: column;
		align-items: flex-start;
		gap: 0.75rem;
	}

	.about-section-icon {
		width: 2rem;
		height: 2rem;
	}

	.about-section-title {
		font-size: 1.5rem;
	}

	.about-text {
		font-size: 0.9375rem;
	}

	.about-feature-title {
		font-size: 1.125rem;
	}
}

@media (min-width: 769px) {
	.about-hero-content {
		flex-direction: row;
		justify-content: center;
		text-align: left;
	}

	.about-hero-text {
		text-align: left;
		flex: 1;
	}

	.about-photo-wrapper {
		margin-right: 2rem;
	}
}

@media (min-width: 1024px) {
	.about-container {
		padding: 3rem 2rem;
	}

	.about-hero {
		padding: 4rem 3rem;
	}

	.about-content {
		padding: 4rem 3rem;
	}

	.about-photo-container {
		width: 250px;
		height: 250px;
	}
}
</style>
@endsection
