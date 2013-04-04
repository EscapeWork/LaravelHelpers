<?php 
namespace EscapeWork\LaravelHelpers;

use Illuminate\Database\Eloquent\Model as Model;
use \Validator;
use \Event;

class Eloquent extends Model
{

    # regras de validações
    public static $validationRules = array();

    # mensagens das validações
    public static $validationMessages = array();

    # mensagens das validações
    public static $messages = array();

    /**
     * Método de valicação
     */
    public static function validate( $fields )
    {
        $validation = Validator::make( $fields, static::$validationRules, static::$validationMessages );

        if( $validation->fails() )
        {
            static::$messages = $validation->messages()->getMessages();
            
            return false;
        }

        return true;
    }


    public function setDataFromArray(array $data)
    {
        foreach( $data as $attribute => $value )
        {
            $this->$attribute = $value;
        }
    }

    /**
     * Gerando um HTML Select com TODAS as opções
     *
     * @access  public 
     * @param   $id    int [com o ID atual]
     * @return  string [HTML Select]
     */
    public static function HTMLOptions( $id = null, $field = 'title', $all = null )
    {
        $class      = get_called_class();
        $object     = new $class;
        $primaryKey = $object->primaryKey;
        $all        = is_null( $all ) ? static::all() : $all;
        $html       = '';

        foreach( $all as $item )
        {
            $html .= '<option value="'.$item->$primaryKey.'" '.( $id == $item->$primaryKey ? 'selected="selected"' : null ).'>'.$item->$field.'</option>';
        }

        return $html;
    }

    /**
     * Reescrevendo a função Model::update para disparar um evento ao update
     */
    public function update(array $attributes = array())
    {
        Event::fire(get_called_class() . '.change', array('update'));

        return parent::update($attributes);
    }

    /**
     * Reescrevendo a função Model::save para disparar um evento ao deletar
     */
    public function save(array $options = array())
    {
        Event::fire(get_called_class() . '.change', array('save'));

        return parent::save();
    }

    /**
     * Reescrevendo a função Model::delete para disparar um evento ao excluir
     */
    public function delete()
    {
        Event::fire(get_called_class() . '.change', array('delete'));

        return parent::delete();
    }

    /**
     * Setando os campos do produto através de um array
     *
     * @access  public 
     * @return  void
     */
    public function setFields(array $fields = array())
    {
        if (! is_array($this->fillable) && count($this->fillable) == 0) {
            return;
        }
        
        foreach ($this->fillable as $field) {
            if (isset($fields[$field])) {
                $this->$field = $fields[ $field ];
            }
        }
    }
}
