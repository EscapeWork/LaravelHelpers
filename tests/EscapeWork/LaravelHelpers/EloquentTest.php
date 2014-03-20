<?php namespace EscapeWork\LaravelHelpers;

use PHPUnit_Framework_TestCase;
use Mockery as m;

class EloquentTest extends PHPUnit_Framework_TestCase
{

    /**
     * @testdox EscapeWork\LaravelHelpers\Eloquent::validate
     */
    public function test_validate_with_valid_data()
    {
        $validator = m::mock('Validator');
        $validator->shouldReceive('fails')->once()->andReturn(false);

        $validatorFactory = m::mock('ValidatorFactory');
        $validatorFactory->shouldReceive('make')->once()->with(array(), array(), array())->andReturn($validator);

        $eloquent = $this->getMockForAbstractClass('EscapeWork\LaravelHelpers\Eloquent', array(array(), $validatorFactory));
        $this->assertTrue($eloquent->validate(array()));
    }

    /**
     * @testdox EscapeWork\LaravelHelpers\Eloquent::validate
     */
    public function test_validate_with_invalid_data()
    {
        $messageBag = m::mock('MessageBag');
        $messageBag->shouldReceive('getMessages')->once()->andReturn(['name' => array()]);

        $validator = m::mock('Validator');
        $validator->shouldReceive('fails')->once()->andReturn(true);
        $validator->shouldReceive('messages')->once()->withNoArgs()->andReturn($messageBag);

        $validatorFactory = m::mock('ValidatorFactory');
        $validatorFactory->shouldReceive('make')->once()->with(array(), array(), array())->andReturn($validator);

        $eloquent = $this->getMockForAbstractClass('EscapeWork\LaravelHelpers\Eloquent', array(array(), $validatorFactory));
        $this->assertFalse($eloquent->validate(array()));
        $this->assertEquals($messageBag, $eloquent->messageBag);
    }

    /**
     * @testdox EscapeWork\LaravelHelpers\Eloquent::findOrFailBy
     */
    public function test_find_or_fail_by_with_resource_found()
    {
        $eloquent = m::mock('EscapeWork\LaravelHelpers\Eloquent[where,first]', array(array(), new \stdClass));
        $eloquent->shouldReceive('where')->once()->with('slug', '=', 'laravel-helpers-eloquent')->andReturn($eloquent);
        $eloquent->shouldReceive('first')->once()->withNoArgs()->andReturn($eloquent);

        $this->assertEquals($eloquent, $eloquent->findOrFailBy('slug', 'laravel-helpers-eloquent'));
    }

    /**
     * @testdox EscapeWork\LaravelHelpers\Eloquent::findOrFailBy
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_find_or_fail_by_with_resource_not_found()
    {
        $eloquent = m::mock('EscapeWork\LaravelHelpers\Eloquent[where,first]', array(array(), new \stdClass));
        $eloquent->shouldReceive('where')->once()->with('slug', '=', 'codeigniter')->andReturn($eloquent);
        $eloquent->shouldReceive('first')->once()->withNoArgs()->andReturn(false);

        $this->assertEquals($eloquent, $eloquent->findOrFailBy('slug', 'codeigniter'));
    }

    /**
     * @testdox EscapeWork\LaravelHelpers\Eloquent::processRules
     */
    public function test_process_rules()
    {
        $rules                              = array('title' => array('required', 'unique:users,email,:id:,company_id,:company_id:'));
        $eloquent                           = $this->getMockForAbstractClass('EscapeWork\LaravelHelpers\Eloquent', array([], new \stdClass));
        $eloquent->validationReplacedValues = array(':id:', ':company_id:');
        $rulesFormated                      = $eloquent->processRules($rules);

        $this->assertEquals($rulesFormated, array('title' => array('required', 'unique:users,email,,company_id,')));
    }
}
