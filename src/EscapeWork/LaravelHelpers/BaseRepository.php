<?php namespace EscapeWork\LaravelHelpers;

use Illuminate\Support\MessageBag;
use App;

abstract class BaseRepository
{

    /**
     * The model instance
     *
     * @var  Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $messageBag;

    /**
     * The validator
     */
    protected $validator;

    /**
     * The replaced patterns
     *
     * @var array
     */
    public $validationReplacedValues = array(':id:');

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
    public function messages()
    {
        return $this->messageBag;
    }

    public function addMessage($key, $message)
    {
        if (! $this->messageBag) {
            $this->messageBag = new MessageBag;
        }

        $this->messageBag->add($key, $message);
    }

    public function validate()
    {
        $validator       = App::make('validator');
        $rules           = $this->processRules($this->model->validationRules);
        $this->validator = $validator->make($this->model->toArray(), $rules, $this->model->validationMessages);

        if ($this->validator->fails()) {
            $this->messageBag = $this->messageBag ? $this->messageBag->merge($this->validator->messages()) : $this->validator->messages();

            return false;
        }

        return true;
    }

    public function processRules(array $rules = array())
    {
        $model = $this;

        array_walk($rules, function(&$arrRules) use($model)
        {
            array_walk($arrRules, function(&$item) use($model)
            {
                foreach ($model->validationReplacedValues as $key) {
                    $keyFormated = str_replace(':', '', $key);
                    $value       = $model->$keyFormated;

                    $item = stripos($item, $key) !== false ? str_ireplace($key, $value, $item) : $item;
                }
            });
        });

        return $rules;
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
