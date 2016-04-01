<?php

namespace Artisan\Policy;

use Illuminate\Support\ServiceProvider;
use \GuzzleHttp\Client;

class PolicyServiceProvider extends ServiceProvider {

    public function register() {

        $this->app->bind("Policy", function() {

            return new ACL();
        });
    }

}
