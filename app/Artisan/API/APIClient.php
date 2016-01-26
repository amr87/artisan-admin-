<?php

namespace Artisan\API;

class APIClient {

    protected $client;
    protected $headers = [
        'Accept' => 'application/json'
    ];

    public function __construct($client) {

        $this->client = $client;
    }

    public function get($url, $headers, $params) {

        $response = $this->client->request(
                'GET', $url, [
            "headers" => array_merge($this->headers, $headers),
            "query" => $params
                ]
        );

        return [
            'code' => $response->getStatusCode(),
            'data' => $this->filter($response->getBody())
        ];
    }

    public function post($url, $headers, $params) {

        $response = $this->client->request(
                'POST', $url, [
            "headers" => array_merge($this->headers, $headers),
            "form_params" => $params
                ]
        );

        return [
            'code' => $response->getStatusCode(),
            'phrase' => $response->getReasonPhrase(),
            'data' => $this->filter($response->getBody())
        ];
    }

    public function upload($url, $params) {

        $response = $this->client->request(
                'POST', $url, [
            "headers" => "Content-Type => multipart/form-data"
                ], [
                ], [
                ]
                , $params
        );

        return [
            'code' => $response->getStatusCode(),
            'data' => $this->filter($response->getBody())
        ];
    }

    private function filter($data) {
        return json_decode($data);
    }

}
