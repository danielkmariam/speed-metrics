<?php

namespace spec\Command;

use Command\SampleSize;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SampleSizeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SampleSize::class);
    }
}
