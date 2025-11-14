@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="max-w-4xl mx-auto">
	<div class="bg-white rounded-2xl border shadow-sm p-6 sm:p-8 md:p-10">
		<h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Privacy Policy</h1>
		<p class="text-gray-600 mb-8">Last updated: {{ date('F j, Y') }}</p>

		<div class="prose prose-lg max-w-none">
			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Introduction</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					Welcome to DocDoc. We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Information We Collect</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					We may collect information about you in a variety of ways. The information we may collect includes:
				</p>
				<ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
					<li>Personal data such as name, email address, and contact information that you voluntarily provide</li>
					<li>Usage data including your IP address, browser type, and pages you visit on our site</li>
					<li>Search queries and preferences to improve your experience</li>
				</ul>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">How We Use Your Information</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					We use the information we collect to:
				</p>
				<ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
					<li>Provide, maintain, and improve our services</li>
					<li>Respond to your inquiries and provide customer support</li>
					<li>Send you updates and communications related to our services</li>
					<li>Analyze usage patterns to enhance user experience</li>
					<li>Ensure the security and integrity of our platform</li>
				</ul>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Data Security</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet or electronic storage is 100% secure.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Cookies and Tracking Technologies</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					We may use cookies and similar tracking technologies to track activity on our website and store certain information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Third-Party Services</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					Our website may contain links to third-party websites or services. We are not responsible for the privacy practices of these third parties. We encourage you to read their privacy policies.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Your Rights</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					You have the right to:
				</p>
				<ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
					<li>Access and receive a copy of your personal data</li>
					<li>Request correction of inaccurate personal data</li>
					<li>Request deletion of your personal data</li>
					<li>Object to processing of your personal data</li>
					<li>Request restriction of processing your personal data</li>
				</ul>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Changes to This Privacy Policy</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Contact Us</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					If you have any questions about this Privacy Policy, please contact us through the contact information provided on our website.
				</p>
			</section>
		</div>
	</div>
</div>
@endsection

