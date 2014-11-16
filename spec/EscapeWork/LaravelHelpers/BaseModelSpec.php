<?php

namespace spec\EscapeWork\LaravelHelpers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Model extends \EscapeWork\LaravelHelpers\BaseModel
{

    public function setDateAttribute($date)
    {
        return $this->_setDateAttribute('date', $date);
    }

    public function setPriceAttribute($price)
    {
        return $this->_setCurrencyAttribute('price', $price);
    }
}

class BaseModelSpec extends ObjectBehavior
{

    function let()
    {
        $this->beAnInstanceOf('spec\EscapeWork\LaravelHelpers\Model');
    }

    function it_can_convert_to_brl_currency()
    {
        $this->price = '12,90';
        $this->getAttribute('price')->shouldBe(12.9);
    }

    function it_can_convert_to_date_attribute_from_brazilian_format()
    {
        $this->date = '10/03/1991';
        $this->getAttribute('date')->shouldReturnAnInstanceOf('Carbon\Carbon');
    }
}
