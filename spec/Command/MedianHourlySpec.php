<?php

namespace spec\Command;

use Calculator\MetricsCalculator;
use Command\MedianHourly;
use PhpSpec\ObjectBehavior;

class MedianHourlySpec extends ObjectBehavior
{
    function let(MetricsCalculator $calculator)
    {
        $this->beConstructedWith($calculator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MedianHourly::class);
    }
}
