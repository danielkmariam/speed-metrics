<?php

namespace spec\Command;

use Command\MaximumHourly;
use Command\MeanHourly;
use Command\MedianHourly;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Repository\MetricsRepository;

class MedianHourlySpec extends ObjectBehavior
{
    function let(MetricsRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MedianHourly::class);
    }
}
