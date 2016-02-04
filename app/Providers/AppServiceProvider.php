<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Blade::directive('check', function($expression) {
            return "<?php if (\Policy::check($expression)->decide()): ?>";
        });

        Blade::directive('endcheck', function($expression) {
            return "<?php endif; ?>";
        });

        Blade::directive('inArray', function($needle) {
            return "<?php if (@in_array(".$needle[0].",".$needle[1].")): ?>";
        });

        Blade::directive('endinArray', function($expression) {
            return "<?php endif; ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
