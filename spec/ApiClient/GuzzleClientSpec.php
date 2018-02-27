<?php

namespace spec\ApiClient;

use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;

class GuzzleClientSpec extends ObjectBehavior
{
    function it_fetches_data_from_remote(Response $response)
    {
//        $this->request('GET', 'http://tech-test.com/')->shouldBeLike($response);
    }
}
