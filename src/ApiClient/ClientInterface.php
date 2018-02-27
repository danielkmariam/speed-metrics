<?php
namespace ApiClient;

/**
 * Interface ClientInterface
 */
interface ClientInterface
{
    /**
     * @param string $method
     * @param string $endpoint
     *
     * @return mixed
     */
    public function request(string $method, string $endpoint);
}
