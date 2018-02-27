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
        $result = [];

        $client->request('GET', $this->endpoint)->shouldBeCalled()->willReturn($response);
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($result);

        $this->get()->shouldReturn($result);
    }
}
