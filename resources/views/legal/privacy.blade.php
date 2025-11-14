@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="privacy-policy-container">
	<div class="privacy-policy-wrapper">
		<!-- Header Section with Enhanced Design -->
		<div class="privacy-policy-header">
			<div class="privacy-policy-header-content">
				<div class="privacy-policy-icon-wrapper">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="privacy-policy-icon">
						<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<h1 class="privacy-policy-title">Privacy Policy</h1>
				<p class="privacy-policy-date">Last updated: <span class="privacy-policy-date-value">{{ date('F j, Y') }}</span></p>
			</div>
		</div>

		<!-- Content Sections -->
		<div class="privacy-policy-content">
			<section class="privacy-policy-section">
				<div class="privacy-policy-section-header">
					<div class="privacy-policy-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M12 2L2 7l10 5 10-5-10-5z" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2 17l10 5 10-5M2 12l10 5 10-5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="privacy-policy-section-title">Introduction</h2>
				</div>
				<div class="privacy-policy-section-body">
					<p class="privacy-policy-text">
						Welcome to DocDoc. We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.
					</p>
				</div>
			</section>

			<section class="privacy-policy-section">
				<div class="privacy-policy-section-header">
					<div class="privacy-policy-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke-linecap="round" stroke-linejoin="round"/>
							<circle cx="12" cy="10" r="3" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="privacy-policy-section-title">Information We Collect</h2>
				</div>
				<div class="privacy-policy-section-body">
					<p class="privacy-policy-text">
						We may collect information about you in a variety of ways. The information we may collect includes:
					</p>
					<ul class="privacy-policy-list">
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Personal data such as name, email address, and contact information that you voluntarily provide</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Usage data including your IP address, browser type, and pages you visit on our site</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Search queries and preferences to improve your experience</span>
						</li>
					</ul>
				</div>
			</section>

			<section class="privacy-policy-section">
				<div class="privacy-policy-section-header">
					<div class="privacy-policy-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke-linecap="round" stroke-linejoin="round"/>
							<polyline points="14 2 14 8 20 8" stroke-linecap="round" stroke-linejoin="round"/>
							<line x1="16" y1="13" x2="8" y2="13" stroke-linecap="round" stroke-linejoin="round"/>
							<line x1="16" y1="17" x2="8" y2="17" stroke-linecap="round" stroke-linejoin="round"/>
							<polyline points="10 9 9 9 8 9" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="privacy-policy-section-title">How We Use Your Information</h2>
				</div>
				<div class="privacy-policy-section-body">
					<p class="privacy-policy-text">
						We use the information we collect to:
					</p>
					<ul class="privacy-policy-list">
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Provide, maintain, and improve our services</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Respond to your inquiries and provide customer support</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Send you updates and communications related to our services</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Analyze usage patterns to enhance user experience</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Ensure the security and integrity of our platform</span>
						</li>
					</ul>
				</div>
			</section>

			<section class="privacy-policy-section">
				<div class="privacy-policy-section-header">
					<div class="privacy-policy-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M7 11V7a5 5 0 0 1 10 0v4" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="privacy-policy-section-title">Data Security</h2>
				</div>
				<div class="privacy-policy-section-body">
					<p class="privacy-policy-text">
						We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet or electronic storage is 100% secure.
					</p>
				</div>
			</section>

			<section class="privacy-policy-section">
				<div class="privacy-policy-section-header">
					<div class="privacy-policy-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M12 6v6l4 2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="privacy-policy-section-title">Cookies and Tracking Technologies</h2>
				</div>
				<div class="privacy-policy-section-body">
					<p class="privacy-policy-text">
						We may use cookies and similar tracking technologies to track activity on our website and store certain information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.
					</p>
				</div>
			</section>

			<section class="privacy-policy-section">
				<div class="privacy-policy-section-header">
					<div class="privacy-policy-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"/>
							<line x1="2" y1="12" x2="22" y2="12" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="privacy-policy-section-title">Third-Party Services</h2>
				</div>
				<div class="privacy-policy-section-body">
					<p class="privacy-policy-text">
						Our website may contain links to third-party websites or services. We are not responsible for the privacy practices of these third parties. We encourage you to read their privacy policies.
					</p>
				</div>
			</section>

			<section class="privacy-policy-section">
				<div class="privacy-policy-section-header">
					<div class="privacy-policy-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M9 11l3 3L22 4" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="privacy-policy-section-title">Your Rights</h2>
				</div>
				<div class="privacy-policy-section-body">
					<p class="privacy-policy-text">
						You have the right to:
					</p>
					<ul class="privacy-policy-list">
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Access and receive a copy of your personal data</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Request correction of inaccurate personal data</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Request deletion of your personal data</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Object to processing of your personal data</span>
						</li>
						<li class="privacy-policy-list-item">
							<span class="privacy-policy-list-bullet"></span>
							<span>Request restriction of processing your personal data</span>
						</li>
					</ul>
				</div>
			</section>

			<section class="privacy-policy-section">
				<div class="privacy-policy-section-header">
					<div class="privacy-policy-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke-linecap="round" stroke-linejoin="round"/>
							<polyline points="14 2 14 8 20 8" stroke-linecap="round" stroke-linejoin="round"/>
							<line x1="12" y1="18" x2="12" y2="12" stroke-linecap="round" stroke-linejoin="round"/>
							<line x1="9" y1="15" x2="15" y2="15" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="privacy-policy-section-title">Changes to This Privacy Policy</h2>
				</div>
				<div class="privacy-policy-section-body">
					<p class="privacy-policy-text">
						We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.
					</p>
				</div>
			</section>

			<section class="privacy-policy-section">
				<div class="privacy-policy-section-header">
					<div class="privacy-policy-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<h2 class="privacy-policy-section-title">Contact Us</h2>
				</div>
				<div class="privacy-policy-section-body">
					<p class="privacy-policy-text">
						If you have any questions about this Privacy Policy, please contact us through the contact information provided on our website.
					</p>
				</div>
			</section>
		</div>
	</div>
</div>
@endsection

