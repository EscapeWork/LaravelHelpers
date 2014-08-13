<?php namespace EscapeWork\LaravelHelpers;

use EscapeWork\LaravelHelpers\BaseCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Carbon\Carbon;
use InvalidArgumentException;

abstract class BaseModel extends Model
{

    /**
     * Validation rules
     *
     * @var array
     */
    public $validationRules = array();

    /**
     * Validation messages
     *
     * @var array
     */
    public $validationMessages = array();

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
     * Create a new instance.
     *
     * @param  array  $attributes
     * @param  Illuminate\Validation\Factory  $validator
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
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
        if ($this->isSluggable() && is_null($this->slug)) {
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

        while ($this->slugExists()) {
            $count++;
            $this->slug = Str::slug($this->$attr) . '-' . $count;
        }
    }

    /**
     * Checking if the slug exists
     */
    protected function slugExists()
    {
        $query = $this->where('slug', '=', $this->slug);

        if ($this->exists) {
            $query->where('id', '<>', $this->id);
        }

        return $query->first();
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

        throw new ModelNotFoundException();
    }

    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value === '' ? null : $value);
    }

    public static function seed($data)
    {
        if (! isset($data['id']) || ! $model = static::find($data['id'])) {
            $model = new static;
        }

        $model->fill($data);
        $model->save();
    }

    public function newCollection(array $models = array())
    {
        return new BaseCollection($models);
    }

    public function _setDateAttribute($field, $value, $format = 'd/m/Y')
    {
        try {
            $this->attributes[$field] = Carbon::createFromFormat($format, $value);
        } catch (InvalidArgumentException $e) {
            $this->attributes[$field] = null;
        }

    }
}
