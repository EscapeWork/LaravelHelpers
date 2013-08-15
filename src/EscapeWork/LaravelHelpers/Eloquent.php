<?php namespace EscapeWork\LaravelHelpers;

use Illuminate\Database\Eloquent\Model;
use Str;
use Validator;

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
     * Validating the model fields
     */
    public function validate()
    {
        $fields     = $this->attributes;
        $validation = Validator::make($fields, static::$validationRules, static::$validationMessages);

        if ($validation->fails()) {
            $this->messageBag = $validation->messages();
            static::$messages = $this->messageBag->getMessages();
            
            return false;
        }

        return true;
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
}
