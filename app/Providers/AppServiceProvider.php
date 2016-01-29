<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         Blade::directive('check', function($expression) {
            return "<?php if (\Policy::check($expression)->decide()): ?>";
        });
         Blade::directive('endcheck', function($expression) {
            return "<?php endif; ?>";
        });
        

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
