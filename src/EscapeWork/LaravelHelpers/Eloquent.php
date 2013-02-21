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

    /**
     * putting data in a Object and returning it
     *
     * @static
     * @param  array  $data 
     * @return Object
     */
    public static function getDataFromArray(array $data)
    {
        $class = get_called_class();
        $object = new $class;

        foreach( $data as $attribute => $value )
        {
            $object->$attribute = $value;
        }

        return $object;
    }

    /**
     * Gerando um HTML Select com TODAS as opções
     *
     * @access  public 
     * @param   $id    int [com o ID atual]
     * @return  string [HTML Select]
     */
    public static function HTMLOptions( $id = null, $field = 'title' )
    {
        $all  = static::all();
        $html = '';

        foreach( $all as $item )
        {
            $html .= '<option value="'.$item->id.'" '.( $id == $item->id ? 'selected="selected"' : null ).'>'.$item->$field.'</option>';
        }

        return $html;
    }

    /**
     * Reescrevendo a função Model::create para disparar um evento ao inserir
     */
    public static function create(array $attributes)
    {
        Event::fire(get_called_class() . '.change', array('type' => 'create'));

        return parent::create($attributes);
    }

    /**
     * Reescrevendo a função Model::update para disparar um evento ao update
     */
    public function update(array $attributes = array())
    {
        Event::fire(get_called_class() . '.change', array('type' => 'update'));

        return parent::update($attributes);
    }

    /**
     * Reescrevendo a função Model::save para disparar um evento ao deletar
     */
    public function save()
    {
        Event::fire(get_called_class() . '.change', array('type' => 'save'));

        return parent::save();
    }

    /**
     * Reescrevendo a função Model::delete para disparar um evento ao excluir
     */
    public function delete()
    {
        Event::fire(get_called_class() . '.change', array('type' => 'delete'));

        return parent::delete();
    }
}