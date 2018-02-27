<?php

namespace spec\Command;

use Command\AggregateData;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Response\AggregateJson;

class AggregateDataSpec extends ObjectBehavior
{
    function let(AggregateJson $aggregateJson)
    {
        $this->beConstructedWith($aggregateJson);
    }
}
