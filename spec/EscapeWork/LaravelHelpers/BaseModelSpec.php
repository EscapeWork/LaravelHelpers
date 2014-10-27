<?php

namespace spec\EscapeWork\LaravelHelpers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseModelSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->beAnInstanceOf('EscapeWork\LaravelHelpers\BaseModel');
    }
}
