<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $preferredState = strtoupper(session('preferred_state', config('states.default', 'CA')));
        $stateNames = config('states.names', []);

        View::share('preferredState', $preferredState);
        View::share('preferredStateName', $stateNames[$preferredState] ?? $preferredState);

        $statePickerOptions = [];
        if (!empty($stateNames)) {
            ksort($stateNames);
            foreach ($stateNames as $abbr => $name) {
                $statePickerOptions[] = [
                    'abbr' => $abbr,
                    'name' => $name,
                ];
            }
        }

        View::share('statePickerOptions', $statePickerOptions);
    }
}
