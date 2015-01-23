<?php

namespace spec\EscapeWork\LaravelHelpers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use EscapeWork\LaravelHelpers\PresentableTrait;

class Presenter
{

    use PresentableTrait;
}

class PresentableTraitSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->beAnInstanceOf('spec\EscapeWork\LaravelHelpers\Presenter');
    }

    function it_can_test()
    {

    }
}
