@php
	/**
	 * Props:
	 * - $name string Specialty description/name
	 * - $class string Extra classes for the SVG wrapper
	 */
	$raw = (string) ($name ?? '');
	$key = function_exists('mb_strtolower') ? mb_strtolower(trim($raw), 'UTF-8') : strtolower(trim($raw));
	$icon = 'medical'; // default
	// Basic keyword matching; expand as needed
	$map = [
		'anesthesiology' => 'syringe',
		'anesthesiology, pain medicine' => 'syringe',
		'pain medicine' => 'syringe',
		'cardiology' => 'heart',
		'cardiologist' => 'heart',
		'dentistry' => 'tooth',
		'dentist' => 'tooth',
		'dermatology' => 'skin',
		'dermatologist' => 'skin',
		'neurology' => 'brain',
		'neurologist' => 'brain',
		'oncology' => 'ribbon',
		'psychiatry' => 'brain',
		'orthopedics' => 'bone',
		'orthopaedics' => 'bone',
		'radiology' => 'xray',
		'ophthalmology' => 'eye',
		'gynecology' => 'female',
		'obstetrics & gynecology' => 'female',
		'gynecology & obstetrics' => 'female',
		'obstetrics' => 'female',
		'surgery' => 'scalpel',
		'urology' => 'kidney',
		'gastroenterology' => 'stomach',
		'endocrinology' => 'hormone',
		'family medicine' => 'stethoscope',
		'internal medicine' => 'stethoscope',
		'pediatrics' => 'child',
		'pediatrician' => 'child',
	];
	foreach ($map as $needle => $val) {
		if ($key === $needle || ($needle !== '' && str_contains($key, $needle))) {
			$icon = $val;
			break;
		}
	}
	$size = 'w-4 h-4';
	$stroke = 'stroke-current';
	$color = 'text-sky-600';
	$wrapper = trim(($class ?? '') . ' inline-flex items-center justify-center rounded-md ring-1 ring-inset ring-sky-200 bg-sky-50 ' . $color . ' ' . $size);
@endphp
<span class="{{ $wrapper }}" aria-hidden="true">
	@switch($icon)
		@case('heart')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M21 8.25c0 5.25-9 10.5-9 10.5S3 13.5 3 8.25a4.5 4.5 0 0 1 8.25-2.602A4.5 4.5 0 0 1 21 8.25Z" stroke-width="1.5" />
			</svg>
		@break
		@case('tooth')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M12 21c1.5 0 2-3 3.5-3S18 21 19.5 21c1.5 0 2.5-4.5 2.5-9.5S17.5 3 12 3 2 6.5 2 11.5 3 21 4.5 21 7 18 8.5 18 10.5 21 12 21Z" stroke-width="1.5"/>
			</svg>
		@break
		@case('brain')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M9 4.5a2.5 2.5 0 0 0-5 0V7A3.5 3.5 0 0 0 7.5 10.5H9m6-6a2.5 2.5 0 0 1 5 0V7A3.5 3.5 0 0 1 16.5 10.5H15M9 10.5H7.5A3.5 3.5 0 0 0 4 14v.5A3.5 3.5 0 0 0 7.5 18h1.75M15 10.5h1.5A3.5 3.5 0 0 1 20 14v.5A3.5 3.5 0 0 1 16.5 18H15m-3-7.5v10" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
		@break
		@case('syringe')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="m3.5 17.5 5-5m-3 3L8 18l8.5-8.5M21 5l-3 3M9 12l3 3m5.5-8.5L15 9" stroke-width="1.5" stroke-linecap="round" />
			</svg>
		@break
		@case('stethoscope')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M6 3v5a4 4 0 1 0 8 0V3m-8 0H4m10 0h2M6 8a6 6 0 1 0 12 0m0 0v6a3 3 0 1 1-3 3" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
		@break
		@case('eye')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z" stroke-width="1.5"/>
				<circle cx="12" cy="12" r="3" stroke-width="1.5"/>
			</svg>
		@break
		@case('female')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<circle cx="12" cy="7" r="4" stroke-width="1.5"/>
				<path d="M12 11v10m-3 0h6" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
		@break
		@case('scalpel')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M20 4 9 15l-4 1 1-4L17 1l3 3Z" stroke-width="1.5" stroke-linejoin="round"/>
				<path d="M3 20h10" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
		@break
		@case('kidney')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M9 4a5 5 0 0 0-5 5v6a3 3 0 0 0 3 3h1m7-14a5 5 0 0 1 5 5v6a3 3 0 0 1-3 3h-1" stroke-width="1.5"/>
			</svg>
		@break
		@case('stomach')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M10 3v5a4 4 0 0 0 4 4h2a4 4 0 0 1 0 8h-2a7 7 0 0 1-7-7V6" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
		@break
		@case('hormone')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<circle cx="7" cy="7" r="3" stroke-width="1.5"/><circle cx="17" cy="17" r="3" stroke-width="1.5"/><path d="M9.5 9.5 14.5 14.5" stroke-width="1.5"/>
			</svg>
		@break
		@case('child')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<circle cx="12" cy="7" r="3" stroke-width="1.5"/><path d="M6 21v-3a6 6 0 1 1 12 0v3" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
		@break
		@case('bone')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M6 7a2 2 0 1 1 2-2l8 8a2 2 0 1 1-2 2l-8-8Z" stroke-width="1.5"/>
			</svg>
		@break
		@case('xray')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<rect x="4" y="3" width="16" height="18" rx="2" stroke-width="1.5"/><path d="M7 7h10M7 11h10M7 15h10" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
		@break
		@case('ribbon')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M12 5a4 4 0 1 1 0 8c-2 0-5-4-5-4s3-4 5-4Zm0 0c1.5 0 5 8 5 8l-3 6-2-4-2 4-3-6s3.5-8 5-8Z" stroke-width="1.5" stroke-linejoin="round"/>
			</svg>
		@break
		@case('skin')
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M12 3v4c0 2-2 3-4 3H6a3 3 0 0 0-3 3v5h18v-5a3 3 0 0 0-3-3h-2c-2 0-4-1-4-3V3" stroke-width="1.5"/>
			</svg>
		@break
		@default
			<!-- medical cross -->
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $size }} {{ $stroke }}" fill="none">
				<path d="M12 4v16M4 12h16" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
	@endswitch
</span>

