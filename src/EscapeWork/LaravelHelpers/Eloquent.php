<?php namespace EscapeWork\LaravelHelpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Str;
use Validator;
use App;

class Eloquent extends Model
{

    /**
     * Validation rules
     *
     * @var array
     */
    public static $validationRules = array();

    /**
     * Validation messages
     *
     * @var array
     */
    public static $validationMessages = array();

    /**
     * Validation set os messages when fails
     *
     * @var array
     */
    public static $messages = array();

     /**
     * The message bag
     *
     * @var array
     */
    public $messageBag;

    /**
     * Setting if the model is 'sluggable'
     * When setting this to true, the save and update methos are going to make and slug before save
     *
     * @var  boolean
     */
    protected $sluggable = false;

    /**
     * Sluggable attribute
     * @var  string
     */
    protected $sluggableAttr = 'title';

    /**
     * The Validator factory instance.
     *
     * @var Illuminate\Validation\Factory
     */
    protected $validatorFactory;

    /**
     * The Validator instance.
     *
     * @var Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Create a new instance.
     *
     * @param  array  $attributes
     * @param  Illuminate\Validation\Factory  $validator
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->validatorFactory = App::make('validator');
    }


    /**
     * Validating the model fields
     */
    public function validate(array $rules = array())
    {
        $rules           = $this->processRules($rules ? $rules : static::$validationRules);
        $messages        = static::$validationMessages;
        $this->validator = $this->validatorFactory->make($this->attributes, $rules, $messages);

        if ($this->validator->fails()) {
            $this->messageBag = $this->validator->messages();
            static::$messages = $this->messageBag->getMessages();

            return false;
        }

        return true;
    }

    /**
     * Process validation rules.
     *
     * @param  array  $rules
     * @return array  $rules
     */
    protected function processRules($rules = array())
    {
        $id = $this->getKey();

        array_walk($rules, function(&$arrRules) use ($id)
        {
            array_walk($arrRules, function(&$item) use ($id)
            {
                $item = stripos($item, ':id:') !== false ? str_ireplace(':id:', $id, $item) : $item;
            });
        });

        return $rules;
    }

    /**
     * Gerando um HTML Select com TODAS as opções
     *
     * @access  public
     * @param   int    $id  [com o ID atual]
     * @return  string      [HTML Select]
     */
    public function HTMLOptions($id = null, $field = 'title', $all = null)
    {
        $class      = get_called_class();
        $object     = new $class;
        $primaryKey = $object->primaryKey;
        $all        = is_null($all) ? static::all() : $all;
        $html       = '';

        foreach ($all as $item) {
            $html .= '<option value="'.$item->$primaryKey.'" '.( $id == $item->$primaryKey ? 'selected="selected"' : null ).'>'.$item->$field.'</option>';
        }

        return $html;
    }

    /**
     * Reescrevendo a função Model::update para fazer o slug se nessesário
     */
    public function update(array $attributes = array())
    {
        if ($this->isSluggable()) {
            $this->makeSlug();
        }

        return parent::update($attributes);
    }

    /**
     * Reescrevendo a função Model::save para fazer o slug se nessesário
     */
    public function save(array $options = array())
    {
        if ($this->isSluggable()) {
            $this->makeSlug();
        }

        return parent::save($options);
    }

    /**
     * Returning if this model is sluggable
     */
    protected function isSluggable()
    {
        return $this->sluggable;
    }

    /**
     * Creating the product slug
     */
    public function makeSlug()
    {
        $attr       = $this->sluggableAttr;
        $this->slug = Str::slug($this->$attr);
        $count      = 0;

        while ($this->where('slug', '=', $this->slug)->where('id', '<>', $this->id)->first()) {
            $count++;
            $this->slug = Str::slug($this->$attr) . '-' . $count;
        }
    }

    /**
     * Setting if the model is sluggable
     *
     * @param  boolean $sluggable
     */
    public function setSluggable($sluggable)
    {
        $this->sluggable = $sluggable;
    }

    /**
     * Find or fail by $field
     */
    public function findOrFailBy($field, $value)
    {
        if ($model = $this->where($field, '=', $value)->first()) {
            return $model;
        }

        throw new ModelNotFoundException;
    }
}
