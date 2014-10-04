<?php namespace EscapeWork\LaravelHelpers;

use EscapeWork\LaravelHelpers\BaseCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use InvalidArgumentException;

abstract class BaseModel extends Model
{

    /**
     * Validation rules
     *
     * @var array
     */
    public $validationRules = [];

    /**
     * Validation messages
     *
     * @var array
     */
    public $validationMessages = [];

    /**
     * Sluggable attribute
     * @var  string
     */
    protected $sluggableAttr = 'title';

    /**
     * Variable to check if the model needs to make the slug when updating
     *
     * @var boolean
     */
    protected $makeSlugOnUpdate = true;

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
        if (! isset($data['id']) || ! $model = static::withTrashed()->find($data['id'])) {
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
