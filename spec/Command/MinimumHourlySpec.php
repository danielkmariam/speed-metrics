<?php

namespace spec\Command;

use Command\MaximumHourly;
use Command\MinimumHourly;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Repository\MetricsRepository;

class MinimumHourlySpec extends ObjectBehavior
{
    function let(MetricsRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MinimumHourly::class);
    }
}
