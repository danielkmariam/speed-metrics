<?php

namespace spec\Calculator;

use Calculator\MetricsCalculator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Repository\MetricsRepository;

class MetricsCalculatorSpec extends ObjectBehavior
{
    function let(MetricsRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_calculates_median_value_of_empty_collection(MetricsRepository $repository)
    {
        $data = [];

        $repository->fetchHourlyMetrics('download', 1, '1am')->willReturn($data);

        $this->calculateMedian('download', 1, '1am')->shouldReturn(0);
    }

    function it_calculates_median_value_of_odd_collection(MetricsRepository $repository)
    {
        $data = [1, 2, 3];

        $repository->fetchHourlyMetrics('download', 1, '1am')->willReturn($data);

        $this->calculateMedian('download', 1, '1am')->shouldReturn(2);
    }

    function it_calculates_median_value_of_even_collection(MetricsRepository $repository)
    {
        $data = [1, 2, 3, 4];

        $repository->fetchHourlyMetrics('download', 1, '1am')->willReturn($data);

        $this->calculateMedian('download', 1, '1am')->shouldReturn(2.5);
    }
}
