<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
	protected function resolvePreferredState(Request $request, bool $allowEmpty = false): string
	{
		$default = strtoupper(config('states.default', 'CA'));
		$state = strtoupper((string) $request->query('state', ''));

		if ($request->has('state')) {
			if ($state !== '') {
				session(['preferred_state' => $state]);
			} elseif (!$allowEmpty) {
				$state = session('preferred_state', $default);
			}
		} else {
			$state = session('preferred_state', $default);
		}

		return $state !== '' ? $state : ($allowEmpty ? '' : $default);
	}
}
