<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('date', function ($expression) {
            $default = "'jS F Y'";
            $parts = str_getcsv($expression);
            $parts[1] = (isset($parts[1])) ? $parts[1] : $default;
            return '<?php if(' . $parts[0] . '){ echo e(' . $parts[0] . '->format(' . $parts[1] . '));} ?>';
        });
    }
}
