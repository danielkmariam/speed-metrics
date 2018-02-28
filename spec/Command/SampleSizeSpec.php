<?php

namespace spec\Command;

use Command\SampleSize;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Repository\MetricsRepository;

class SampleSizeSpec extends ObjectBehavior
{
    function let(MetricsRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SampleSize::class);
    }
}
