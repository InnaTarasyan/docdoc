@extends('layouts.app')

@section('title', 'Terms of Use')

@section('content')
<div class="terms-of-use-container">
	<div class="terms-of-use-wrapper">
		<!-- Header Section -->
		<div class="terms-of-use-header">
			<div class="terms-of-use-header-content">
				<div class="terms-of-use-icon-wrapper">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="terms-of-use-icon">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
					</svg>
				</div>
				<h1 class="terms-of-use-title">Terms of Use</h1>
				<p class="terms-of-use-date">
					Last updated: <span class="terms-of-use-date-value">{{ date('F j, Y') }}</span>
				</p>
			</div>
		</div>

		<!-- Content Sections -->
		<div class="terms-of-use-content">
			<section class="terms-of-use-section">
				<div class="terms-of-use-section-header">
					<div class="terms-of-use-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</div>
					<h2 class="terms-of-use-section-title">Agreement to Terms</h2>
				</div>
				<div class="terms-of-use-section-body">
					<p class="terms-of-use-text">
						By accessing and using PrimeDoctors, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
					</p>
				</div>
			</section>

			<section class="terms-of-use-section">
				<div class="terms-of-use-section-header">
					<div class="terms-of-use-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
						</svg>
					</div>
					<h2 class="terms-of-use-section-title">Use License</h2>
				</div>
				<div class="terms-of-use-section-body">
					<p class="terms-of-use-text">
						Permission is granted to temporarily access the materials on PrimeDoctors' website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
					</p>
					<ul class="terms-of-use-list">
						<li class="terms-of-use-list-item">
							<span class="terms-of-use-list-bullet"></span>
							<span>Modify or copy the materials</span>
						</li>
						<li class="terms-of-use-list-item">
							<span class="terms-of-use-list-bullet"></span>
							<span>Use the materials for any commercial purpose or for any public display</span>
						</li>
						<li class="terms-of-use-list-item">
							<span class="terms-of-use-list-bullet"></span>
							<span>Attempt to reverse engineer any software contained on the website</span>
						</li>
						<li class="terms-of-use-list-item">
							<span class="terms-of-use-list-bullet"></span>
							<span>Remove any copyright or other proprietary notations from the materials</span>
						</li>
						<li class="terms-of-use-list-item">
							<span class="terms-of-use-list-bullet"></span>
							<span>Transfer the materials to another person or "mirror" the materials on any other server</span>
						</li>
					</ul>
				</div>
			</section>

			<section class="terms-of-use-section">
				<div class="terms-of-use-section-header">
					<div class="terms-of-use-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
						</svg>
					</div>
					<h2 class="terms-of-use-section-title">Disclaimer</h2>
				</div>
				<div class="terms-of-use-section-body">
					<p class="terms-of-use-text">
						The materials on PrimeDoctors' website are provided on an 'as is' basis. PrimeDoctors makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.
					</p>
				</div>
			</section>

			<section class="terms-of-use-section">
				<div class="terms-of-use-section-header">
					<div class="terms-of-use-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
						</svg>
					</div>
					<h2 class="terms-of-use-section-title">Limitations</h2>
				</div>
				<div class="terms-of-use-section-body">
					<p class="terms-of-use-text">
						In no event shall PrimeDoctors or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on PrimeDoctors' website, even if PrimeDoctors or a PrimeDoctors authorized representative has been notified orally or in writing of the possibility of such damage.
					</p>
				</div>
			</section>

			<section class="terms-of-use-section">
				<div class="terms-of-use-section-header">
					<div class="terms-of-use-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
						</svg>
					</div>
					<h2 class="terms-of-use-section-title">Accuracy of Materials</h2>
				</div>
				<div class="terms-of-use-section-body">
					<p class="terms-of-use-text">
						The materials appearing on PrimeDoctors' website could include technical, typographical, or photographic errors. PrimeDoctors does not warrant that any of the materials on its website are accurate, complete, or current. PrimeDoctors may make changes to the materials contained on its website at any time without notice.
					</p>
				</div>
			</section>

			<section class="terms-of-use-section">
				<div class="terms-of-use-section-header">
					<div class="terms-of-use-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
						</svg>
					</div>
					<h2 class="terms-of-use-section-title">Links</h2>
				</div>
				<div class="terms-of-use-section-body">
					<p class="terms-of-use-text">
						PrimeDoctors has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by PrimeDoctors of the site. Use of any such linked website is at the user's own risk.
					</p>
				</div>
			</section>

			<section class="terms-of-use-section">
				<div class="terms-of-use-section-header">
					<div class="terms-of-use-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
						</svg>
					</div>
					<h2 class="terms-of-use-section-title">Modifications</h2>
				</div>
				<div class="terms-of-use-section-body">
					<p class="terms-of-use-text">
						PrimeDoctors may revise these terms of service for its website at any time without notice. By using this website you are agreeing to be bound by the then current version of these terms of service.
					</p>
				</div>
			</section>

			<section class="terms-of-use-section">
				<div class="terms-of-use-section-header">
					<div class="terms-of-use-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
						</svg>
					</div>
					<h2 class="terms-of-use-section-title">Governing Law</h2>
				</div>
				<div class="terms-of-use-section-body">
					<p class="terms-of-use-text">
						These terms and conditions are governed by and construed in accordance with applicable laws and you irrevocably submit to the exclusive jurisdiction of the courts in that location.
					</p>
				</div>
			</section>

			<section class="terms-of-use-section">
				<div class="terms-of-use-section-header">
					<div class="terms-of-use-section-icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
						</svg>
					</div>
					<h2 class="terms-of-use-section-title">Contact Information</h2>
				</div>
				<div class="terms-of-use-section-body">
					<p class="terms-of-use-text">
						If you have any questions about these Terms of Use, please contact us through the contact information provided on our website.
					</p>
				</div>
			</section>
		</div>
	</div>
</div>
@endsection


