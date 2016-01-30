<?php

namespace Artisan\API;

use Illuminate\Support\Facades\Input as Input;

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
            'phrase' => $response->getReasonPhrase(),
            'data' => $this->filter($response->getBody())
        ];
    }

    public function multipart($url, $params) {

        $response = $this->client->request(
                'POST', $url, [
            "multipart" => $this->setMultipart($params)
                ]
        );

        return [
            'code' => $response->getStatusCode(),
            'phrase' => $response->getReasonPhrase(),
            'data' => $this->filter($response->getBody())
        ];
    }

    private function filter($data) {
        return json_decode($data);
    }

    private function setMultipart($params) {

        $multipart = [];
        foreach ($params as $key => $value) {
            if (Input::hasFile($key)) {
                $item["name"] = $key;
                $item["filename"] = Input::file($key)->getClientOriginalName();
                $item["contents"] = fopen(Input::file($key)->getRealPath(), 'r');
            } else {
                $item["name"] = $key;
                $item["contents"] = is_array($value) ? json_encode($value) : $value;
            }
            $multipart[] = $item;
        }
    
       
        return $multipart;
    }
    
}
    