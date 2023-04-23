<?php

namespace App\Traits;

// use tcdent/php-restclient/restclient/RestClient;

trait HTTPTrait
{
    /**
     * Send an HTTP GET request to the specified URL.
     *
     * @param string $url The URL to send the request to.
     * @param array $headers Optional headers to include with the request.
     * @return mixed The response from the server, or false if the request failed.
     */
    public function get($url, $headers = array())
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url, [
                'headers' => array_merge($headers, ['Accept'     => 'application/json'])
            ]);

            if ($response->getStatusCode() < 300)
                return false;
            return $response->getBody()->getContents();
        } catch (\Throwable $th) {
            //log error 
            return false;
        }
    }

    /**
     * Send an HTTP POST request to the specified URL with the specified data.
     *
     * @param string $url The URL to send the request to.
     * @param array|string $data The data to send with the request.
     * @param array $headers Optional headers to include with the request.
     * @return mixed The response from the server, or false if the request failed.
     */
    public function post($url, $data, $headers = [])
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                // 'body' =>  json_encode(''),
                'form_params' => $data,
                'headers' => array_merge($headers, ['Accept'     => 'application/json'])
            ]);

            if ($response->getStatusCode() < 300)
                return false;
            return $response->getBody()->getContents();
        } catch (\Throwable $th) {
            //log error 
            return false;
        }
    }

    /**
     * Send an HTTP PUT request to the specified URL with the specified data.
     *
     * @param string $url The URL to send the request to.
     * @param array|string $data The data to send with the request.
     * @param array $headers Optional headers to include with the request.
     * @return mixed The response from the server, or false if the request failed.
     */
    public function put($url, $data, $headers = array())
    {
        $client = new Client();
        $client->setHeaders($headers);
        return $client->put($url, $data);
    }

    /**
     * Send an HTTP DELETE request to the specified URL.
     *
     * @param string $url The URL to send the request to.
     * @param array $headers Optional headers to include with the request.
     * @return mixed The response from the server, or false if the request failed.
     */
    public function delete($url, $headers = array())
    {
        $client = new Client();
        $client->setHeaders($headers);
        return $client->delete($url);
    }
}
