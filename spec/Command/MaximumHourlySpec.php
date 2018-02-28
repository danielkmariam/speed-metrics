<?php

namespace spec\Command;

use Command\MaximumHourly;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Repository\MetricsRepository;

class MaximumHourlySpec extends ObjectBehavior
{
    function let(MetricsRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MaximumHourly::class);
    }
}
