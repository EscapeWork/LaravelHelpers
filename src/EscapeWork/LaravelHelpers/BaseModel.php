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

    public function findOrFailBy($field, $value)
    {
        if ($model = $this->where($field, '=', $value)->first()) {
            return $model;
        }

        throw new ModelNotFoundException();
    }

    public function scopeSearch($query, $field, $value)
    {
        $terms = explode(' ', $value);

        return $query->where($field, 'regexp', implode('.+', $terms));
    }

    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value === '' ? null : $value);
    }

    public static function seed($data)
    {
        $model  = new static;
        $traits = class_uses($model);

        if (in_array('Illuminate\Database\Eloquent\SoftDeletingTrait', $traits)) {
             if ($existing = static::withTrashed()->find($data['id'])) {
                $model = $existing;
             }
        } else {
            if ($existing = static::find($data['id'])) {
                $model = $existing;
             }
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

    public function _setCurrencyAttribute($field, $value, $type = 'BRL')
    {
        if ($value == '') {
            $this->attributes[$field] = null;
            return;
        }

        if (is_float($value)) {
            $this->attributes[$field] = $value;
            return;
        }

        switch ($type) {
            case 'BRL':
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);
                break;

            default:
                $value = floatval($value);
        }

        $this->attributes[$field] = (float) $value;
    }
}
