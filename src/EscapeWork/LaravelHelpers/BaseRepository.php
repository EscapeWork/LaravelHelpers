<?php namespace EscapeWork\LaravelHelpers;

abstract class BaseRepository
{

    /**
     * The model instance
     *
     * @var  Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Set hte model instance
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Get hte model instance
     */
    public function getModel()
    {
        return $this->model;
    }

    public function find($id)
    {
        if ($model = $this->model->find($id)) {
            $this->model = $model;
            return $this;
        }

        return null;
    }

    public function findOrFail($id)
    {
        $this->model = $this->model->findOrFail($id);
        return $this;
    }

    public function findOrFailBy($field, $value)
    {
        $this->model = $this->model->findOrFailBy($field, $value);
        return $this;
    }

    /**
     * @return Illuminate\Support\MessageBag
     */
    public function getValidationErrors()
    {
        return $this->model->messageBag;
    }

    public function __get($key)
    {
        return $this->model->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->model->setAttribute($key, $value);
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->model, $method), $args);
    }
}
