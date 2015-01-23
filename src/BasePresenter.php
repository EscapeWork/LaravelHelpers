<?php namespace EscapeWork\LaravelHelpers;

abstract class BasePresenter
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function __get($field)
    {
        if (method_exists($this, $field)) {
            return $this->{$field}();
        }

        return $this->model->{$field};
    }
}
