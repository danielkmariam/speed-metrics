<?php

namespace ApiClient;

use GuzzleHttp\Client;

/**
 * Class GuzzleClient
 */
class GuzzleClient implements ClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $method
     * @param string $endpoint
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function request(string $method, string $endpoint)
    {
        return $this->client->request($method, $endpoint);
    }
}
