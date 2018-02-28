<?php

namespace spec\Command;

use Command\UnitMetrics;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Repository\MetricsRepository;

class UnitMetricsSpec extends ObjectBehavior
{
    function let(MetricsRepository $repository)
    {
        $this->beConstructedWith($repository);
    }
}
