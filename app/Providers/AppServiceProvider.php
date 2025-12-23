<?php

namespace App\Providers;

use Illuminate\Http\Request;
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
        $request = request();
        $default = strtoupper(config('states.default', 'CA'));
        
        // Check query parameter first
        $preferredState = strtoupper((string) ($request->query('state', '')));
        
        // If no query param, check route parameter (e.g., /states/co)
        if ($preferredState === '') {
            $route = $request->route();
            if ($route && $route->hasParameter('state')) {
                $preferredState = strtoupper((string) $route->parameter('state'));
            } else {
                // Fallback: parse URL path manually if route not resolved yet
                $path = $request->path();
                if (preg_match('#^states/([a-z]{2})$#i', $path, $matches)) {
                    $preferredState = strtoupper($matches[1]);
                }
            }
        }
        
        // If still no state, check session
        if ($preferredState === '') {
            $preferredState = strtoupper(session('preferred_state', $default));
        }
        
        // Fallback to default
        if ($preferredState === '') {
            $preferredState = $default;
        }
        
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
