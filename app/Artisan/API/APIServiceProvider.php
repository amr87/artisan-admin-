<?php

namespace Artisan\API;

use Illuminate\Support\ServiceProvider;
use \GuzzleHttp\Client;

class APIServiceProvider extends ServiceProvider {

    public function register() {

        $this->app->bind("API", function() {
            $client = new Client(
                    [
                    'base_uri' => getenv("API_URL"),
                    'http_errors' => false,
                    'expect' => true
                    ]
            );

            return new APIClient($client);
        });
    }

}
