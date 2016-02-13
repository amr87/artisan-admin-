<?php

namespace Artisan\API;

use Illuminate\Support\Facades\Input as Input;

class APIClient {

    private $client;
    private $headers = [
        'Accept' => 'application/json'
    ];
    private $successCodes = [200, 201];

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

        return $this->sanitizeResponse($response);
    }

    public function post($url, $headers, $params) {

        $response = $this->client->request(
                'POST', $url, [
            "headers" => array_merge($this->headers, $headers),
            "form_params" => $params
                ]
        );

        return $this->sanitizeResponse($response);
    }

    public function multipart($url, $headers, $params) {

        $response = $this->client->request(
                'POST', $url, [
            "headers" => array_merge($this->headers, $headers),
            "multipart" => $this->setMultipart($params)
                ]
        );

        return $this->sanitizeResponse($response);
    }

    private function sanitizeResponse($response) {

        if (!in_array($response->getStatusCode(), $this->successCodes)) {

            $data = $this->filter($response->getBody());

            if (is_array($data)) {
                $obj = new \stdClass();
                $obj->messages = $data;
            } else {
                $obj = $data;
            }

            return [
                'code' => $response->getStatusCode(),
                'data' => $obj
            ];
        } else {
            return [
                'code' => $response->getStatusCode(),
                'data' => $this->filter($response->getBody())
            ];
        }
    }

    private function filter($data) {

        return json_decode($data);
    }

    private function setMultipart($params) {

        $multipart = [];
        foreach ($params as $key => $value) {
            if (Input::hasFile($key)) {

                $handle = fopen(Input::file($key)->getRealPath(), 'rb');

                $item["name"] = $key;
                $item["filename"] = Input::file($key)->getClientOriginalName();
                $item["contents"] = fread($handle, filesize(Input::file($key)->getRealPath()));
                
                fclose($handle);
                
            } else {
                $item["name"] = $key;
                $item["contents"] = is_array($value) ? json_encode($value) : $value;
            }
            $multipart[] = $item;
        }

        
        return $multipart;
    }

}
