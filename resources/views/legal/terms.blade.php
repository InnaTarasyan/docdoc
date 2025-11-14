@extends('layouts.app')

@section('title', 'Terms of Use')

@section('content')
<div class="max-w-4xl mx-auto">
	<div class="bg-white rounded-2xl border shadow-sm p-6 sm:p-8 md:p-10">
		<h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Terms of Use</h1>
		<p class="text-gray-600 mb-8">Last updated: {{ date('F j, Y') }}</p>

		<div class="prose prose-lg max-w-none">
			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Agreement to Terms</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					By accessing and using DocDoc, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Use License</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					Permission is granted to temporarily access the materials on DocDoc's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
				</p>
				<ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
					<li>Modify or copy the materials</li>
					<li>Use the materials for any commercial purpose or for any public display</li>
					<li>Attempt to reverse engineer any software contained on the website</li>
					<li>Remove any copyright or other proprietary notations from the materials</li>
					<li>Transfer the materials to another person or "mirror" the materials on any other server</li>
				</ul>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Disclaimer</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					The materials on DocDoc's website are provided on an 'as is' basis. DocDoc makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Limitations</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					In no event shall DocDoc or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on DocDoc's website, even if DocDoc or a DocDoc authorized representative has been notified orally or in writing of the possibility of such damage.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Accuracy of Materials</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					The materials appearing on DocDoc's website could include technical, typographical, or photographic errors. DocDoc does not warrant that any of the materials on its website are accurate, complete, or current. DocDoc may make changes to the materials contained on its website at any time without notice.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Links</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					DocDoc has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by DocDoc of the site. Use of any such linked website is at the user's own risk.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Modifications</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					DocDoc may revise these terms of service for its website at any time without notice. By using this website you are agreeing to be bound by the then current version of these terms of service.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Governing Law</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					These terms and conditions are governed by and construed in accordance with applicable laws and you irrevocably submit to the exclusive jurisdiction of the courts in that location.
				</p>
			</section>

			<section class="mb-8">
				<h2 class="text-2xl font-semibold text-gray-900 mb-4">Contact Information</h2>
				<p class="text-gray-700 leading-relaxed mb-4">
					If you have any questions about these Terms of Use, please contact us through the contact information provided on our website.
				</p>
			</section>
		</div>
	</div>
</div>
@endsection

