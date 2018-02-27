<?php

namespace ApiClient;

/**
 * Class DataPointService
 */
class DataPointService
{
    const GET = 'GET';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @param ClientInterface $client
     * @param string          $endpoint
     */
    public function __construct(ClientInterface $client, string $endpoint)
    {
        $this->client = $client;
        $this->endpoint = $endpoint;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->client
            ->request(self::GET, $this->endpoint)
            ->getBody()
            ->getContents();
    }
}
