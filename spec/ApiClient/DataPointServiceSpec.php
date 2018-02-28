<?php

namespace spec\ApiClient;

use ApiClient\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PhpSpec\ObjectBehavior;

class DataPointServiceSpec extends ObjectBehavior
{
    private $endpoint;

    function let(ClientInterface $client)
    {
        $this->endpoint = 'http://mock-tech-test.com/';
        $this->beConstructedWith($client, $this->endpoint);
    }

    function it_should_return_data_set(ClientInterface $client, Response $response, Stream $body)
    {
        $jsonData = '[{
            "unit_id": 1,
            "metrics": {
              "download": [
                {
                  "timestamp": "2017-02-10 17:00:00",
                  "value": 4670170
                },
                {
                  "timestamp": "2017-02-10 18:00:00",
                  "value": 4670000
                }
              ],
              "upload": [
                {
                  "timestamp": "2017-02-28 17:00:00",
                  "value": 1214720
                }
              ],
              "latency": [
                {
                  "timestamp": "2017-02-22 16:00:00",
                  "value": 44868
                }
              ],
              "packet_loss": [
                {
                  "timestamp": "2017-02-08 05:00:00",
                  "value": 0.12
                }
              ]
            }
        }]';

        $client->request('GET', $this->endpoint)->shouldBeCalled()->willReturn($response);
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($jsonData);

        $this->get()->shouldBeLike(\GuzzleHttp\json_decode($jsonData));
    }
}
